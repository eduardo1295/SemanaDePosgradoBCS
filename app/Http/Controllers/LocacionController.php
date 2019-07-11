<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Semana;
use App\Locacion;
use DataTables;
use DB;

class LocacionController extends Controller
{
    public function __construct(){
        $this-> middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $semana = Semana::select('id_sede')->where('vigente',1)->first();
        $locacion = Locacion::all();
        foreach($locacion as $locac){
            if(str_replace(' ','',strtoupper($locac->nombre)) ==  str_replace(' ','',strtoupper($request->nombre))){
                return \Response::json("Repetida");        
            }
        }
        $locacion = new Locacion();
        $locacion->nombre = $request->nombre;
        $locacion->creada_por = auth('admin')->user()->id;
        $locacion->id_institucion =  $semana->id_sede;
        $locacion->save();

        return \Response::json($locacion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $locacion = Locacion::find($id);

        return \Response::json($locacion);
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
        $semana = Semana::select('id_sede')->where('vigente',1)->first();
        $locacion = Locacion::all()->where('id','!=',$request->id_locacion);
        foreach($locacion as $locac){
            if(str_replace(' ','',strtoupper($locac->nombre)) ==  str_replace(' ','',strtoupper($request->nombre))){
                return \Response::json("Repetida");        
            }
        }
        $locacion = Locacion::find($id)->first();
        $locacion->nombre = $request->nombre;
        $locacion->creada_por = auth('admin')->user()->id;
        $locacion->id_institucion =  $semana->id_sede;
        $locacion->save();

        return \Response::json($locacion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $locacion = Locacion::find($id);
        $locacion->forceDelete();
        return \Response::json($locacion);
    }
    public function locacion(){
        $semana = Semana::select('id_semana','nombre','url_logo')->where('vigente',1)->first();
        return view('admin.locacion.adminLocaciones',compact(['semana']));
        
    }
    public function listLocacion(Request $request){
        
        
        $busqueda = 'activos';
        if($busqueda == 'activos'){
            $selectLocaciones = DB::select("select locaciones.id_locacion as id, locaciones.nombre as nombre, locaciones.fecha_actualizacion as fecha_actualizacion from locaciones,semanas where semanas.vigente = 1 AND id_sede = id_institucion");
            return datatables()->of($selectLocaciones)
            ->addColumn('action', 
            '<div style="text-align:center;width:100px" class="mx-auto">

            <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $id }}" title="Editar" data-placement="top"
                style="height:40px" class="edit btn btn-xs btn-primary editarLocacion">
                <span><i class="fas fa-edit"></i>
                </span></a>
        
        
            <a href="javascript:void(0);" id="eliminar" data-toggle="tooltip" title="Eliminar" data-placement="top"
                data-id="{{ $id }}" class="delete btn btn-xs btn-danger eliminarLocacion" style="height:40px">
                <span><i class="fas fa-trash-alt"></i>
                </span></a>
            </div>'
            
            )
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $selectLocaciones = Locacion::onlyTrashed()->get(['id_modalidad as id','nombre','descripcion','fecha_actualizacion']);
            return datatables()->of($selectLocaciones)
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
}
