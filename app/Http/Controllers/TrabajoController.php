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

class TrabajoController extends Controller
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
        if($request->hasFile('url')){
            
            $imagencarrusel = $request->file('url');
            //agregar id de usuarios a nombre
            $nuevo_nombre = date("m-d-Y_h-i-s") ."_".$request->url . '.' . $imagencarrusel->getClientOriginalExtension();
            $imagencarrusel->move(public_path('documentos/trabajos'), $nuevo_nombre);
        }
        $trabajo = new Trabajo();
        $trabajo->id_alumno   = auth()->user()->id   ;
        $trabajo->id_director = $request->id_director;
        $trabajo->id_semana   = $request->id_semana  ;
        $trabajo->titulo      = $request->titulo     ;
        $trabajo->resumen     = $request->resumen    ;
        $trabajo->area        = $request->area       ;
        $trabajo->pal_clv1    = $request->clave1     ;
        $trabajo->pal_clv2    = $request->clave2     ;
        $trabajo->pal_clv3    = $request->clave3     ;
        $trabajo->pal_clv4    = $request->clave4     ;
        $trabajo->pal_clv5    = $request->clave5     ;
        $trabajo->url         = $nuevo_nombre        ;
    
        $trabajo->save();
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
    public function subirTrabajo(){
        //$usuario = User::find(auth()->user()->id);        
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
        $instituciones = Institucion::select('id','nombre','url_logo','latitud','longitud','telefono','direccion_web',DB::raw("CONCAT(calle,' #', numero, ', col. ', colonia , ', C.P.', cp) as domicilio "))->get();
        $semana = Semana::select('id_semana as id','url_logo','url_convocatoria')->where('vigente',1)->first();
        
        return view('trabajo.subirTrabajo', compact(['semana','instituciones','programa','modalidades']));
    }
}
