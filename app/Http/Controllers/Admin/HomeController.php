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

}