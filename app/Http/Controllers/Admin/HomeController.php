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
        $this->middleware(['admin.auth:admin', 'admin.verified']);
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
        //$admin->password = bcrypt($request->password);
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
            $instituciones = Institucion::select('id','nombre','url_logo','latitud','longitud','telefono','direccion_web',DB::raw("CONCAT(calle,' #', numero, ', col. ', colonia , ', C.P.', cp) as domicilio "))->get();
            $semana = Semana::select('id_semana as id','url_logo','url_convocatoria')->where('vigente',1)->first();
            $admin = $admin = User::select('id','id_institucion','nombre','email')->where('id',$id)->first();
            return view('admin.editarPerfil',compact(['admin','semana','instituciones']));
    }

    public function editarAdmin(UpdateAdminRequest $request,$id){            
            $admin = Admin::find($id);    
            $admin->nombre = ucfirst($request->nombre);
            $admin->email = ucfirst($request->email);
            if(!empty($request->password))
                $admin->password = bcrypt($request->password);
            
            $admin->save();
            
            return \Response::json($admin);
    }

    

}