<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Noticia;
use App\Institucion;
use App\Semana;
use DB;
use App\Http\Requests\noticias\StoreNoticiaRequest;
use App\Http\Requests\noticias\UpdateNoticiaRequest;
use Illuminate\Support\Facades\File;

use Mews\Purifier\Purifier;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct(){
        
        $this->middleware(['admin.auth:admin','verificarcontrasena','admin.verified'])->only('noticias');
        //$this->middleware('admin.auth:admin')->only(['create']);
         //$this-> middleware('auth:admin')->only('noticias');
         $this-> middleware(['esusuario'])->only(['store','update','edit','destroy']);
     }
    public function index()
    {
        $semana = Semana::select('id_semana','nombre','desc_general','url_logo','url_convocatoria','id_sede')->where('vigente',1)->first();
        $instituciones = DB::select(DB::raw("
        SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,
		 instituciones.siglas, instituciones.telefono, instituciones.direccion_web,
		 instituciones.url_logo, instituciones.ciudad, 
		 CONCAT(instituciones.calle,' #', instituciones.numero, ', col. ', instituciones.colonia , ', C.P.', instituciones.cp) AS domicilio,
		 (SELECT CONCAT(users.nombre,' ', users.primer_apellido, ' ', users.segundo_apellido) 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS coordinador_nombre,
		 (SELECT email 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS email
         FROM instituciones WHERE deleted_at IS NULL;
         "));
        $data = Noticia::latest('fecha_actualizacion')->paginate(5);
        return view('noticias.verNoticias', compact(['data','instituciones','semana']));
        //return view('noticias', compact('data'));
    }

    public function fetch_data(Request $request)
    {
     if($request->ajax())
     {
        $data = Noticia::latest('fecha_creacion')->paginate(5);
      return view('noticias.paginacionNoticias', compact('data'))->render();
     }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('noticias.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoticiaRequest $request)
    {
        
        /*
        $nuevo_nombre = 'sin imagen';
        if($request->hasFile('imgnoticia')){
            
            $imagennoticia = $request->file('imgnoticia');
            //agregar id de usuarios a nombre
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_noticia . '.' . $imagennoticia->getClientOriginalExtension();
            $imagennoticia->move(public_path('img/noticias'), $nuevo_nombre);
        }
        */
        if($request->ajax()){
        $semana = Semana::select('id_semana','url_logo')->where('vigente',1)->firstOrFail();
        
        $noticia = new Noticia;
        $noticia->contenido = 'temporal';
        $noticia->titulo = $request->titulo;
        $noticia->url_imagen = 'temporal';
        $noticia->resumen = $request->resumen;
        $noticia->creada_por= 1;
        $noticia->save();

        $dom = new \domdocument();
        $dom->loadHtml('<?xml encoding="utf-8" ?>'.$request->contenido, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $images = $dom->getelementsbytagname('img');
 
        $pathDirectorio = public_path('img\\noticias').'\\'.$noticia->id_noticia;
        //dd($pathDirectorio);
        if(count($images)>0){
            /*if(!File::isDirectory($pathDirectorio)){
                File::makeDirectory($pathDirectorio, 0777, true, true);
            }*/
            
            if(!is_dir($pathDirectorio)){
                //File::makeDirectory($pathDirectorio);
                mkdir($pathDirectorio);
                
            }
        }
        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        $ultimaImagen ="";
        foreach($images as $k => $img){
            $data = $img->getattribute('src');
            $ultimaImagen = $data;
            if (substr($data, 0, 5) == 'data:') {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
    
                $data = base64_decode($data);
                $image_name= time().$k.'.png';
                $path = public_path() .'/img/noticias/'.$noticia->id_noticia.'/'. $image_name;
    
                //$path = $pathDirectorio. '/' . $image_name;
                
                file_put_contents($path, $data);
    
                $img->removeattribute('src');
                
                //$ultimaImagen = '/img/noticias/'.$image_name;

                $img->setattribute('src', '/img/noticias/'.$noticia->id_noticia.'/'.$image_name);
                //$ultimaImagen = $pathDirectorio. '/' .$image_name;
                $ultimaImagen = '/img/noticias/'.$noticia->id_noticia.'/'.$image_name;
            }
        }
        if($ultimaImagen == ""){
            $ultimaImagen = '/img/noticias/logo_noticias.png';
        }
        $detail = $dom->savehtml();

        $noticia->contenido = $detail;
        $noticia->url_imagen = $ultimaImagen;
        $noticia->save();
        
        return \Response::json($noticia);
    }else{
        return abort(403);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $semana = Semana::select('id_semana','nombre','desc_general','url_logo','url_convocatoria','id_sede')->where('vigente',1)->first();
        $instituciones = DB::select(DB::raw("
        SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,
		 instituciones.siglas, instituciones.telefono, instituciones.direccion_web,
		 instituciones.url_logo, instituciones.ciudad, 
		 CONCAT(instituciones.calle,' #', instituciones.numero, ', col. ', instituciones.colonia , ', C.P.', instituciones.cp) AS domicilio,
		 (SELECT CONCAT(users.nombre,' ', users.primer_apellido, ' ', users.segundo_apellido) 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS coordinador_nombre,
		 (SELECT email 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS email
         FROM instituciones WHERE deleted_at IS NULL;
         "));
        $noticia  = Noticia::select('id_noticia','titulo','contenido','url_imagen','fecha_actualizacion')->where('id_noticia', $id)->firstOrFail();
        return view('noticias.detalle', compact(['noticia','instituciones','semana']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $noticia  = Noticia::where('id_noticia', $id)->first();
        return \Response::json($noticia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNoticiaRequest $request, $id)
    {
        if($request->ajax()){
        $noticia  = Noticia::where('id_noticia', $id)->first();
        
        /*
        $nuevo_nombre = 'no_logo.png';
        if($request->hasFile('imgnoticia')){
            $imagennoticia = $request->file('imgnoticia');
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_noticia . '.' . $imagennoticia->getClientOriginalExtension();
            $imagennoticia->move(public_path('img/noticias'), $nuevo_nombre);
        }else{
            $nuevo_nombre = $noticia->url_imagen;
        }
        */
        
        $semana = Semana::select('id_semana','url_logo')->where('vigente',1)->firstOrFail();
        $dom = new \domdocument();
        $removerXML = str_replace('<!--?xml encoding="utf-8" ?-->','',$request->contenido);
        
        
        $dom->loadHtml('<?xml encoding="utf-8" ?>'.$removerXML, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        $images = $dom->getelementsbytagname('img');
        $ultimaImagen ="";

        $pathDirectorio = public_path('img\\noticias').'\\'.$noticia->id_noticia;
        //dd($pathDirectorio);
        if(count($images)>0){
            /*if(!File::isDirectory($pathDirectorio)){
                File::makeDirectory($pathDirectorio, 0777, true, true);
            }*/
            if(!is_dir($pathDirectorio)){
                //File::makeDirectory($pathDirectorio);
                mkdir($pathDirectorio);
                
            }
        }

        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        foreach($images as $k => $img){
            $data = $img->getattribute('src');
            $ruta = explode('/',$data);
            
            $ultimaImagen = '/img/noticias/'. $noticia->id_noticia . '/' . $ruta[4];
            
            if (substr($data, 0, 5) == 'data:') {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
    
                $data = base64_decode($data);
                $image_name= time().$k.'.png';
                $path = public_path() .'/img/noticias/'.$noticia->id_noticia.'/'. $image_name;
    
                file_put_contents($path, $data);
    
                $img->removeattribute('src');
                
                //$ultimaImagen = '/img/noticias/'.$image_name;

                $img->setattribute('src', '/img/noticias/'.$noticia->id_noticia.'/'.$image_name);
                $ultimaImagen = '/img/noticias/'.$noticia->id_noticia.'/'.$image_name;
            }
        }
        if($ultimaImagen == ""){
            $ultimaImagen = '/img/noticias/logo_noticias.png';
        }
 
        $detail = $dom->savehtml();
        
        $noticia->contenido = $detail;
        $noticia->titulo = $request->titulo;
        $noticia->url_imagen = $ultimaImagen;
        $noticia->resumen = $request->resumen;
        
        $noticia->save();
        if($noticia){
            //borrar imagen actual
        }
        
        return \Response::json($noticia);
    }else{
        return abort(403);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->ajax()){
        $noticia = Noticia::where('id_noticia',$id)->first();
        //dd($noticia->id_noticia);
        $pathDirectorio = public_path('img\\noticias').'\\'.$noticia->id_noticia;
        
        if(File::isDirectory($pathDirectorio)){
            File::deleteDirectory($pathDirectorio);
        }

        $noticia->forceDelete();
                
        return \Response::json($noticia);
    }else{
        return abort(403);
    }
    }

    /**
     * reactiva el recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reactivar($id)
    {
        $noticia = Noticia::withTrashed()->where('id_noticia',$id)->restore();
        return \Response::json($noticia);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function noticias(){
        
        return $this->direccion();
    }

    public function direccion(){
        $semana = Semana::select('id_semana','nombre','url_logo')->where('vigente',1)->first();
        return view('admin.noticias.adminNoticias',compact(['semana']));
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listNoticias(Request $request ){
        $busqueda = $request->busqueda;
        if($busqueda == 'activos'){
            $selectnoticias = Noticia::select('id_noticia as id','titulo','resumen','fecha_actualizacion');
            return datatables()->of($selectnoticias)
            ->addColumn('action', 'admin.acciones')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $selectnoticias = Noticia::onlyTrashed()->get(['id_noticia as id','titulo','resumen','fecha_actualizacion']);
            return datatables()->of($selectnoticias)
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }

    public function vistaPrevia(Request $noticia){
        $semana = Semana::select('id_semana','url_logo')->where('vigente',1)->first();
        $instituciones = DB::select(DB::raw("
        SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,
		 instituciones.siglas, instituciones.telefono, instituciones.direccion_web,
		 instituciones.url_logo, instituciones.ciudad, 
		 CONCAT(instituciones.calle,' #', instituciones.numero, ', col. ', instituciones.colonia , ', C.P.', instituciones.cp) AS domicilio,
		 (SELECT CONCAT(users.nombre,' ', users.primer_apellido, ' ', users.segundo_apellido) 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS coordinador_nombre,
		 (SELECT email 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS email
         FROM instituciones WHERE deleted_at IS NULL;
         "));
        return \Response::json(view('noticias.detalle', compact(['semana','noticia','instituciones']))->render());
    }
}
