<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\semanas\StoreSemanaRequest;
use App\Http\Requests\semanas\UpdateSemanaRequest;
use App\Semana;
use App\Noticia;
use App\Institucion;
use App\User;
use App\Modalidad;
use App\Posgrado;
use DB;
use App\Carrusel;
use Auth;
use App\VistaLogin;
use Illuminate\Support\Str as Str;
use Jenssegers\Date\Date;
use Carbon\Carbon;

class SemanaController extends Controller
{

    public function __construct(){
        $this-> middleware('auth:admin')->only(['indexAdmin']);
        //$this-> middleware('auth:admin')->only();
        

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $semana = Semana::select('id_semana','nombre','desc_general','url_logo','url_convocatoria','id_sede','fecha_inicio',DB::raw("(DATE_FORMAT(fecha_inicio,'%Y-%m-%d'))as n") ,'fecha_fin')->where('vigente',1)->first();
        //dd($semana->n);
        $fInicio = $semana->fecha_inicio;
        $fInicio = str_replace('-','',$fInicio);
        //dd($semana->fecha_fin);
        $fFin = $semana->fecha_fin;
        $fFin = str_replace('-','',$fFin);
        /*$datetimeI = DateTime::createFromFormat('Ymd', $fInicio );
        $datetimeF = DateTime::createFromFormat('Ymd', $fFin);
        setlocale(LC_TIME,'es_ES.UTF-8');
        $date = Carbon::now();
        */
        //dd(Carbon::parse("2018-03-20")->formatLocalized('%d %B %Y'));
        //dd(Date::now()->format( ' lj FYH: i: s ' ));
        //dd($cadena->formatLocalized('l'));
        $fInicio = new Date($semana->fecha_inicio);
        $fFin = new Date($semana->fecha_fin);
        $fInicio = $fInicio->format('l d').' de '.$fInicio->format('F');
        $fFin = $fFin->format('l, d').' de '.$fFin->format('F').' del '.$fFin->format('Y');
        
        //$cadena->format('l'); 

        //$cadena = $datetimeI->format('l').$datetimeF->format('l');
        $noticias = Noticia::latest('fecha_actualizacion')->take(3)->get();
        //$instituciones = Institucion::select('id','nombre','url_logo','latitud','longitud','telefono','direccion_web',DB::raw("CONCAT(calle,' #', numero, ', col. ', colonia , ', C.P.', cp) as domicilio "))->get();
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

        
        $institucionSede =  Institucion::select('id','nombre','url_logo','sede','latitud','longitud')->where('sede', 1)->first();
        $carrusel = Carrusel::select('id','link_web','url_imagen')->get();
        //dd(Auth::guard()->user());
        $vistas = VistaLogin::All();
        return view('Maqueta2', compact(['semana','noticias','instituciones','institucionSede','carrusel','cadena','fInicio','fFin','vistas']));
    }

    public function indexAdmin()
    {
        $instituciones = Institucion::select('id','nombre')->get();
        return view('admin.index',compact(['instituciones']));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSemanaRequest $request)
    {
        $dom = new \domdocument();
        $dom->loadHtml('<?xml encoding="utf-8" ?>'.$request->contenido, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $images = $dom->getelementsbytagname('img');
 
        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        
        foreach($images as $k => $img){
            $data = $img->getattribute('src');
            if (substr($data, 0, 5) == 'data:') {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
    
                $data = base64_decode($data);
                $image_name= time().$k.'.png';
                $path = public_path() .'/img/semanaDesGe/'. $image_name;
    
                file_put_contents($path, $data);
    
                $img->removeattribute('src');
                $img->setattribute('src', '/img/semanaDesGe/'.$image_name);
            }
        }
 
        $fechas = explode(" - ", $request->fecha);
        $fechaArchivo = date("Y");
        $nuevo_nombre = 'logo_evento.png';
        if($request->hasFile('imagensemana')){
            $imagenLogo = $request->file('imagensemana');
            $nuevo_nombre = 'logo_' . $fechaArchivo . '.' . $imagenLogo->getClientOriginalExtension();
            $imagenLogo->move(public_path('img/semanaLogo'), $nuevo_nombre);
        }

        $nuevo_convocatoria = 'no_disponible';
        if($request->hasFile('convocatoria')){
            $convocactoriaA = $request->file('convocatoria');
            //$fileName = pathinfo($convocactoriaA->getClientOriginalName(),PATHINFO_FILENAME);
            //$nuevo_convocatoria = Str::slug($fileName."_". date("m-d-Y_h-i-s") .'.'. $convocactoriaA->getClientOriginalExtension());
            $nombreEvento = Str::slug($request->nombre);
            $nuevo_convocatoria = 'Convocatoria_SemanaDePosgradoBCS_'.$fechaArchivo .'.' . $convocactoriaA->getClientOriginalExtension();
            //$nuevo_convocatoria = $urlAmigable;
            $convocactoriaA->move(public_path('pdf/convocatoria'), $nuevo_convocatoria);
        }

        $detail = $dom->savehtml();
        
        $semana = new Semana;
        
        $semana->id_sede = $request->id_institucion;
        $semana->nombre = $request->nombre;
        $semana->desc_general = $detail;
        $semana->fecha_inicio = $fechas[0];
        $semana->fecha_fin = $fechas[1];
        $semana->url_logo = $nuevo_nombre;
        
        $semana->url_convocatoria = $nuevo_convocatoria;
        $semana->vigente= 1;
        $semana->creado_por= auth('admin')->user()->id;
        $semana->save();
        if($semana){
            DB::table('semanas')
            ->where('vigente', 1)
            ->where('id_semana','!=',$semana->id_semana)
            ->update(['vigente' => 0]);
            DB::table('instituciones')
            ->where('sede', 1)
            ->where('id','!=',$request->id_institucion)
            ->update(['sede' => 0]);
            DB::table('instituciones')
            ->where('id',$request->id_institucion)
            ->update(['sede' => 1]);
            DB::table('rol_usuario')
            ->where('id_rol',2)
            ->delete();
            $buscarUsuario = DB::select("SELECT users.id FROM rol_usuario ,users WHERE id_institucion = ? AND users.id = rol_usuario.id_usuario AND rol_usuario.id_rol = 3;", [$request->id_institucion]);
            DB::table('rol_usuario')->insert(
                ['id_usuario' => $buscarUsuario[0]->id, 'id_rol' => 2]
            );
        }
        return \Response::json($semana);
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
        if(!auth()->user() && !auth('admin')->user()){
            return abort(403);
        }
        $semana = Semana::select('id_semana','nombre','desc_general','url_logo','url_convocatoria','id_sede','fecha_inicio','fecha_fin',DB::raw("CONCAT(fecha_inicio,' - ',fecha_fin) AS fecha"))->with('instituciones:id,nombre')->where('id_semana',$id)->first();
        return \Response::json($semana);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSemanaRequest $request, $id)
    {
        $semana = Semana::where('id_semana', $id)->first();
        $dom = new \domdocument();
        $removerXML = str_replace('<!--?xml encoding="utf-8" ?-->','',$request->contenido);
        
        $dom->loadHtml('<?xml encoding="utf-8" ?>'.$removerXML, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $images = $dom->getelementsbytagname('img');
 
        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.

        foreach($images as $k => $img){
            $data = $img->getattribute('src');
            if (substr($data, 0, 5) == 'data:') {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
    
                $data = base64_decode($data);
                $image_name= time().$k.'.png';
                $path = public_path() .'/img/semanaDesGe/'. $image_name;
    
                file_put_contents($path, $data);
    
                $img->removeattribute('src');
                $img->setattribute('src', '/img/semanaDesGe/'.$image_name);
            }
        }
        $fechas = explode(" - ", $request->fecha);
        $fechaArchivo = date("Y");

        $nuevo_nombre = 'logo_evento.png';
        if($request->hasFile('imagensemana')){
            $imagenLogo = $request->file('imagensemana');
            //$nuevo_nombre = date("m-d-Y_h-i-s"). $imagenLogo->getClientOriginalExtension();
            $nuevo_nombre = 'logo_' . $fechaArchivo . '.' . $imagenLogo->getClientOriginalExtension();
            $imagenLogo->move(public_path('img/semanaLogo'), $nuevo_nombre);
        }else{
            $nuevo_nombre = $semana->url_logo;
        }

        $nuevo_convocatoria = 'no_disponible';
        if($request->hasFile('convocatoria')){
            
            $convocactoriaA = $request->file('convocatoria');
            $fileName = pathinfo($convocactoriaA->getClientOriginalName(),PATHINFO_FILENAME);
            //$nuevo_convocatoria = Str::slug($fileName."_". date("m-d-Y_h-i-s") .'.'. $convocactoriaA->getClientOriginalExtension());
            //$nuevo_convocatoria = 'Convocatoria'.'_'. date("Y") .'.' . $convocactoriaA->getClientOriginalExtension();
            //$nombreEvento = Str::slug($request->nombre);
            //$nuevo_convocatoria = 'Convocatoria'.'_'.$nombreEvento ."_". date("m-d-Y_h-i-s") .'.' . $convocactoriaA->getClientOriginalExtension();
            $nuevo_convocatoria = 'Convocatoria_SemanaDePosgradoBCS_'.'_'.$fechaArchivo .'.' . $convocactoriaA->getClientOriginalExtension();
            $convocactoriaA->move(public_path('pdf/convocatoria'), $nuevo_convocatoria);
            
        }
        else{
            $nuevo_convocatoria = $semana->url_convocatoria;
        }
        if($request->id_institucion!=""){
            $semana->id_sede = $request->id_institucion;
        }
        $detail = $dom->savehtml();
        
        
        
        $semana->nombre = $request->nombre;
        $semana->desc_general = $detail;
        $semana->fecha_inicio = $fechas[0];
        $semana->fecha_fin = $fechas[1];
        $semana->url_logo = $nuevo_nombre;
        $semana->url_convocatoria = $nuevo_convocatoria;
        $semana->vigente= 1;
        $semana->actualizado_por= auth('admin')->user()->id;
        $semana->save();
        /*if($semana){
            DB::table('semanas')
            ->where('vigente', 1)
            ->where('id_semana','!=',$semana->id_semana)
            ->update(['vigente' => 0]);
            DB::table('instituciones')
            ->where('sede', 1)
            ->where('id','!=',$request->id_institucion)
            ->update(['sede' => 0]);
            DB::table('instituciones')
            ->where('id',$request->id_institucion)
            ->update(['sede' => 1]);
            DB::table('rol_usuario')
            ->where('id_rol',2)
            ->delete();
        }*/
        if($semana){
            DB::table('semanas')
            ->where('vigente', 1)
            ->where('id_semana','!=',$semana->id_semana)
            ->update(['vigente' => 0]);
            DB::table('instituciones')
            ->where('sede', 1)
            ->where('id','!=',$request->id_institucion)
            ->update(['sede' => 0]);
            DB::table('instituciones')
            ->where('id',$request->id_institucion)
            ->update(['sede' => 1]);
            DB::table('rol_usuario')
            ->where('id_rol',2)
            ->delete();
            $buscarUsuario = DB::select("SELECT users.id FROM rol_usuario ,users WHERE id_institucion = ? AND users.id = rol_usuario.id_usuario AND rol_usuario.id_rol = 3;", [$request->id_institucion]);
            if(count($buscarUsuario)>0)
            DB::table('rol_usuario')->insert(
                ['id_usuario' => $buscarUsuario[0]->id, 'id_rol' => 2,'fecha_creacion' => date("Y-m-d H:i:s"), 'fecha_actualizacion' => date("Y-m-d H:i:s")]
            );
        }
        return \Response::json($semana);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $semana = Semana::where('id_semana',$id)->delete();
        return \Response::json($semana);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listSemanas(Request $request ){
        $busqueda = $request->busqueda;
        $semanas = DB::select(DB::raw('SELECT id_semana AS id, id_sede, semanas.nombre AS semana_nombre, url_convocatoria,'.
            ' fecha_inicio, fecha_fin, semanas.creado_por, semanas.actualizado_por, semanas.fecha_actualizacion, '.
            ' instituciones.nombre AS institucion_nombre'.
            ' FROM semanas, instituciones'.
            ' WHERE semanas.id_sede = instituciones.id'));

        $selectsemanas = Semana::select('id_semana as id','id_sede','nombre','url_convocatoria',DB::raw("(DATE_FORMAT(fecha_inicio,'%Y-%m-%d'))as fecha_inici"),DB::raw("(DATE_FORMAT(fecha_fin,'%Y-%m-%d'))as fecha_fi"),'creado_por','actualizado_por','fecha_actualizacion')->with('instituciones:instituciones.id,instituciones.nombre');
        
        return datatables()->of($semanas)
        ->addColumn('action', 'admin.acciones')
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->toJson();
        
    }

    public function vistaPrevia(Request $noticia){
    }

    public function verConvocatoria(){
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
        
        return view('admin.semana.verConvocatoria', compact(['semana','instituciones']));
    }

    public function verModalidades(){
        $instituciones = Institucion::select('id','nombre','url_logo','latitud','longitud','telefono','direccion_web',DB::raw("CONCAT(calle,' #', numero, ', col. ', colonia , ', C.P.', cp) as domicilio "))->get();
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

    
     
}
