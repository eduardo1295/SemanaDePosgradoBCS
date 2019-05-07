<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Coordinador;
use App\Institucion;
use DataTables;
use App\Http\Requests\coodinador\StoreCoordinadorRequest;
use App\Http\Requests\coodinador\UpdateCoordinadorRequest;
use Validator;
class CoordinadorController extends Controller
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nuevo_nombre = 'sin imagen';
        if($request->hasFile('imagenCarrusel')){
            
            $imagencarrusel = $request->file('imagenCarrusel');
            //agregar id de usuarios a nombre
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->id_carrusel . '.' . $imagencarrusel->getClientOriginalExtension();
            $imagencarrusel->move(public_path('img/carrusel'), $nuevo_nombre);
        }
        
        $carrusel = new Carrusel;
        $carrusel->link_web = $request->link_web;
        $carrusel->url_imagen = $nuevo_nombre;
        $carrusel->creado_por= 1;
        $carrusel->save();
        $carrusel->save();
        if($carrusel){
            //borrar imagen actual
        }
        //$institucion->update($request->all());
        return \Response::json($carrusel);
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
        $usuario = User::select('id','nombre','primer_apellido','segundo_apellido','email')->with('coordinadores:id_usuario,grado','instituciones:id,nombre as nom_insti')->where('id',$id)->first();
        
        return \Response::json($usuario);
        
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
        

        $carrusel = Carrusel::where('id',$id)->first();
        
        $rules1 = [
            'link_web' => 'nullable|max:60',
            'imagenCarrusel' => 'required|mimes:jpeg,jpg,png|max:2048',
        ];

        $rules2 = [
            'link_web' => 'nullable|max:60',
        ];
        $sinerror='verdadero';
        $nuevo_nombre = 'sin imagen';
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
        
        if ($sinerror=='verdadero') {
            $carrusel->link_web = $request->link_web;
            $carrusel->url_imagen = $nuevo_nombre;
            $carrusel->creado_por= 1;
            $carrusel->save();
            if($carrusel){
                //borrar imagen actual
            }
            //$institucion->update($request->all());
            return \Response::json($carrusel);
            
        }
        else{
            return \Response::json(['errors' => $validator->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id',$id)->delete();
        return \Response::json($user);
    }

    /**
     * reactiva el recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reactivar($id)
    {
        $user = User::withTrashed()->where('id',$id)->restore();
        return \Response::json($user);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function coordinador(){
        $instituciones = Institucion::select('id','nombre')->get();
        return view('admin.coordinador.adminCoordinador',compact(['instituciones']));   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listCoordinador(Request $request ){
        $busqueda = $request->busqueda;
        if($busqueda == 'activos'){
            $usuarios = User::select('id','nombre','primer_apellido','segundo_apellido','email')->with('coordinadores:id_usuario,grado','instituciones:id,nombre as nom_insti')->whereHas('roles', function($q){$q->where('nombre', '=', 'coordinador');});
            return datatables()->of($usuarios)
            ->addColumn('action', 'admin.acciones')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $usuarios = User::onlyTrashed()->select('id','nombre','primer_apellido','segundo_apellido','email')->with('coordinadores:id_usuario,grado','instituciones:id,nombre as nom_insti')->whereHas('roles', function($q){$q->where('nombre', '=', 'coordinador');});
            return datatables()->of($usuarios)
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
}
