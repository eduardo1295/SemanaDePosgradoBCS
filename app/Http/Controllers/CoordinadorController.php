<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\coordinadores\StoreCoordinadorRequest;
use App\Http\Requests\coordinadores\UpdateCoordinadorRequest;
use App\User;
use App\Coordinador;
use App\Institucion;
use App\Semana;
use DataTables;
use DB;

use Validator;

class CoordinadorController extends Controller
{
    public function __construct(){
        $this->middleware('admin.auth:admin')->only('coordinador');
        $this-> middleware('auth')->only('index');
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semana = Semana::select('id_semana','vigente','url_logo')->where('vigente',1)->first();
        $instituciones = DB::select(DB::raw('SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,'.
		' instituciones.siglas, instituciones.telefono, instituciones.direccion_web,'.
		' instituciones.url_logo, instituciones.ciudad, users.id, users.id_institucion, coordinadores.id,'.
		' rol_usuario.id_usuario, rol_usuario.id_rol,users.email,'.
		' CONCAT(users.nombre," ", users.primer_apellido, " ", users.segundo_apellido) AS coordinador_nombre,'.
		' CONCAT(instituciones.calle," #", instituciones.numero, ", col. ", instituciones.colonia , ", C.P.", instituciones.cp) AS domicilio'.
		' FROM instituciones, coordinadores, users, rol_usuario'.
		' WHERE '.
		' users.id_institucion = instituciones.id'.
		' AND rol_usuario.id_usuario = users.id'.
		' AND users.id = coordinadores.id'.
        ' AND rol_usuario.id_rol = 3;'));
        
        return view('coordinador.administrarInstitucion',compact(['instituciones','semana']));  
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
    public function store(StoreCoordinadorRequest $request)
    {
        $idSemana = Semana::select('id_semana','vigente')->where('vigente',1)->get()[0]->id_semana;
        $user = new User([
            'nombre'     => ucfirst($request->nombre),
            'email'     => $request->email,
            'password' => bcrypt($request->password),
            'primer_apellido'   => ucfirst($request->primer_apellido), 
            'segundo_apellido'  => ucfirst($request->segundo_apellido), 
            'id_institucion'    => $request->id_institucion,
            'id_semana' => $idSemana,
        ]);
        
        
        
        
        $user->save();
        
        
        if($user){
            $coordActual = DB::select('SELECT coordinadores.id FROM coordinadores WHERE '.
                'coordinadores.id IN (SELECT users.id FROM users WHERE users.id_institucion = ?)',[$request->id_institucion]);
            $dataSet = [];
            foreach ($coordActual as $coordinador) {
                $dataSet[] = [
                    'id'  => $coordinador->id
                ];
            }

            $insertar =  DB::table('directores_tesis')->insert($dataSet);
            
            $actualizar = DB::update('UPDATE rol_usuario SET rol_usuario.id_rol = 4 WHERE rol_usuario.id_rol=3 AND id_usuario'. 
            ' IN (SELECT users.id FROM users WHERE users.id_institucion = ?)',[$request->id_institucion]);
            $user->coordinadores()->create(['puesto'=> ucfirst($request->puesto)]);
            $user->roles()->attach([$user->id => ['id_rol'=>'3', 'creada_por'=>'1']]);
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
        $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('coordinadores:id,puesto','instituciones:id,nombre')->where('id',$id)->first();
        return \Response::json($usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoordinadorRequest $request, $id)
    {
        $idSemana = Semana::select('id_semana','vigente')->where('vigente',1)->get()[0]->id_semana;

        $user = User::find($id);
        $user->email = $request->email;
        $user->nombre = ucfirst($request->nombre);
        $user->primer_apellido = ucfirst($request->primer_apellido);
        $user->segundo_apellido = ucfirst($request->segundo_apellido);
        $user->id_institucion = $request->id_institucion;
        $user->id_semana = $idSemana;
        

        if(!empty($request->password))
            $user->password = bcrypt($request->password);
        
        $user->save();
        
        if($user){
            $user->coordinadores()->update(['puesto'=> ucfirst($request->puesto)]);
            $user->roles()->sync([$user->id => ['id_rol'=>'3', 'creada_por'=>'1']]);
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
        $semana = Semana::select('id_semana','vigente','url_logo')->where('vigente',1)->first();
        $instituciones = Institucion::select('id','nombre')->get();
        return view('admin.coordinador.adminCoordinador',compact(['instituciones','semana']));   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listCoordinador(Request $request ){
        $busqueda = $request->busqueda;
        if($busqueda == 'activos'){
            $usuarios = User::select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','users.email','users.fecha_actualizacion')->with('coordinadores:coordinadores.id,puesto','instituciones:instituciones.id,instituciones.nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'coordinador');});
            return datatables()->of($usuarios)
            ->addColumn('action', 'admin.acciones')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $usuarios = User::onlyTrashed()->select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','users.email','users.fecha_actualizacion')->with('coordinadores:coordinadores.id,puesto','instituciones:instituciones.id,instituciones.nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'coordinador');});
            return datatables()->of($usuarios)
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
}
