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
     public function __construct(){
         $this-> middleware('auth:admin')->only('noticias');

     }
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
        $nuevo_nombre = 'sin imagen';
        if($request->hasFile('imgnoticia')){
            
            $imagennoticia = $request->file('imgnoticia');
            //agregar id de usuarios a nombre
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_noticia . '.' . $imagennoticia->getClientOriginalExtension();
            $imagennoticia->move(public_path('img/noticias'), $nuevo_nombre);
        }

        
        $noticia = new Noticia;
        $noticia->contenido = $request->contenido;
        $noticia->titulo = $request->titulo;
        $noticia->url_imagen = $nuevo_nombre;
        $noticia->resumen = $request->resumen;
        $noticia->creada_por= 1;
        $noticia->save();
        return \Response::json($noticia);
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
        $noticia  = Noticia::where('id_noticia', $id)->first();
        $nuevo_nombre = 'no_logo.png';
        if($request->hasFile('imgnoticia')){
            $imagennoticia = $request->file('imgnoticia');
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_noticia . '.' . $imagennoticia->getClientOriginalExtension();
            $imagennoticia->move(public_path('img/noticias'), $nuevo_nombre);
        }else{
            $nuevo_nombre = $noticia->url_imagen;
        }

        
        
        $noticia->contenido = $request->contenido;
        $noticia->titulo = $request->titulo;
        $noticia->url_imagen = $nuevo_nombre;
        $noticia->resumen = $request->resumen;
        
        $noticia->save();
        if($noticia){
            //borrar imagen actual
        }
        
        return \Response::json($noticia);
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
