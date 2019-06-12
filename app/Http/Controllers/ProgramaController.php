<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Programa;
use App\Semana;
use App\Institucion;
use DataTables;
use App\Http\Requests\programas\StoreProgramaRequest;
use App\Http\Requests\programas\UpdateProgramaRequest;
use Validator;

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(){
        //$this-> middleware('auth:admin');
        $this->middleware('admin.auth:admin')->only('programa');
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
        return view('programa.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgramaRequest $request)
    {   
        /*
        $nuevo_nombre = 'sin imagen';
        if($request->hasFile('imagenCarrusel')){
            
            $imagencarrusel = $request->file('imagenCarrusel');
            //agregar id de usuarios a nombre
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_carrusel . '.' . $imagencarrusel->getClientOriginalExtension();
            $imagencarrusel->move(public_path('img/carrusel'), $nuevo_nombre);
        }
        */
        
        $programa = new Programa;
        
        if(auth('admin')->user()){
            $programa->id_institucion = $request->id_institucion_pro;
            $programa->creado_por= auth('admin')->user()->id;
        }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
            $programa->id_institucion = auth()->user()->id_institucion;
            $programa->creado_por= auth()->user()->id;
        }

        $programa->id_programa = $request->id_programa_pro;
        $programa->nombre = ucfirst($request->nombre_pro);
        $programa->nivel = $request->nivel_pro;
        $programa->periodo = $request->periodo_pro;
        //$programa->id_institucion = $request->id_institucion_pro;
        
        $programa->save();
        if($programa){
            //borrar imagen actual
        }
        //$institucion->update($request->all());
        return \Response::json($programa);
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
        $programa  = Programa::select('id','id_programa','id_institucion','nombre','nivel','periodo')->where('id', $id)->first();
        return \Response::json($programa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProgramaRequest $request, $id)
    {
        $programa = Programa::where('id',$id)->first();
        
        $rules1 = [
            'nombre' => 'nullable|max:100',
            'nivel' => 'nullable|max:30',
            'periodo' => 'nullable|max:30',
        ];
        
        $sinerror='verdadero';
        /*
        if($request->hasFile('imagenCarrusel')){
            $validator = Validator::make($request->all(), $rules1 );
            if(!$validator->fails()){
                $imagencarrusel = $request->file('imagenCarrusel');
                $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_carrusel . '.' . $imagencarrusel->getClientOriginalExtension();
                $imagencarrusel->move(public_path('img/carrusel'), $nuevo_nombre);
            }else{
                $sinerror='falso';
            }
        }
        else{
            $validator = Validator::make( $request->all(), $rules2 );
            if(!$validator->fails()){
                $sinerror='verdadero';
            }else{
                $sinerror='falso';
            }
            $nuevo_nombre = $carrusel->url_imagen;
        }
        */

        if(auth('admin')->user()){
            $programa->id_institucion = $request->id_institucion_pro;
            $programa->actualizado_por= auth('admin')->user()->id;
        }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
            $programa->id_institucion = auth()->user()->id_institucion;
            $programa->creado_por= auth()->user()->id;
        }
        
        
            $programa->id_programa = $request->id_programa_pro;
            $programa->nombre = ucfirst($request->nombre_pro);
            $programa->nivel = $request->nivel_pro;
            $programa->periodo = $request->periodo_pro;
            //$programa->id_institucion = $request->id_institucion_pro;
            
            $programa->save();
            /*
            if($carrusel){
                //borrar imagen actual
            }
            */
            //$institucion->update($request->all());
            return \Response::json($programa);
            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carrusel = Programa::where('id',$id)->delete();
        return \Response::json($carrusel);
    }
    public function reactivar($id)
    {
        $programa = Programa::withTrashed()->where('id',$id)->restore();
        return \Response::json($programa);
    }

    public function programa(){
        $semana = Semana::select('id_semana','nombre','url_logo')->where('vigente',1)->first();
        $instituciones = Institucion::select('id','nombre')->get();
        return view('admin.programa.adminPrograma',compact(['instituciones','semana']));   
    }


    public function listPrograma(Request $request ){
        $busqueda = $request->busqueda;
        if($busqueda == 'activos'){
            if(auth('admin')->user()){
                $selectProgramas =  Programa::select('programas.id','programas.id_programa','programas.nombre','programas.id_institucion','periodo','nivel','programas.fecha_actualizacion')->with('institucion:instituciones.id,instituciones.nombre');
            }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
                $selectProgramas =  Programa::select('programas.id','programas.id_programa','programas.nombre','programas.id_institucion','periodo','nivel','programas.fecha_actualizacion')->with('institucion:instituciones.id,instituciones.nombre')->where('programas.id_institucion',auth()->user()->id_institucion);
            }
            return datatables()->of($selectProgramas)
            ->addColumn('action', 
            '<div style="text-align:center;width:100px" class="mx-auto">

            <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $id }}" data-original-title="Editar"
                style="height:40px" class="edit btn btn-xs btn-primary editarPrograma">
                <span><i class="fas fa-edit"></i>
                </span></a>
        
        
            <a href="javascript:void(0);" id="eliminar" data-toggle="tooltip" data-original-title="Eliminar"
                data-id="{{ $id }}" class="delete btn btn-xs btn-danger eliminarPrograma" style="height:40px">
                <span><i class="fas fa-trash-alt"></i>
                </span></a>
            </div>'
            
            )
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            if(auth('admin')->user()){
                $selectProgramas = Programa::onlyTrashed()->select('programas.id','programas.id_programa','programas.nombre','programas.id_institucion','periodo','nivel','programas.fecha_actualizacion')->with('institucion:instituciones.id,instituciones.nombre');
            }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
                $selectProgramas = Programa::onlyTrashed()->select('programas.id','programas.id_programa','programas.nombre','programas.id_institucion','periodo','nivel','programas.fecha_actualizacion')->with('institucion:instituciones.id,instituciones.nombre')->where('programas.id_institucion',auth()->user()->id_institucion);
            }
            return datatables()->of($selectProgramas)
            ->addColumn('action', 
            '<div style="text-align:center;width:100px" class="mx-auto">

            <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $id }}" data-original-title="Activar"
                style="height:40px" class="btn btn-xs btn-warning reactivarPrograma">
                <span><i class="fas fa-redo"></i>
                </span></a>
            </div>
            ')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
}
