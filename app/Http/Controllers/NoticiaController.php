<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Noticia;
use DataTables;
use App\Http\Requests\noticias\StoreNoticiaRequest;
use App\Http\Requests\noticias\UpdateNoticiaRequest;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Noticia::latest('fecha_creacion')->paginate(5);
        return view('noticias.verNoticias', compact('data'));
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
        return view('noticias.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNoticiaRequest $request)
    {
        
        $detail=$request->contenido;
        
        $nuevo_nombre = 'sin imagen';
        if($request->hasFile('imgnoticia')){
            
            $imagennoticia = $request->file('imgnoticia');
            //agregar id de usuarios a nombre
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_noticia . '.' . $imagennoticia->getClientOriginalExtension();
            $imagennoticia->move(public_path('img/noticias'), $nuevo_nombre);
        }
        
       $dom = new \domdocument();
        $dom->loadHtml('<?xml encoding="utf-8" ?>'.$detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        /*
        $images = $dom->getelementsbytagname('img');
 
        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        foreach($images as $k => $img){
            $data = $img->getattribute('src');
 
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
 
            $data = base64_decode($data);
            $image_name= time().$k.'.png';
            $path = public_path() .'/img/noticias/'. $image_name;
 
            file_put_contents($path, $data);
 
            $img->removeattribute('src');
            $img->setattribute('src', '/img/noticias/'.$image_name);
        }
 */
        $detail = $dom->savehtml();
              
        $summernote = new Noticia;
        $summernote->contenido = $detail;
        $summernote->titulo = $request->titulo;
        $summernote->url_imagen = $nuevo_nombre;
        $summernote->resumen = $request->resumen;
        $summernote->creada_por= 1;
        $summernote->contenido = $detail;
        $summernote->save();
        
        return back()-> with('info','Noticia creada exitosamente');
        return view('noticias.verNoticia',compact('summernote'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $noticia  = Noticia::select('id_noticia','titulo','contenido','url_imagen','fecha_actualizacion')->where('id_noticia', $id)->first();
        return view('noticias.detalle', compact('noticia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $noticia  = Noticia::select('id_noticia','titulo','contenido','resumen','url_imagen','fecha_actualizacion')->where('id_noticia', $id)->first();
        
        return view('noticias.editar',compact('noticia'));
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
        $noticia = Noticia::where('id_noticia',$id)->first();
        $detail=$request->contenido;
        
        $nuevo_nombre = 'sin imagen';
        if($request->hasFile('imgnoticia')){
            
            $imagennoticia = $request->file('imgnoticia');
            //agregar id de usuarios a nombre
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_noticia . '.' . $imagennoticia->getClientOriginalExtension();
            $imagennoticia->move(public_path('img/noticias'), $nuevo_nombre);
        }
        else{
            $nuevo_nombre = $noticia->url_imagen;
        }
        
        $dom = new \domdocument();
        $dom->loadHtml('<?xml encoding="utf-8" ?>'.$detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        /*
        $images = $dom->getelementsbytagname('img');
 
        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        foreach($images as $k => $img){
            $data = $img->getattribute('src');
 
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
 
            $data = base64_decode($data);
            $image_name= time().$k.'.png';
            $path = public_path() .'/img/noticias/'. $image_name;
 
            file_put_contents($path, $data);
 
            $img->removeattribute('src');
            $img->setattribute('src', '/img/noticias/'.$image_name);
        }
 */
        $detail = $dom->savehtml();
              
        
        $noticia->titulo = $request->titulo;
        $noticia->contenido = $detail;
        $noticia->url_imagen = $nuevo_nombre;
        $noticia->resumen = $request->resumen;
        $noticia->creada_por= 1;
        
        $noticia->save();
        
        return back()-> with('info','Noticia actualizada exitosamente');
        return view('noticias.verNoticia',compact('summernote'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $noticia = Noticia::where('id_noticia',$id)->delete();
        return \Response::json($noticia);
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
        return view('admin.noticias.adminNoticias');
        
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
}
