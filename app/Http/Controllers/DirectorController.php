<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\DirectorTesis;
use App\Institucion;
use App\Semana;
use App\Alumno;
use DataTables;
use DB;
use App\Http\Requests\directores\StoreDirectorRequest;
use App\Http\Requests\directores\UpdateDirectorRequest;
use Validator;


class DirectorController extends Controller
{
    public function __construct(){
        $this->middleware('admin.auth:admin')->only('director');
        //$this->middleware('auth')->only('director');
        
        
        $this->middleware(['auth','verified','verificarcontrasena'], ['only' => ['revisarAlumnos']]);
        
        
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
    public function store(StoreDirectorRequest $request)
    {
        $user = new User([
            'nombre'     => ucfirst($request->nombre),
            'email'     => $request->email,
            'password' => bcrypt($request->password),
            'primer_apellido'   => ucfirst($request->primer_apellido), 
            'segundo_apellido'  => ucfirst($request->segundo_apellido), 
            'id_institucion'    => $request->id_institucion,
            'id_semana' => Semana::select('id_semana','vigente')->where('vigente',1)->get()[0]->id_semana,
        ]);
        $user->save();
        
        
        if($user){
            $user->directortesis()->create(['grado'=>ucfirst($request->grado),'id_semana'=>1]);
            $user->roles()->attach([$user->id => ['id_rol'=>'4', 'creada_por'=>'1']]);
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
        $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('directortesis:id,grado','instituciones:id,nombre')->where('id',$id)->first();
        return \Response::json($usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDirectorRequest $request, $id)
    {
        $user = User::find($id);
        $user->nombre = ucfirst($request->nombre);
        $user->primer_apellido = ucfirst($request->primer_apellido);
        $user->segundo_apellido = ucfirst($request->segundo_apellido);
        $user->id_institucion = $request->id_institucion;
        $user->id_semana = Semana::select('id_semana','vigente')->where('vigente',1)->get()[0]->id_semana;
        
        if(!empty($request->password))
            $user->password = bcrypt($request->password);

        $user->save();
        
        if($user){
            $user->directortesis()->update(['grado'=>ucfirst($request->grado)]);
            $user->roles()->sync([$user->id => ['id_rol'=>'4', 'creada_por'=>'1']]);
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
    public function director(){
        $semana = Semana::select('id_semana','vigente','url_logo')->where('vigente',1)->first();
        $instituciones = Institucion::select('id','nombre')->get();
        return view('admin.directores.adminDirector',compact(['instituciones','semana']));   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listDirector(Request $request ){
        $busqueda = $request->busqueda;
        if($busqueda == 'activos'){
            $usuarios = User::select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('directortesis:id,grado','instituciones:instituciones.id,instituciones.nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'director');});
            return datatables()->of($usuarios)
            ->addColumn('action', 'admin.acciones')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $usuarios = User::onlyTrashed()->select('id','nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('directortesis:id,grado','instituciones:id,nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'director');});
            return datatables()->of($usuarios)
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }

    public function listAlumnos(Request $request ){
        $listAlumnos = Alumno::all()->where('id_director',auth()->user()->id);
        $c = collect();
        foreach ($listAlumnos as $alum) {
            $c->prepend(User::select('id','nombre','primer_apellido','segundo_apellido','email')->where('id',$alum->id)->first());
        }
        
        return datatables()->of($c)
        ->addColumn('action', 'admin.acciones')
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->toJson();
    }




    public function revisarAlumnos(){
        $instituciones = Institucion::select('id','nombre','url_logo','latitud','longitud','telefono','direccion_web',DB::raw("CONCAT(calle,' #', numero, ', col. ', colonia , ', C.P.', cp) as domicilio "))->get();
        $semana = Semana::select('id_semana as id','url_logo','url_convocatoria')->where('vigente',1)->first();
        return view('director.revisarAlumnos',compact(['instituciones','semana']));
    }
}
