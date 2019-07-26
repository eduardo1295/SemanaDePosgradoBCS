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
        //$this->middleware('admin.auth:admin')->only(['director']);
        //$this->middleware('auth')->only('director');
        $this->middleware(['admin.auth:admin','verificarcontrasena','admin.verified'])->only(['director']);
        $this-> middleware(['esusuario'])->only(['listDirector','store','update','edit','destroy']);
        $this->middleware(['auth','verified','verificarcontrasena'], ['only' => ['revisarAlumnos']]);
        $this->middleware(['verificarcontrasena','verified'])->only(['edit']);
        
        
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
        $user = new User();
        $idSemana = Semana::select('id_semana','vigente')->where('vigente',1)->get()[0]->id_semana;
        if(auth('admin')->user()){
            $user = new User([
                'nombre'     => ucfirst($request->nombre_di),
                'email'     => $request->email_di,
                'password' => bcrypt($request->password_di),
                'primer_apellido'   => ucfirst($request->primer_apellido_di), 
                'segundo_apellido'  => ucfirst($request->segundo_apellido_di), 
                'id_institucion'    => $request->id_institucion_di,
                'id_semana' => $idSemana,
            ]);
            $user->save();
        }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
            $user = new User([
                'nombre'     => ucfirst($request->nombre_di),
                'email'     => $request->email_di,
                'password' => bcrypt($request->password_di),
                'primer_apellido'   => ucfirst($request->primer_apellido_di), 
                'segundo_apellido'  => ucfirst($request->segundo_apellido_di), 
                'id_institucion'    => auth()->user()->id_institucion,
                'id_semana' => $idSemana,
            ]);
            $user->save();
        }
        
        
        if($user){
            $user->directortesis()->create();
            $user->roles()->attach([$user->id => ['id_rol'=>'4']]);
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
    public function edit(Request $request, $id)
    {
        
        if(auth()->user() && auth()->user()->hasRoles(['director'])){
            if(auth()->user()->id != $id){
                return abort(403);
            }
                $instituciones = DB::select(DB::raw("
        SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,
		 instituciones.siglas, instituciones.telefono, instituciones.direccion_web,
		 instituciones.url_logo, instituciones.ciudad, 
		 CONCAT(instituciones.calle,' #', instituciones.numero, ', col. ', instituciones.colonia , ', C.P.', instituciones.cp) AS domicilio,
		 (SELECT CONCAT(users.nombre,' ', users.primer_apellido, ' ', users.segundo_apellido) 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS coordinador_nombre,
		 (SELECT email 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS email
         FROM instituciones WHERE deleted_at IS NULL;
         "));
                $semana = Semana::select('id_semana as id','url_logo','url_convocatoria')->where('vigente',1)->first();
                $usuario = $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('directortesis:id')->where('id',$id)->first();
                return view('director.editarDirector',compact(['usuario','semana','instituciones']));
            
        }else if ($request->ajax() && (auth('admin')->user() || (auth()->user() && auth()->user()->hasRoles(['coordinador'])) )) {
            $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('directortesis:id','instituciones:id,nombre')->where('id',$id)->first();
            return \Response::json($usuario);
        }else{
            return abort(403);
        }
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
        $idSemana = Semana::select('id_semana','vigente')->where('vigente',1)->get()[0]->id_semana;
        $user = User::find($id);
        $user->email = $request->email_di;
        $user->nombre = ucfirst($request->nombre_di);
        $user->primer_apellido = ucfirst($request->primer_apellido_di);
        $user->segundo_apellido = ucfirst($request->segundo_apellido_di);
        if(auth('admin')->user()){
            $user->id_institucion = $request->id_institucion_di;
        }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
            $user->id_institucion = auth()->user()->id_institucion;
        }
        $user->id_semana = Semana::select('id_semana','vigente')->where('vigente',1)->get()[0]->id_semana;
        
        if(!empty($request->password_di))
            $user->password = bcrypt($request->password_di);

        $user->save();
        
        if($user){
            //$user->directortesis()->update([]);
            $user->roles()->sync([$user->id => ['id_rol'=>'4']]);
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
        $usuarios = "";
        if($busqueda == 'activos' || $busqueda == 'activoscoor'){
            if(auth('admin')->user() || ($busqueda != 'activoscoor' && auth()->user() && auth()->user()->hasRoles(['subadmin']))){
                $usuarios = DB::select(DB::raw('SELECT directores_tesis.id,'.
                ' users.nombre,users.id,users.primer_apellido,users.segundo_apellido,users.email,'.
                ' users.fecha_actualizacion as fecha_usuario, instituciones.nombre AS institucion_nombre'.
                ' FROM directores_tesis, users, instituciones'.
                ' WHERE directores_tesis.id=users.id AND users.id_institucion = instituciones.id AND users.deleted_at IS NULL'));

                //$usuarios = User::select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('directortesis:id,grado','instituciones:instituciones.id,instituciones.nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'director');});
            }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
                
                $usuarios = DB::select('SELECT directores_tesis.id,'.
                ' users.nombre,users.id,users.primer_apellido,users.segundo_apellido,users.email,'.
                ' users.fecha_actualizacion as fecha_usuario, instituciones.nombre AS institucion_nombre'.
                ' FROM directores_tesis, users, instituciones'.
                ' WHERE directores_tesis.id=users.id AND users.id_institucion = instituciones.id AND users.deleted_at IS NULL AND users.id_institucion = ?',[auth()->user()->id_institucion]);
                
            }
                //$usuarios = User::select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('directortesis:id,grado','instituciones:instituciones.id,instituciones.nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'director');});
            $editar = 'editarDirector';
            $eliminar = 'eliminarDirector';
            return datatables()->of($usuarios)
            ->addColumn('action', 
            '<div style="text-align:center;width:100px" class="mx-auto">

            <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $id }}" data-original-title="Editar"
                style="height:40px" class="edit btn btn-xs btn-primary editarDirector">
                <span><i class="fas fa-edit"></i>
                </span></a>
        
        
            <a href="javascript:void(0);" id="eliminar" data-toggle="tooltip" data-original-title="Eliminar"
                data-id="{{ $id }}" class="delete btn btn-xs btn-danger eliminarDirector" style="height:40px">
                <span><i class="fas fa-trash-alt"></i>
                </span></a>
            </div>'
            
            )
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            
            if(auth('admin')->user()){
                
                $usuarios = DB::select(DB::raw('SELECT  directores_tesis.id,'.
                ' users.nombre,users.id,users.primer_apellido,users.segundo_apellido,users.email,'.
                ' users.fecha_actualizacion as fecha_usuario, instituciones.nombre AS institucion_nombre'.
                ' FROM directores_tesis, users, instituciones'.
                ' WHERE directores_tesis.id=users.id AND users.id_institucion = instituciones.id AND users.deleted_at IS NOT NULL'));
                
                //$usuarios = User::select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('directortesis:id,grado','instituciones:instituciones.id,instituciones.nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'director');});
            }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
                
                $usuarios = DB::select('SELECT directores_tesis.id,'.
                ' users.nombre,users.id,users.primer_apellido,users.segundo_apellido,users.email,'.
                ' users.fecha_actualizacion as fecha_usuario, instituciones.nombre AS institucion_nombre'.
                ' FROM directores_tesis, users, instituciones'.
                ' WHERE directores_tesis.id=users.id AND users.id_institucion = instituciones.id AND users.deleted_at IS NOT NULL AND users.id_institucion = ?',[auth()->user()->id_institucion]);
            }

            //$usuarios = User::onlyTrashed()->select('id','nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('directortesis:id,grado','instituciones:id,nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'director');});
            return datatables()->of($usuarios)
            ->addColumn('action', 
            '<div style="text-align:center;width:100px" class="mx-auto">

            <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $id }}" data-original-title="Activar"
                style="height:40px" class="btn btn-xs btn-warning reactivarDirector">
                <span><i class="fas fa-redo"></i>
                </span></a>
            </div>
            ')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }

    public function listAlumnos(Request $request ){
        if(!auth()->user()){
            return abort(403);
        }
        $listAlumnos = Alumno::all()->where('id_director',auth()->user()->id);
        $c = collect();
        foreach ($listAlumnos as $alum) {
            $c->push(User::select('id','nombre','primer_apellido','segundo_apellido','email')->with('alumnos:id,num_control','trabajos:id_alumno,url,revisado,autorizado')->where('id',$alum->id)->first());
        }
        
        return datatables()->of($c)
        ->addIndexColumn()
        ->toJson();
    }




    public function revisarAlumnos(Request $request){
        if (session()->has('mensaje')) {
            $mensaje = session('mensaje');
            session()->forget('mensaje');
        }
        $instituciones = DB::select(DB::raw("
        SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,
		 instituciones.siglas, instituciones.telefono, instituciones.direccion_web,
		 instituciones.url_logo, instituciones.ciudad, 
		 CONCAT(instituciones.calle,' #', instituciones.numero, ', col. ', instituciones.colonia , ', C.P.', instituciones.cp) AS domicilio,
		 (SELECT CONCAT(users.nombre,' ', users.primer_apellido, ' ', users.segundo_apellido) 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS coordinador_nombre,
		 (SELECT email 
		 FROM users WHERE users.id_institucion = instituciones.id AND id IN (SELECT id_usuario FROM rol_usuario WHERE id_rol= 3)) AS email
         FROM instituciones WHERE deleted_at IS NULL;
         "));
        $semana = Semana::select('id_semana as id','url_logo','url_convocatoria')->where('vigente',1)->first();
        return view('director.revisarAlumnos',compact(['instituciones','semana','mensaje']));
    }

    public function editarPerfil(Request $request,$id){
            $user = User::find($id);    
            $user->nombre = ucfirst($request->nombre);
            $user->primer_apellido = ucfirst($request->primer_apellido);
            $user->segundo_apellido = ucfirst($request->segundo_apellido);
            if(!empty($request->password))
                $user->password = bcrypt($request->password);
            
            $user->save();

            return \Response::json($user);
        
    }

    
}
