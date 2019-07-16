<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Semana;
use App\VistaLogin;
use DB;

class VistaLoginController extends Controller
{
    public function __construct(){
        $this->middleware('admin.auth:admin');

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
    public function store(Request $request)
    {
        $nuevo_nombre = 'sin imagen';
        $nuevo_nombre_admin = 'sin imagen';
        
        if($request->hasFile('imagenUsuario')){
            $usuario = VistaLogin::find(1);
            if($usuario != null){
                $usuario->url_imagen = 'fondo.jpg';
                $usuario->save();
            }
            else {
                $usuario = new VistaLogin();
                $usuario->id = 1;
                $usuario->url_imagen = 'fondo.jpg';
                $usuario->save();
            }
            
            $imagenUsuario = $request->file('imagenUsuario');
            //agregar id de usuarios a nombre
            $nuevo_nombre = 'fondo.'.$imagenUsuario->getClientOriginalExtension();
            $imagenUsuario->move(public_path('img/fondo'), $nuevo_nombre);
        }
        if($request->hasFile('imagenAdmin')){

            $admin = VistaLogin::find(2);
            if($admin != null){
                $admin->url_imagen = 'fondoAdmin.jpg';
                $admin->save();
            }
            else {
                $admin = new VistaLogin();
                $admin->id = 2;
                $admin->url_imagen = 'fondoAdmin.jpg';
                $admin->save();
            }

            $imagenAdmin = $request->file('imagenAdmin');
            //agregar id de usuarios a nombre
            $nuevo_nombre_admin = 'fondoAdmin.'.$imagenAdmin->getClientOriginalExtension();
            $imagenAdmin->move(public_path('img/fondo'), $nuevo_nombre_admin);
        }
        
        
        return \Response::json(['nombre' => $nuevo_nombre, 'nombreAdmin' => $nuevo_nombre_admin],201);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function vistaLogin(){
        $semana = Semana::select('id_semana','nombre','url_logo')->where('vigente',1)->first();
        $vistas = VistaLogin::All();
        return view('admin.vistaLogin.adminVistaLogin',compact(['semana','vistas']));
        
    }
    public function disenoColores(){
        $semana = Semana::select('id_semana','nombre','url_logo')->where('vigente',1)->first();
        $vistas = VistaLogin::All();
        return view('admin.vistaLogin.adminColor',compact(['semana','vistas']));
        
    }

    public function cambiarColores(Request $request){
            $auxiliar = $request->toArray();
            //dd($auxiliar);
            $j=3;
            foreach ($auxiliar as $key => $row) {
                //dd($key);
                $colores = VistaLogin::find($j);
                if($colores != null){
                    //dd($row);
                    $colores->url_imagen = $row;
                }
                else {
                    $colores = new VistaLogin();
                    $colores->id = $j;
                    $colores->url_imagen = $row;
                }
                $colores->save();
                $j++;
            }
        return \Response::json(['nombre' => 'Listo'],201);
    }
}
