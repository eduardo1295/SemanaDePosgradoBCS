<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use File;
use Jenssegers\Date\Date;
use Dompdf\Dompdf;
use App\Trabajo;
use App\Modalidad;
use App\Semana;
use App\Institucion;
use App\Locacion;
use App\Sesion;
use App\Http\Requests\sesiones\StoreSesionRequest;
use DB;

class SesionController extends Controller
{
    public function __construct(){
        //$this-> middleware('auth:admin');
        $this->middleware(['admin.auth:admin','verificarcontrasena','admin.verified'])->only('sesiones');
        $this-> middleware(['esusuario'])->only(['store','update','edit','destroy']);
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
    public function store(StoreSesionRequest $request)
    //public function store(Request $request)
    {   
        if(!isset($request->trabajos)){
            $error = 'seleccion';
                return \Response::json($error);
        }
        $sesion = new Sesion();
        $sesion->id_modalidad = $request->modalidad;
        $modalidad = Modalidad::select('nombre')->where('id_modalidad',$request->modalidad)->first();
        $sesion->nombre = $modalidad->nombre;
        $sesion->dia = $request->dia;
        $sesion->hora_inicio = $request->hora_inicio;
        $sesion->hora_fin = $request->hora_fin;
        $sesion->cantidad = $request->cantidad;
        $sesion->lugar = $request->lugar;
        $sesiones_Agregadas  = Sesion::select('hora_inicio','hora_fin')->get();
        $vuelta = 0;
        foreach($sesiones_Agregadas as $agregadas){
            $error = 'cruze';
            if($sesion->hora_inicio > $agregadas->hora_inicio && $sesion->hora_inicio < $agregadas->hora_fin){
                return \Response::json($error);
            }elseif($sesion->hora_fin > $agregadas->hora_inicio && $sesion->hora_fin < $agregadas->hora_fin){
                return \Response::json($error);
            }elseif($sesion->hora_inicio < $agregadas->hora_inicio && $sesion->hora_fin > $agregadas->hora_fin){
                return \Response::json($error);
            }
            $vuelta++;  
        }
        $sesion->save();
        foreach($request->trabajos as $trab){
            $trabajo = Trabajo::find($trab);
            $trabajo->id_sesion = $sesion->id_sesion; 
            $trabajo->save();
        }
        $consulta ="SELECT id_alumno,sesiones.id_sesion,modalidad,titulo,id_programa,users.id_institucion,users.nombre,primer_apellido,segundo_apellido, dia,
                    hora_inicio, hora_fin,area,siglas,lugar
                    FROM trabajos,alumnos,users,sesiones,instituciones
                    WHERE id_alumno = alumnos.id AND users.id = alumnos.id AND sesiones.id_sesion = trabajos.id_sesion AND 
                          trabajos.id_sesion != 0 AND modalidad = $sesion->id_modalidad AND instituciones.id = users.id_institucion
                    ORDER BY dia ASC, hora_inicio ASC;";
        $trabajos = DB::select($consulta);

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('letter','landscape');
        //$pdf->loadHTML('<h1>Test</h1>');
        $modalidad = Modalidad::all()->where('id_modalidad',$sesion->id_modalidad)->first();
        $semana = Semana::All()->where('vigente',1)->first();
        $fInicio = new Date($semana->fecha_inicio);
        $fFin = new Date($semana->fecha_fin);
        $fInicio = $fInicio->format('l d').' de '.$fInicio->format('F');
        $fFin = $fFin->format('l d').' de '.$fFin->format('F').' del '.$fFin->format('Y');
        $pdf->loadView('prueba',['trabajo' => $trabajos, 'modalidad' => $modalidad, 'semana' => $semana ,'fInicio' => $fInicio, 'fFin' => $fFin]);
        $output = $pdf->output();
        File::put(storage_path().'/app/public/documentos/modalidad/'.$modalidad->nombre .'.pdf',$output);
        return \Response::json("Listo");
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
        $sesion = Sesion::find($id);

        return \Response::json($sesion);
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
        if(!isset($request->trabajos)){
            $error = 'seleccion';
                return \Response::json($error);
        }
        $sesiones_Agregadas  = Sesion::select('hora_inicio','hora_fin','lugar')->where('id_sesion','!=',$id)->get();
        $vuelta = 0;
        
        foreach($sesiones_Agregadas as $agregadas){
            $error = 'cruze';
            if($request->hora_inicio >= $agregadas->hora_inicio && $request->hora_inicio <= $agregadas->hora_fin && $agregadas->lugar == $request->lugar){
                return \Response::json($error);
            }elseif($request->hora_fin >= $agregadas->hora_inicio && $request->hora_fin <= $agregadas->hora_fin && $agregadas->lugar == $request->lugar){
                return \Response::json($error);
            }elseif($request->hora_inicio <= $agregadas->hora_inicio && $request->hora_fin >= $agregadas->hora_fin && $agregadas->lugar == $request->lugar){
                return \Response::json($error);
            }
            $vuelta++;  
        }
        
        $sesion = Sesion::find($id);
        $sesion->id_modalidad = $request->modalidad;
        $modalidad = Modalidad::select('nombre')->where('id_modalidad',$request->modalidad)->first();
        $sesion->nombre = $modalidad->nombre;
        $sesion->dia = $request->dia;
        $sesion->hora_inicio = $request->hora_inicio;
        $sesion->hora_fin = $request->hora_fin;
        $sesion->cantidad = $request->cantidad;
        $sesion->lugar = $request->lugar;
        
        $sesion->save();

        $auxTrabajos = Trabajo::where('id_sesion',$id)->get();
        foreach ($auxTrabajos as $auxTrabajo) {
            $auxTrabajo->id_sesion = 0;
            $auxTrabajo->save();
        }

        foreach($request->trabajos as $trab){
            $trabajo = Trabajo::find($trab);
            $trabajo->id_sesion = $sesion->id_sesion; 
            $trabajo->save();
        }
        $consulta ="SELECT id_alumno,sesiones.id_sesion,modalidad,titulo,id_programa,users.id_institucion,users.nombre,primer_apellido,segundo_apellido, dia,
                    hora_inicio, hora_fin,area,siglas,lugar
                    FROM trabajos,alumnos,users,sesiones,instituciones
                    WHERE id_alumno = alumnos.id AND users.id = alumnos.id AND sesiones.id_sesion = trabajos.id_sesion AND 
                          trabajos.id_sesion != 0 AND modalidad = $sesion->id_modalidad AND instituciones.id = users.id_institucion
                    ORDER BY dia ASC, hora_inicio ASC;";
        $trabajos = DB::select($consulta);

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('letter','landscape');
        //$pdf->loadHTML('<h1>Test</h1>');
        $modalidad = Modalidad::all()->where('id_modalidad',$sesion->id_modalidad)->first();
        $semana = Semana::All()->last();
        $fInicio = new Date($semana->fecha_inicio);
        $fFin = new Date($semana->fecha_fin);
        $fInicio = $fInicio->format('l d').' de '.$fInicio->format('F');
        $fFin = $fFin->format('l d').' de '.$fFin->format('F').' del '.$fFin->format('Y');
        $pdf->loadView('prueba',['trabajo' => $trabajos, 'modalidad' => $modalidad, 'semana' => $semana ,'fInicio' => $fInicio, 'fFin' => $fFin]);
        $output = $pdf->output();
        File::put(public_path().'/storage/documentos/modalidad/'.$modalidad->nombre .'.pdf',$output);
        return \Response::json("Listo");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        // $trabajos = Trabajo::where('id_sesion',$id)->get();
        // foreach ($trabajos as $trabajo) {
        //     $trabajo->id_sesion = 0;
        //     $trabajo->save();
        // }
        $trabajo = Trabajo::where('id_sesion', '=', $id)->update(['id_sesion' => 0]);
        $sesion = Sesion::find($id);
        
        $consulta ="SELECT id_alumno,sesiones.id_sesion,modalidad,titulo,id_programa,users.id_institucion,users.nombre,primer_apellido,segundo_apellido, dia,
                    hora_inicio, hora_fin,area,siglas,lugar
                    FROM trabajos,alumnos,users,sesiones,instituciones
                    WHERE id_alumno = alumnos.id AND users.id = alumnos.id AND sesiones.id_sesion = trabajos.id_sesion AND 
                          trabajos.id_sesion != 0 AND modalidad = $sesion->id_modalidad AND instituciones.id = users.id_institucion
                    ORDER BY dia ASC, hora_inicio ASC;";
        $traba = DB::select($consulta);

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('letter','landscape');
        //$pdf->loadHTML('<h1>Test</h1>');
        $modalidad = Modalidad::all()->where('id_modalidad',$sesion->id_modalidad)->first();
        $semana = Semana::All()->last();
        $fInicio = new Date($semana->fecha_inicio);
        $fFin = new Date($semana->fecha_fin);
        $fInicio = $fInicio->format('l d').' de '.$fInicio->format('F');
        $fFin = $fFin->format('l d').' de '.$fFin->format('F').' del '.$fFin->format('Y');
        $pdf->loadView('prueba',['trabajo' => $traba, 'modalidad' => $modalidad, 'semana' => $semana ,'fInicio' => $fInicio, 'fFin' => $fFin]);
        $output = $pdf->output();
        File::put(storage_path().'/app/public/documentos/modalidad/'.$modalidad->nombre .'.pdf',$output);
        
        $sesion->forceDelete();
        return \Response::json($sesion);
    }


    public function sesiones(){
        $semana = Semana::select('id_semana','nombre','url_logo','fecha_inicio','fecha_fin')->where('vigente',1)->first();
        
        $modalidades = Modalidad::select('id_modalidad','nombre')->get();
            
        if($semana != NULL){
            $horarios = DB::select(DB::raw("SELECT ADDDATE('$semana->fecha_inicio', INTERVAL @i:=@i+1 DAY) AS DAY FROM (
            SELECT a.a
            FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
            CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
            CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
            ) a
            JOIN (SELECT @i := -1) r1
            WHERE 
            @i < DATEDIFF('$semana->fecha_fin','$semana->fecha_inicio')"));
        }
        
        //dd($horarios[0]->DAY);
        $locaciones = DB::select("select locaciones.id_locacion as id_locacion, locaciones.nombre as nombre from locaciones,semanas where semanas.vigente = 1 AND id_sede = id_institucion");
        return view('admin.modalidad.adminSesiones',compact(['semana','modalidades','horarios','locaciones']));
        
    }

    public function listSesiones(Request $request ){
        $busqueda = $request->busqueda;
        if($busqueda == 'activos'){
            $selectnoticias = DB::select("select id_sesion as id, s.nombre, dia ,hora_inicio,hora_fin, l.nombre as lugar from sesiones s, locaciones l where s.lugar = l.id_locacion;");
            return datatables()->of($selectnoticias)
            ->addColumn('action', 
            '<div style="text-align:center;width:100px" class="mx-auto">

            <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $id }}" title="Editar" data-placement="top"
                style="height:40px" class="edit btn btn-xs btn-primary editarSesion">
                <span><i class="fas fa-edit"></i>
                </span></a>
        
        
            <a href="javascript:void(0);" id="eliminar" data-toggle="tooltip" title="Eliminar" data-placement="top"
                data-id="{{ $id }}" class="delete btn btn-xs btn-danger eliminarSesion" style="height:40px">
                <span><i class="fas fa-trash-alt"></i>
                </span></a>
            </div>'
            
            )
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $selectnoticias = Modalidad::onlyTrashed()->get(['id_modalidad as id','nombre','descripcion','fecha_actualizacion']);
            return datatables()->of($selectnoticias)
            ->addColumn('action', 'admin.reactivar')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
    public function alumnosSeleccionados(Request $request,$opcion,$sesion){
        if($opcion == 1){
            $alumnos = Trabajo::select('id_alumno', 'id_trabajo','id_sesion')
            ->with('alumnos:id,id_programa','usuarios:id,id_institucion,nombre,primer_apellido,segundo_apellido')
            ->where('modalidad',$request->modalidad)->where('id_sesion','=',0)->get();    
        }else if($opcion == 2){
            $alumnos = Trabajo::select('id_alumno', 'id_trabajo','id_sesion')
                ->with('alumnos:id,id_programa','usuarios:id,id_institucion,nombre,primer_apellido,segundo_apellido')
                ->where('modalidad',$request->modalidad)
                ->where('id_sesion',0)
                ->orWhere('id_sesion',$sesion)
                ->get();
                
        }
        

        return \Response::json($alumnos);
    }

}
