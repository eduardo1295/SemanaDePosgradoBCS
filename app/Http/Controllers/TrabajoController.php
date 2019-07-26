<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Semana;
use App\Noticia;
use App\Institucion;
use App\User;
use App\Modalidad;
use App\Posgrado;
use App\Alumno;
use App\Programa;
use App\Trabajo;
use DB;
use App\Http\Requests\trabajos\StoreTrabajoRequest;
use Notification;
use App\Notifications\RevisionTrabajo;
use App\Notifications\EntregaTrabajo;


use App\Mail\MensajesTrabajo;
use Illuminate\Support\Facades\Mail;

class TrabajoController extends Controller
{
    /*
    function __construct(){
        $this->middleware(['auth'], ['only' => ['show']]);
        //$this->middleware(['verificarcontrasena'], ['except' => ['cambiarContrasena','guardarContrasena','editarPerfil']]);
        //$this->middleware('nuevacontrasena', ['only' => ['cambiarContrasena','guardarContrasena']]);
    }
    */
    public function __construct(){
        $this-> middleware('auth')->only(['store','show','subirTrabajo']);
        $this->middleware(['verificarcontrasena','verified'])->only(['subirTrabajo']);
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
    public function store(StoreTrabajoRequest $request)
    {   
        
        $nuevo_nombre = 'sin Trabajo';
        if($request->hasFile('url')){
            $trabajoAlumno = $request->url;
            $nuevo_nombre = auth()->user()->nombre.'_'.auth()->user()->primer_apellido.'_'.auth()->user()->segundo_apellido . '.' . $trabajoAlumno->getClientOriginalExtension();
            $trabajoAlumno->move(public_path('documentos/trabajos'), $nuevo_nombre);
        }
        elseif (isset($request->auxUrl)) {
            $nuevo_nombre = $request->auxUrl;
        }
        $semana = Semana::all()->last();
        $trabajo = Trabajo::all()->where('id_alumno',auth()->user()->id)->where('id_semana',$semana->id_semana)->first();
        
        if($trabajo !=  null){
            if($trabajo->autorizado == 1){
                return \Response::json("ya autorizado");
            }
            else if($trabajo->revisado == 0){
                return \Response::json("ya autorizado");
            }
        }
        
        $trabajo = Trabajo::updateOrCreate(
            ['id_alumno' => auth()->user()->id, 'id_semana' => $semana->id_semana],
            [
             'id_director' => auth()->user()->alumnos()->get()[0]->id_director,
             'id_semana' => $request->id_semana  ,
             'titulo' => $request->titulo     ,
             'resumen' => $request->resumen    ,
             'area' => $request->area       ,
             'pal_clv1' => $request->pal_clv1   ,
             'pal_clv2' => $request->pal_clv2   ,
             'pal_clv3' => $request->pal_clv3   ,
             'pal_clv4' => $request->pal_clv4   ,
             'pal_clv5' => $request->pal_clv5   ,
             'url' => $nuevo_nombre,
             'id_alumno' => $request->id_alumno,
             'comentario' => null,
             'revisado' => 0,
             'modalidad' => $request->modalidad,
            ]
        );
        //dd($trabajo->directores()->first()->email);
        Notification::send($trabajo->directores()->first(), new EntregaTrabajo($trabajo->usuarios()->first()));
    
        return \Response::json($trabajo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $instituciones = Institucion::select('id','nombre','url_logo','latitud','longitud','telefono','direccion_web',DB::raw("CONCAT(calle,' #', numero, ', col. ', colonia , ', C.P.', cp) as domicilio "))->get();
        $semana = Semana::select('id_semana','url_logo')->where('vigente',1)->first();
        $trabajo = Trabajo::select('id_director','id_alumno','id_trabajo','url','comentario','autorizado')->where('id_alumno',$id)->where('id_semana',$semana->id_semana)->firstOrFail();
        if(auth()->user() && auth()->user()->hasRoles(['director','alumno'])){
            if(auth()->user()->hasRoles(['director'])){
                if(auth()->user()->id!=$trabajo->id_director)
                    return abort(403);
            }else if(auth()->user()->hasRoles(['alumno'])){
                if(auth()->user()->id!=$trabajo->id_alumno)
                    return abort(403);
            }
        }
        return view('director.revisarTrabajo',compact(['instituciones','trabajo','semana']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
    public function subirTrabajo(){
        //$usuario = User::find(auth()->user()->id); 
        //dd(auth()->user()->roles());       
        $alumno = auth()->user()->alumnos()->first();
        $programa = Programa::select('id_programa','nombre','nivel','periodo')->where('id',$alumno->id_programa)->first();
        //$modalidades = DB::select(DB::raw("SELECT modalidad_posgrado.id_modalidad, modalidad_posgrado.grado, modalidad_posgrado.periodo FROM modalidad_posgrado WHERE modalidad_posgrado.grado='".$programa->nivel ."' AND modalidad_posgrado.periodo='".$programa->periodo."'"));
        $modalidades = DB::select(DB::raw('SELECT modalidades.id_modalidad,modalidades.nombre '.
        'FROM modalidad_posgrado, modalidad_periodo, modalidades '.
        'WHERE modalidad_posgrado.grado="'. $programa->nivel .'" '.
        'AND modalidad_posgrado.periodo="'. $programa->periodo .'" '.
        'AND modalidad_posgrado.id = modalidad_periodo.id_posgrado '.
        'AND modalidad_posgrado.id_modalidad = modalidades.id_modalidad '.
        'AND ISNULL(modalidades.deleted_at)'.
        'AND modalidad_periodo.periodo_min <=' . $alumno->semestre .' '.
        'AND modalidad_periodo.periodo_max >=' . $alumno->semestre));
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
        
        $trabajo = Trabajo::all()->where('id_alumno',auth()->user()->id)->first();
        $director = User::find(auth()->user()->alumnos()->get()[0]->id_director);
        
        return view('trabajo.subirTrabajo', compact(['director','semana','instituciones','programa','modalidades','trabajo']));
    }

    public function revisionTrabajo(Request $request){
        //dd($request->revisado);
        $trabajo = Trabajo::find($request->id_trabajo);
        $trabajo->comentario = $request->comentario;
        if($request->revisado == 'Aceptado'){
            $trabajo->revisado = 1;
            $trabajo->autorizado = 1;
            $request->session()->put('mensaje', '1');
        }
        else if($request->revisado == 'Rechazado'){
            $trabajo->revisado = 1;
            $trabajo->autorizado = 0;
            $request->session()->put('mensaje', '0');
        }
        $trabajo->save();
        $value = session('mensaje');
        //dd($trabajo->usuarios()->first()->email);
        
        //Mail::to($trabajo->usuarios()->first()->email)->send(new MensajesTrabajo($request));
        dd("km");
        Notification::send($trabajo->usuarios()->first(), new RevisionTrabajo($request,$trabajo->id_alumno));
        return redirect()->route('director.revisarAlumnos');
    }
}
