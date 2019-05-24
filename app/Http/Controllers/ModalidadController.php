<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modalidad;
use App\Posgrado;
use App\Periodo;
use DataTables;
use App\Http\Requests\modalidades\StoreModalidadRequest;
use DB;

class modalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this-> middleware('auth:admin');
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modalidad.crear');
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
                $path = public_path() .'/img/noticias/'. $image_name;
    
                file_put_contents($path, $data);
    
                $img->removeattribute('src');
                $img->setattribute('src', '/img/noticias/'.$image_name);
                $ultimaImagen = '/img/noticias/'.$image_name;
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
    public function update(Request $request, $id)
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
                $path = public_path() .'/img/noticias/'. $image_name;
    
                file_put_contents($path, $data);
    
                $img->removeattribute('src');
                $img->setattribute('src', '/img/noticias/'.$image_name);
                $ultimaImagen = '/img/noticias/'.$image_name;
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
        //
    }
    public function modalidad(){
        return view('admin.modalidad.adminModalidades');
        
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
}
