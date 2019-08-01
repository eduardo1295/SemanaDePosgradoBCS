<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\usuarios\UpdateContrasenaRequest;
use App\Http\Controllers\Controller;
use App\Institucion;
use App\Semana;
use App\Admin;
use App\VistaLogin;
use Carbon\Carbon;
use DB;
use App\User;
use Auth;
use App\Http\Requests\admin\UpdateAdminRequest;


class HomeController extends Controller
{

    protected $redirectTo = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['admin.auth','admin.verified'])->only('index');
        //$this->middleware(['admin.auth:admin','admin.verified']);
        $this->middleware('verificarcontrasena', ['except' => ['cambiarContrasena','guardarContrasena']]);
        $this->middleware('nuevacontrasena', ['only' => ['cambiarContrasena','guardarContrasena']]);
    }

    /**
     * Show the Admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $semana = Semana::select('id_semana','nombre','url_logo')->where('vigente',1)->first();
        $instituciones = Institucion::select('id','nombre')->get();
        return view('admin.index',compact(['instituciones','semana']));
        return view('admin.home');
        $instituciones = Institucion::select('id','nombre')->get();
        return view('admin.dashboard',compact(['instituciones','semana'])); 
    }

    public function cambiarContrasena(){
        $imagen= VistaLogin::find(2);
        return view('admin.auth.passwords.contrasenaAdmin',compact(['imagen']));
    }

    public function guardarContrasena(UpdateContrasenaRequest $request){
        
        $admin = Admin::find(auth('admin')->user()->id);
        $admin->password = bcrypt($request->password);
        $admin->primerContrasena = Carbon::now();
        $admin->save();
        
        if($admin){
            return redirect()->route('admin.index');
        }
    }

    public function editarPerfil($id){
            if(Auth::guard('admin')->user()->id != $id){
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
            $admin = $admin = Admin::select('id','nombre','email')->where('id',$id)->first();
            return view('admin.editarPerfil',compact(['admin','semana','instituciones']));
    }

    public function editarAdmin(UpdateAdminRequest $request,$id){            
            $admin = Admin::find($id);    
            $admin->nombre = ucfirst($request->nombre);
            $admin->email = $request->email;
            if(!empty($request->password))
                $admin->password = bcrypt($request->password);
            
            $admin->save();
            
            return \Response::json($admin);
    }

    

}