<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrusel;
use DataTables;
use App\Http\Requests\carrusel\StoreCarruselRequest;
use App\Http\Requests\carrusel\UpdateCarruselRequest;

class CarruselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('carrusel.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarruselRequest $request)
    {
        
        $nuevo_nombre = 'sin imagen';
        if($request->hasFile('imgcarrusel')){
            
            $imagencarrusel = $request->file('imgcarrusel');
            //agregar id de usuarios a nombre
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_carrusel . '.' . $imagencarrusel->getClientOriginalExtension();
            $imagencarrusel->move(public_path('img/carrusel'), $nuevo_nombre);
        }
        
        $summernote = new Carrusel;
        $summernote->contenido =$request->contenido;
        $summernote->titulo = $request->titulo;
        $summernote->url_imagen = $nuevo_nombre;
        $summernote->creado_por= 1;
        $summernote->save();
        $info = 'Slider creado exitosamente';
        //return view('admin.carrusels.admincarrusels')->with('info',$info);
        return back()-> with('info','carrusel creada exitosamente');
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
        $carrusel  = Carrusel::select('id','titulo','contenido','url_imagen','fecha_actualizacion')->where('id', $id)->first();
        
        return view('carrusel.editar',compact('carrusel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarruselRequest $request, $id)
    {
        $carrusel = Carrusel::where('id',$id)->first();
        $detail=$request->contenido;
        
        $nuevo_nombre = 'sin imagen';
        if($request->hasFile('imgcarrusel')){
            
            $imagencarrusel = $request->file('imgcarrusel');
            //agregar id de usuarios a nombre
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_carrusel . '.' . $imagencarrusel->getClientOriginalExtension();
            $imagencarrusel->move(public_path('img/carrusel'), $nuevo_nombre);
        }
        else{
            $nuevo_nombre = $carrusel->url_imagen;
        }
        
              
        
        $carrusel->titulo = $request->titulo;
        $carrusel->contenido = $request->contenido;
        $carrusel->url_imagen = $nuevo_nombre;
        $carrusel->creado_por= 1;
        
        $carrusel->save();
        
        return back()-> with('info','carrusel actualizada exitosamente');
        return view('carrusels.vercarrusel',compact('summernote'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carrusel = Carrusel::where('id',$id)->delete();
        return \Response::json($carrusel);
    }

    /**
     * reactiva el recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reactivar($id)
    {
        $carrusel = Carrusel::withTrashed()->where('id',$id)->restore();
        return \Response::json($carrusel);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function carrusel(){
        return view('admin.carrusel.adminCarrusel');   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listCarrusel(Request $request ){
        $busqueda = $request->busqueda;
        if($busqueda == 'activos'){
            $selectcarrusel = Carrusel::select('id','titulo','url_imagen','fecha_actualizacion');
            return datatables()->of($selectcarrusel)
            ->addColumn('action', 'admin.acciones')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $selectcarrusel = Carrusel::onlyTrashed()->get(['id','titulo','url_imagen','fecha_actualizacion']);
            return datatables()->of($selectcarrusel)
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
}
