<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Semana;
use App\VistaLogin;
use DB;

class VistaLoginController extends Controller
{
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
        
        if($request->hasFile('imagenUsuario')){
            
            $imagenUsuario = $request->file('imagenUsuario');
            //agregar id de usuarios a nombre
            $nuevo_nombre = 'fondo.'.$imagenUsuario->getClientOriginalExtension();
            $imagenUsuario->move(public_path('img/fondo'), $nuevo_nombre);
        }
        
        
        return \Response::json(['nombre' => $nuevo_nombre ],201);
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
}
