<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Semana;
use App\Noticia;
use App\Institucion;
use App\User;
use DB;
use App\Carrusel;
use Auth;
use Illuminate\Support\Str as Str;

class SemanaController extends Controller
{
    public function __construct(){
        $this-> middleware('auth:admin')->only('indexAdmin');
        $this-> middleware('auth:admin')->only('noticias');
        

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semana = Semana::select('id_semana','nombre','desc_general','url_logo','url_convocatoria','id_sede')->where('vigente',1)->first();
        $noticias = Noticia::latest('fecha_creacion')->take(3)->get();
        $instituciones = Institucion::select('id','nombre','url_logo','latitud','longitud','telefono','direccion_web',DB::raw("CONCAT(calle,' #', numero, ', col. ', colonia , ', C.P.', cp) as domicilio "))->get();
        $institucionSede =  Institucion::select('id','nombre','url_logo','sede','latitud','longitud')->where('sede', 1)->first();
        $carrusel = Carrusel::select('id','link_web','url_imagen')->get();
        //dd(Auth::guard()->user());
        
        return view('Maqueta2', compact(['semana','noticias','instituciones','institucionSede','carrusel']));
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
    public function store(Request $request)
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
 
        $nuevo_nombre = 'no_logo.png';
        if($request->hasFile('imagensemana')){
            $imagenLogo = $request->file('imagensemana');
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->nombre . '.' . $imagenLogo->getClientOriginalExtension();
            $imagenLogo->move(public_path('img/semanaLogo'), $nuevo_nombre);
        }

        $nuevo_convocatoria = 'no_disponible';
        if($request->hasFile('convocatoria')){
            $convocactoriaA = $request->file('convocatoria');
            $urlAmigable = Str::slug($convocactoriaA->getClientOriginalName().'.'. $convocactoriaA->getClientOriginalExtension());
            //$nuevo_convocatoria = 'Convocatoria'.'_'.$request->nombre ."_". date("m-d-Y_h-i-s") .'.' . $convocactoriaA->getClientOriginalExtension();
            $nuevo_convocatoria = $urlAmigable;
            $convocactoriaA->move(public_path('pdf/convocatoria'), $urlAmigable);
        }

        $detail = $dom->savehtml();
        
        $semana = new Semana;
        $fechas = explode(" - ", $request->fecha);
        $semana->id_sede = $request->id_institucion;
        $semana->nombre = $request->nombre;
        $semana->desc_general = $detail;
        $semana->fecha_inicio = $fechas[0];
        $semana->fecha_fin = $fechas[1];
        $semana->desc_general = $detail;
        $semana->url_logo = $nuevo_nombre;
        
        $semana->url_convocatoria = $nuevo_convocatoria;
        $semana->vigente= 1;
        $semana->creado_por= 1;
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
        $semana = Semana::select('id_semana','nombre','desc_general','url_logo','url_convocatoria','id_sede',DB::raw("CONCAT(fecha_inicio,' - ',fecha_fin) AS fecha"))->with('instituciones:id,nombre')->where('id_semana',$id)->first();
        return \Response::json($semana);
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
        $semana = Semana::where('id_semana', $id)->first();
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
 
        $nuevo_nombre = 'no_logo.png';
        if($request->hasFile('imagensemana')){
            $imagenLogo = $request->file('imagensemana');
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->nombre . '.' . $imagenLogo->getClientOriginalExtension();
            $imagenLogo->move(public_path('img/semanaLogo'), $nuevo_nombre);
        }else{
            $nuevo_nombre = $semana->url_logo;
        }

        $nuevo_convocatoria = 'no_disponible';
        if($request->hasFile('convocatoria')){
            $convocactoriaA = $request->file('convocatoria');
            $nuevo_convocatoria = 'Convocatoria'.'_'. date("Y") .'.' . $convocactoriaA->getClientOriginalExtension();
            $convocactoriaA->move(public_path('pdf/convocatoria'), $nuevo_convocatoria);
        }
        else{
            $nuevo_convocatoria = $semana->url_convocatoria;
        }
        if($request->id_institucion==""){
            $semana->id_sede = $semana->id_sede;
        }
        else{
            $semana->id_sede = $request->id_institucion;
        }
        $detail = $dom->savehtml();
        
        $fechas = explode(" - ", $request->fecha);
        
        $semana->nombre = $request->nombre;
        $semana->desc_general = $detail;
        $semana->fecha_inicio = $fechas[0];
        $semana->fecha_fin = $fechas[1];
        $semana->desc_general = $detail;
        $semana->url_logo = $nuevo_nombre;
        $semana->url_convocatoria = $nuevo_convocatoria;
        $semana->vigente= 1;
        $semana->creado_por= 1;
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
        $selectsemanas = Semana::select('id_semana as id','id_sede','nombre','url_convocatoria','fecha_inicio','fecha_fin','creado_por','actualizado_por','fecha_actualizacion')->with('instituciones:id,nombre');
    
        return datatables()->of($selectsemanas)
        ->addColumn('action', 'admin.acciones')
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->toJson();
        
    }

    public function vistaPrevia(Request $noticia){
    }

    public function verConvocatoria(){
        $instituciones = Institucion::select('id','nombre','url_logo','latitud','longitud','telefono','direccion_web',DB::raw("CONCAT(calle,' #', numero, ', col. ', colonia , ', C.P.', cp) as domicilio "))->get();
        $semana = Semana::select('id_semana as id','url_logo','url_convocatoria')->where('vigente',1)->first();
        
        return view('admin.semana.verConvocatoria', compact(['semana','instituciones']));
    }
     
}
