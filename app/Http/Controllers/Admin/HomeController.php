<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Institucion;
use App\Semana;

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
        $this->middleware('admin.auth:admin');
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

}