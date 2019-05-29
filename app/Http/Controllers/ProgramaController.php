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
        $programa->id_programa = $request->id_programa;
        $programa->nombre = $request->nombre;
        $programa->nivel = $request->nivel;
        $programa->periodo = $request->periodo;
        $programa->id_institucion = $request->id_institucion;
        $programa->creado_por= auth('admin')->user()->id;
        $programa->save();
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
        
            $programa->id_programa = $request->id_programa;
            $programa->nombre = $request->nombre;
            $programa->nivel = $request->nivel;
            $programa->periodo = $request->periodo;
            $programa->id_institucion = $request->id_institucion;
            $programa->actualizado_por= auth('admin')->user()->id ;
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
            
            $selectcarrusel =  Programa::select('programas.id','programas.id_programa','programas.nombre','programas.id_institucion','periodo','nivel','programas.fecha_actualizacion')->with('institucion:instituciones.id,instituciones.nombre');
            return datatables()->of($selectcarrusel)
            ->addColumn('action', 'admin.acciones')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $selectcarrusel = Programa::onlyTrashed()->select('programas.id','programas.id_programa','programas.nombre','programas.id_institucion','periodo','nivel','programas.fecha_actualizacion')->with('institucion:instituciones.id,instituciones.nombre');
            return datatables()->of($selectcarrusel)
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
}
