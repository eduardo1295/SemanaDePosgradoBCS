<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modalidad;
use App\Semana;
use App\Posgrado;
use App\Periodo;
use App\Institucion;
use App\Trabajo;
use App\Sesion;
use DataTables;
use App\Http\Requests\modalidades\StoreModalidadRequest;
use App\Http\Requests\modalidades\UpdateModalidadRequest;
use DB;
use App;
use File;
use Jenssegers\Date\Date;
use Dompdf\Dompdf;

class modalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this-> middleware('auth:admin')->only(['modalidad']);
    }
    public function index()
    {
        
        $instituciones = DB::select(DB::raw("
        SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,
		 instituciones.siglas, instituciones.telefono, instituciones.direccion_web,
		 instituciones.url_logo, instituciones.ciudad, 
		 CONCAT(instituciones.calle,' #', instituciones.numero, ', col. ', instituciones.colonia , ', C.P.', instituciones.cp) AS domicilio,
		 (SELECT CONCAT(users.nombre,' ', users.primer_apellido, ' ', users.segundo_apellido) 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS coordinador_nombre,
		 (SELECT email 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS email
         FROM instituciones;
         "));
        $semana = Semana::select('id_semana as id','url_logo','url_convocatoria')->where('vigente',1)->first();
        //$modalidades = Modalidad::select('id_modalidad','nombre','descripcion')->get();
        $modalidades = Modalidad::with('niveles')->get();
        //$periodos = Posgrado::with('periodos')->get();
        //use Illuminate\Support\Arr;
        $tabla = "";
        $columnasPosbles =["Maestría (Trimestre)","Maestría (Cuatrimestre)","Maestría (Semestre)","Doctorado (Trimestre)","Doctorado (Cuatrimestre)","Doctorado (Semestre)"];
        $columnas = [];
        $columasFinal = [];
        $aux_per = array();
        $i=0;
        $bandera = true;
        foreach ($modalidades as $modalidad){
            if(isset($modalidad->niveles)){
                foreach ($modalidad->niveles as $datos) {
                    $nueva_columna = $datos->grado .' ('. $datos->periodo.')';
                    //echo $nueva_columna.'+';
                    $bandera = true;
                    for ($x=0; $x < count($columnas) ; $x++) { 
                        if($columnas[$x] == $nueva_columna){
                            $bandera = false;
                        }
                    }
                    if($bandera){
                    //
                    array_push($columnas,$nueva_columna);
                    }
                }
                $bandera = true;
                //$datata =array( 'holo' => [] );
                array_push($aux_per, []);
            }
            $i++;
        }
        for ($bx=0; $bx < count($columnasPosbles) ; $bx++) { 
            for ($cx=0; $cx <count($columnas) ; $cx++) { 
                if($columnas[$cx] ==$columnasPosbles[$bx]){
                    array_push($columasFinal,$columnas[$cx]);
                    $tabla .= '<th scope="col" class="text-center">'.$columnas[$cx].'</th>';
                    break;
                }
            }
        }
        //dd($columasFinal);
        for ($x=0; $x < $i ; $x++){
            for ($j=0; $j < count($columasFinal) ; $j++){
                array_push($aux_per[$x],"<td></td>");
            }
        }
        
        $tabla .= '</tr></thead><tbody>';
        $j=0;
        $nombreModalidaddes = [];
        foreach ($modalidades as $modalidad) {
            array_push($nombreModalidaddes,$modalidad->nombre);
            foreach ($modalidad->niveles as $datos) {
                $nombre = $datos->grado .' ('. $datos->periodo.')';
                //dd($columnas);
                for ($i=0; $i < count($columasFinal) ; $i++) { 
                    if($columasFinal[$i] == $nombre){
                        $aa = Posgrado::find($datos->id)->periodos()->get();
                        $aux_per[$j][$i] = '<td class="text-center">'.$aa[0]->periodo_min. '-'.$aa[0]->periodo_max.'</td>' ;
                    }
                }
            }
            $j++;
        }
        for ($i=0; $i < count($aux_per) ; $i++) { 
            $tabla .= '<tr>';
            $tabla .= '<th scope="row" class="aModalidad">'. $nombreModalidaddes[$i].'</th>';
            for ($x=0; $x < count($aux_per[$i]) ; $x++) { 
                $tabla .= $aux_per[$i][$x];
            }
            $tabla.= '</tr>';
        }
        $tabla .= '</tbody>';
        
        
        
        return view('admin.semana.verModalidades', compact(['semana','instituciones','modalidades','tabla']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModalidadRequest $request)
    {   
        


        $dom = new \domdocument();
        $dom->loadHtml('<?xml encoding="utf-8" ?>'.$request->contenido, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getelementsbytagname('img');
        $ultimaImagen ="";
        foreach($images as $k => $img){
            $data = $img->getattribute('src');
            $ultimaImagen = $data;
            if (substr($data, 0, 5) == 'data:') {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
    
                $data = base64_decode($data);
                $image_name= time().$k.'.png';
                $path = public_path() .'/img/modalidades/'. $image_name;
    
                file_put_contents($path, $data);
    
                $img->removeattribute('src');
                $img->setattribute('src', '/img/modalidades/'.$image_name);
                $ultimaImagen = '/img/modalidades/'.$image_name;
            }
        }
 
        $detail = $dom->savehtml();
        $modalidad = new Modalidad;
        $modalidad->nombre = $request->nombres;
        $modalidad->descripcion = $detail;
        $modalidad->creado_por= auth('admin')->user()->id;
        $modalidad->save();

        for ($a=0; $a < count($request->posgrado) ; $a++) { 
            $posgrado = new Posgrado;
            $posgrado->id_modalidad = $modalidad->id_modalidad;
            $posgrado->grado = $request->posgrado[$a];
            $posgrado->periodo = $request->periodo[$a];
            $posgrado->creado_por= auth('admin')->user()->id;

           /* $posgrados[] = new Posgrado(['id_modalidad' => $request->id_modalidad, 
                            'grado' => $request->posgrado[$a], 'periodo' => $request->periodo[$a],
                            'creado_por' => auth('admin')->user()->id]);*/
            $posgrado->save();

            $periodo = new Periodo;
            $periodo->id_posgrado = $posgrado->id;
            $periodo->periodo_min = $request->slider[$a][0];
            $periodo->periodo_max = $request->slider[$a][1];
            $periodo->save();
        }
        return \Response::json('listo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$modalidad = Modalidad::all()->where('id_modalidad',1)->get();
        $periodo = array();
        $modalidad = Modalidad::find($id);
        $posgrado = $modalidad->niveles()->get();
        //$ab = $posgrado->periodos()->get();
        foreach ($posgrado as $posgr) {
            $periodoo = $posgr->periodos()->get();
            foreach ($periodoo as $peri) {
                //dd($peri);
                array_push($periodo,$peri);
            }
        }
        
        
        //dd($aux[1]->periodo_max);
        //$v =[$alv,$modalidad];
        return \Response::json(['modalidad'=> $modalidad,'posgrado' => $posgrado,'periodo'=> $periodo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModalidadRequest $request, $id)
    {
        $dom = new \domdocument();
        $removerXML = str_replace('<!--?xml encoding="utf-8" ?-->','',$request->contenido);
        $dom->loadHtml('<?xml encoding="utf-8" ?>'.$removerXML, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getelementsbytagname('img');
        $ultimaImagen ="";
        foreach($images as $k => $img){
            $data = $img->getattribute('src');
            $ultimaImagen = $data;
            if (substr($data, 0, 5) == 'data:') {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
    
                $data = base64_decode($data);
                $image_name= time().$k.'.png';
                $path = public_path() .'/img/modalidades/'. $image_name;
    
                file_put_contents($path, $data);
    
                $img->removeattribute('src');
                $img->setattribute('src', '/img/modalidades/'.$image_name);
                $ultimaImagen = '/img/modalidades/'.$image_name;
            }
        }
 

        $detail = $dom->savehtml();
        $modalidad = Modalidad::find($id);
        $modalidad->nombre = $request->nombres;
        $modalidad->descripcion = $detail;
        $modalidad->save();

        $posgrado = $modalidad->niveles()->get();
        foreach ($posgrado as $posgr) {
            $periodoo = $posgr->periodos()->delete();
        }
        $modalidad->niveles()->delete();
        for ($a=0; $a < count($request->posgrado) ; $a++) { 
            $posgrado = new Posgrado;
            $posgrado->id_modalidad = $modalidad->id_modalidad;
            $posgrado->grado = $request->posgrado[$a];
            $posgrado->periodo = $request->periodo[$a];
            $posgrado->creado_por= auth('admin')->user()->id;

           /* $posgrados[] = new Posgrado(['id_modalidad' => $request->id_modalidad, 
                            'grado' => $request->posgrado[$a], 'periodo' => $request->periodo[$a],
                            'creado_por' => auth('admin')->user()->id]);*/
            $posgrado->save();

            $periodo = new Periodo;
            $periodo->id_posgrado = $posgrado->id;
            $periodo->periodo_min = $request->slider[$a][0];
            $periodo->periodo_max = $request->slider[$a][1];
            $periodo->save();
        }
        return \Response::json('listo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modalidad = Modalidad::find($id);
        /*
        $posgrado = $modalidad->niveles()->get();
        foreach ($posgrado as $posgr) {
            $periodoo = $posgr->periodos()->delete();
        }
        $modalidad->niveles()->delete();
        */
        $modalidad->delete();

    }
    public function modalidad(){
        $semana = Semana::select('id_semana','nombre','url_logo')->where('vigente',1)->first();
        return view('admin.modalidad.adminModalidades',compact(['semana']));
        
    }
    public function listModalidad(Request $request ){
        $busqueda = $request->busqueda;
        if($busqueda == 'activos'){
            $selectnoticias = Modalidad::select('id_modalidad as id','nombre','descripcion','fecha_actualizacion');
            return datatables()->of($selectnoticias)
            ->addColumn('action', 'admin.acciones')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $selectnoticias = Modalidad::onlyTrashed()->get(['id_modalidad as id','nombre','descripcion','fecha_actualizacion']);
            return datatables()->of($selectnoticias)
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
    public function mostrarModalidad($nombre){
        $instituciones = DB::select(DB::raw("
        SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,
		 instituciones.siglas, instituciones.telefono, instituciones.direccion_web,
		 instituciones.url_logo, instituciones.ciudad, 
		 CONCAT(instituciones.calle,' #', instituciones.numero, ', col. ', instituciones.colonia , ', C.P.', instituciones.cp) AS domicilio,
		 (SELECT CONCAT(users.nombre,' ', users.primer_apellido, ' ', users.segundo_apellido) 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS coordinador_nombre,
		 (SELECT email 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS email
         FROM instituciones;
         "));
        $semana = Semana::select('id_semana as id','url_logo','url_convocatoria')->where('vigente',1)->first();
        return view('modalidad.mostrarModalidad',compact(['semana','instituciones','nombre']));
    }

    
}
