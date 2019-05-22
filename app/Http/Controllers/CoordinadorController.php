<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Coordinador;
use App\Institucion;
use App\Semana;
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

        $user = new User([
            'nombre'     => $request->nombre,
            'email'     => $request->email,
            'password' => bcrypt($request->password),
            'primer_apellido'   => $request->primer_apellido, 
            'segundo_apellido'  => $request->segundo_apellido, 
            'id_institucion'    => $request->id_institucion,
            'id_semana' => Semana::select('id_semana','vigente')->where('vigente',1)->get()[0]->id_semana,
        ]);
        $user->save();
        
        
        if($user){
            $user->coordinadores()->create(['grado'=>'doc','id_semana'=>1]);
            $user->roles()->attach([$user->id => ['id_rol'=>'1', 'creada_por'=>'1']]);
        }
        
        return \Response::json($user);
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
        
        $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('coordinadores:id,grado','instituciones:id,nombre')->where('id',$id)->first();
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
        
        $user = User::find($id);
        $user->nombre = $request->nombre;
        $user->primer_apellido = $request->primer_apellido;
        $user->segundo_apellido = $request->segundo_apellido;
        $user->password = bcrypt($request->password);
        $user->id_institucion = $request->id_institucion;
        $user->id_semana = Semana::select('id_semana','vigente')->where('vigente',1)->get()[0]->id_semana;
        
        $user->save();
        
        if($user){
            $user->coordinadores()->update(['grado'=>'doc','id_semana'=>1]);
            $user->roles()->attach([$user->id => ['id_rol'=>'1', 'creada_por'=>'1']]);
        }
        
        return \Response::json($user);
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
        $semana = Semana::select('id_semana','vigente')->where('vigente',1)->first();
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
            $usuarios = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('coordinadores:id,grado','instituciones:id,nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'coordinador');});
            return datatables()->of($usuarios)
            ->addColumn('action', 'admin.acciones')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $usuarios = User::onlyTrashed()->select('id','nombre','primer_apellido','segundo_apellido','email')->with('coordinadores:id,grado','instituciones:id,nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'coordinador');});
            return datatables()->of($usuarios)
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
}
