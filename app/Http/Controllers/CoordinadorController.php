<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\coordinadores\StoreCoordinadorRequest;
use App\Http\Requests\coordinadores\UpdateCoordinadorRequest;
use App\User;
use App\Coordinador;
use App\Institucion;
use App\Semana;
use App\Modalidad;
use DataTables;
use DB;

use Validator;

class CoordinadorController extends Controller
{
    public function __construct(){
        $this->middleware('admin.auth:admin')->only(['coordinador']);
        $this-> middleware('auth')->only('index');
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semana = Semana::select('id_semana','vigente','url_logo','fecha_inicio','fecha_fin')->where('vigente',1)->first();
        $instituciones = DB::select(DB::raw("
        SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,
		 instituciones.siglas, instituciones.telefono, instituciones.direccion_web,
		 instituciones.url_logo, instituciones.ciudad, 
		 CONCAT(instituciones.calle,' #', instituciones.numero, ', col. ', instituciones.colonia , ', C.P.', instituciones.cp) AS domicilio,
		 (SELECT CONCAT(users.nombre,' ', users.primer_apellido, ' ', users.segundo_apellido) 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS coordinador_nombre,
		 (SELECT email 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS email
         FROM instituciones;
         "));
        /*Agregado Rente para la cuestion de sesiones*/
        $modalidades = Modalidad::select('id_modalidad','nombre')->get();
        $horarios = DB::select(DB::raw("SELECT ADDDATE('$semana->fecha_inicio', INTERVAL @i:=@i+1 DAY) AS DAY FROM (
        SELECT a.a
        FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
        CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
        CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
        ) a
        JOIN (SELECT @i := -1) r1
        WHERE 
        @i < DATEDIFF('$semana->fecha_fin','$semana->fecha_inicio')"));
        $locaciones = DB::select("select locaciones.id_locacion as id_locacion, locaciones.nombre as nombre from locaciones,semanas where semanas.vigente = 1 AND id_sede = id_institucion");
        return view('coordinador.administrarInstitucion',compact(['instituciones','semana','modalidades','horarios','locaciones']));  
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
        if(auth()->user()){
            $instituciones = DB::select(DB::raw("
        SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,
		 instituciones.siglas, instituciones.telefono, instituciones.direccion_web,
		 instituciones.url_logo, instituciones.ciudad, 
		 CONCAT(instituciones.calle,' #', instituciones.numero, ', col. ', instituciones.colonia , ', C.P.', instituciones.cp) AS domicilio,
		 (SELECT CONCAT(users.nombre,' ', users.primer_apellido, ' ', users.segundo_apellido) 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS coordinador_nombre,
		 (SELECT email 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS email
         FROM instituciones;
         "));
            $semana = Semana::select('id_semana as id','url_logo','url_convocatoria')->where('vigente',1)->first();
            $usuario = $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('directortesis:id')->where('id',$id)->first();
            return view('coordinador.editarCoordinador',compact(['usuario','semana','instituciones']));
        }else if (auth('admin')->user()) {
            $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('coordinadores:id,puesto','instituciones:id,nombre')->where('id',$id)->first();
            return \Response::json($usuario);
        }
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
