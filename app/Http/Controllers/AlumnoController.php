<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Alumno;
use App\Institucion;
use App\Semana;
use DataTables;
use App;
use DB;
use File;
//use App\Http\Requests\coodinador\StoreCoordinadorRequest;
//use App\Http\Requests\usuarios\UpdateAlumnoRequest;
use App\Http\Requests\alumno\StoreAlumnoRequest;
use App\Http\Requests\alumno\UpdateAlumnoRequest;

use App\Http\Requests\usuarios\UpdateEditarPerfilRequest;
use Validator;

class AlumnoController extends Controller
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
    public function store(StoreAlumnoRequest $request)
    {
        
        $auxInstitucion = "";
        if (auth('admin')->user()){
            $auxInstitucion = $request->id_institucion_al;
        }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
            $auxInstitucion = auth()->user()->id_institucion;
        }

        $user = new User([
            'nombre'     => $request->nombre_al,
            'email'     => $request->email_al,
            'password' => bcrypt($request->password_al),
            'primer_apellido'   => $request->primer_apellido_al, 
            'segundo_apellido'  => $request->segundo_apellido_al, 
            'id_institucion'    => $auxInstitucion,
            'id_semana' => Semana::select('id_semana','vigente')->where('vigente',1)->get()[0]->id_semana,
        ]);
        $user->save();
        
        if($user){
            
            $user->alumnos()->create(['num_control'=>$request->num_control_al,
                                    'semestre'=>$request->semestre_al,
                                    'id_director'=>$request->directorSelect_al,
                                    'id_programa'=>$request->programaSelect_al
                                    ]);
            $user->roles()->attach([$user->id => ['id_rol'=>'5', 'creada_por'=>'1']]);
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
    public function edit($id)
    {
        if(auth()->user() && auth()->user()->hasRoles(['alumno'])){
            $instituciones = Institucion::select('id','nombre','url_logo','latitud','longitud','telefono','direccion_web',DB::raw("CONCAT(calle,' #', numero, ', col. ', colonia , ', C.P.', cp) as domicilio "))->get();
            $semana = Semana::select('id_semana as id','url_logo','url_convocatoria')->where('vigente',1)->first();
            $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('alumnos:id,semestre,num_control','instituciones:id,nombre')->where('id',$id)->first();
            return view('alumno.editarAlumno',compact(['usuario','semana','instituciones']));
        }else if (auth('admin')->user() || (auth()->user() && auth()->user()->hasRoles(['coordinador'])) ) {
            $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('alumnos:alumnos.id,alumnos.id_programa,semestre,num_control,alumnos.id_director','instituciones:id,nombre','programas:programas.id,programas.id_programa,programas.nombre')->where('id',$id)->first();
            //$director = User::select('users.id')->whereHas('roles', function($q){$q->where('nombre', '=', 'director');})->where('id',$usuario->alumnos->id_director)->first();
            return \Response::json([$usuario]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlumnoRequest $request, $id)
    {
        
        if(auth()->user() && auth()->user()->hasRoles(['alumno'])){
            $user = User::find($id);    
            $user->nombre = ucfirst($request->nombre_al);
            $user->primer_apellido = ucfirst($request->primer_apellido_al);
            $user->segundo_apellido = ucfirst($request->segundo_apellido_al);
            if(!empty($request->password_al))
                $user->password = bcrypt($request->password_al);
            
            $user->save();
        }else if (auth('admin')->user() || (auth()->user() && auth()->user()->hasRoles(['coordinador'])) ) {
            $user = User::find($id);
            $user->nombre = ucfirst($request->nombre_al);
            $user->primer_apellido = ucfirst($request->primer_apellido_al);
            $user->segundo_apellido = ucfirst($request->segundo_apellido_al);
            if (auth('admin')->user()){
                $user->id_institucion = $request->id_institucion_al;
            }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
                $user->id_institucion = auth()->user()->id_institucion;
            }
            $user->id_semana = Semana::select('id_semana','vigente')->where('vigente',1)->get()[0]->id_semana;
            
            if(!empty($request->password_al))
                $user->password = bcrypt($request->password_al);
            
            $user->save();
            
            if($user){
                $user->alumnos()->update(['num_control'=>$request->num_control_al,
                                        'semestre'=>$request->semestre_al,
                                        'id_director'=>$request->directorSelect_al,
                                        'id_programa'=>$request->programaSelect_al
                                        ]);
                $user->roles()->sync([$user->id => ['id_rol'=>'5', 'creada_por'=>'1']]);
            }
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
    public function alumnos(){
        $semana = Semana::select('id_semana','vigente','url_logo')->where('vigente',1)->first();
        $instituciones = Institucion::select('id','nombre')->get();
        return view('admin.alumnos.adminAlumno',compact(['instituciones','semana']));   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAlumnos(Request $request ){
        $busqueda = $request->busqueda;
        if($busqueda == 'activos'){
            //AND users.id_institucion = ?'
            $finalConsulta="";
            if (auth('admin')->user()){
                $finalConsulta = ' users.id_institucion = instituciones.id';
                
            }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
                $finalConsulta = ' programas.id_institucion = instituciones.id AND users.id_institucion = ?';
                
            }
            
            $consulta = 'SELECT * FROM (SELECT alumnos.id, alumnos.num_control,alumnos.id_director,'.
            ' users.nombre,users.primer_apellido,users.segundo_apellido,users.email,'.
            ' users.fecha_actualizacion as fecha_usuario,instituciones.nombre AS institucion_nombre,'.
            ' programas.nombre AS programa_nombre FROM alumnos,users,programas, instituciones'.
            ' WHERE alumnos.id=users.id AND alumnos.id_programa=programas.id AND'. $finalConsulta .' AND users.deleted_at IS NULL) t1'.
            ' inner JOIN (SELECT users.id AS id_dir, users.nombre AS director_nombre, users.primer_apellido AS director_pa, users.segundo_apellido AS director_sa FROM users,directores_tesis WHERE users.id = directores_tesis.id) t2 ON t1.id_director = t2.id_dir;';

            /*
            $consulta = 'SELECT alumnos.num_control,alumnos.id,'.
            ' users.nombre,users.id,users.primer_apellido,users.segundo_apellido,users.email,'.
            ' users.fecha_actualizacion as fecha_usuario,instituciones.nombre AS institucion_nombre,'.
            ' programas.nombre AS programa_nombre FROM alumnos,users,programas, instituciones'.
            ' WHERE alumnos.id=users.id AND users.id_institucion = instituciones.id AND alumnos.id_programa=programas.id AND users.deleted_at IS NULL';
            */
            $alumnos ="";
            if (auth('admin')->user()){
                $alumnos = DB::select(DB::raw($consulta));
                
            }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
                
                
                $alumnos = DB::select($consulta,[auth()->user()->id_institucion]);
                
            }
            

            $usuarios = User::select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('alumnos:alumnos.id,alumnos.id_programa,num_control,semestre,constancia_generada,fecha_constancia,gafete_generado,fecha_gafete','instituciones:instituciones.id,instituciones.nombre','programas:programas.id,programas.id_programa,programas.nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'alumno');});
            return datatables()->of($alumnos)
            ->addColumn('director', function($alumnos){
                return $alumnos->director_nombre .' '. $alumnos->director_pa .' '. $alumnos->director_sa;
            }
            
            )
            ->addColumn('action', 
            '<div style="text-align:center;width:100px" class="mx-auto">

            <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $id }}" title="Editar" data-placement="top"
                style="height:40px" class="edit btn btn-xs btn-primary editarAlumno">
                <span><i class="fas fa-edit"></i>
                </span></a>
        
        
            <a href="javascript:void(0);" id="eliminar" data-toggle="tooltip" title="Eliminar" data-placement="top"
                data-id="{{ $id }}" class="delete btn btn-xs btn-danger eliminarAlumno" style="height:40px">
                <span><i class="fas fa-trash-alt"></i>
                </span></a>
            </div>'
            
            )
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
        }else if($busqueda == 'eliminados'){
            $consulta = 'SELECT alumnos.num_control,alumnos.id,'.
            ' users.nombre,users.id,users.primer_apellido,users.segundo_apellido,users.email,'.
            ' users.fecha_actualizacion as fecha_usuario,instituciones.nombre AS institucion_nombre,'.
            ' programas.nombre AS programa_nombre FROM alumnos,users,programas, instituciones'.
            ' WHERE alumnos.id=users.id AND alumnos.id_programa=programas.id AND users.id_institucion = instituciones.id AND users.deleted_at IS NOT NULL';
            $alumnos = new User();
            if (auth('admin')->user()){
                $alumnos = DB::select(DB::raw($consulta. ' AND users.id_institucion = instituciones.id'));
                
            }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
                $consultaF = $consulta.' AND users.id_institucion = ?';
                
                $alumnos = DB::select($consultaF,[auth()->user()->id_institucion]);
                
            }
            $usuarios = User::onlyTrashed()->select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('alumnos:alumnos.id,alumnos.id_programa,num_control,semestre,constancia_generada,fecha_constancia,gafete_generado,fecha_gafete','instituciones:instituciones.id,instituciones.nombre','programas:programas.id,programas.id_programa,programas.nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'alumno');});
            return datatables()->of($alumnos)
            ->addColumn('action', 
            '<div style="text-align:center;width:100px" class="mx-auto">

            <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $id }}" title="Activar"
                style="height:40px" class="btn btn-xs btn-warning reactivarAlumno">
                <span><i class="fas fa-redo"></i>
                </span></a>
            </div>
            ')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();   
        }
    }
    /*
    public function editarAlumno(){
        dd(auth()->user()->nombre);
        
        return view('alumno.editarAlumno');
    }
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function programasLista($id){
        $auxInstitucion = "";
        if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
            $auxInstitucion = auth()->user()->id_institucion;
        }else{
            $auxInstitucion = $id;
        }
        $programas = Institucion::select('instituciones.id')->with('programas:programas.id_institucion,programas.id,programas.id_programa,programas.nombre')->where('id',$auxInstitucion)->get();
        $directores = User::select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('directortesis:directores_tesis.id')->whereHas('roles', function($q){$q->where('nombre', '=', 'director');})->where('id_institucion',$auxInstitucion)->get();
        
        $busquedas = collect([$programas[0]->programas, $directores]);
        return $busquedas;
        
    }

    public function generarGafete(){
        $semana = Semana::select('nombre','url_logo')->where('vigente',1)->first();
        $instituciones = DB::select(DB::raw("SELECT instituciones.id,instituciones.url_logo,nombre,siglas 
                                             FROM instituciones WHERE deleted_at IS NULL ORDER BY nombre"));
                                        
        $alumno = User::select('id','id_institucion','email','nombre','primer_apellido','segundo_apellido')
                        ->with('alumnos:alumnos.id,num_control','instituciones:id,nombre,siglas')
                        ->where('id',auth()->user()->id)->first();
        
        $imagenes="";
        $logo =  asset('img/semanaLogo/'.$semana->url_logo);
        $imagenes .= '<img style="vertical-align: top;width:100px;height:70px;"src = "'.$logo.'">';
        foreach ($instituciones as $insticion){
            $ruta =  asset('img/logo/'.$insticion->url_logo);
            $imagenes .= '<img style="vertical-align: top;width:100px;height:80px;"src = "'.$ruta.'">';
        }
            
        $conacyt =  asset('img/logo/conacyt.png');    
        $imagenes .= '<img style="vertical-align: top;width:100px;height:70px;"src = "'.$conacyt.'">';
        
        $pdf = App::make('dompdf.wrapper');
        //$pdf->setPaper('A6','portrait');
        $pdf->setPaper('letter','portrait');
        //$pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadView('alumno.generarGafete',['alumno' => $alumno, 'imagenes' => $imagenes, 'semana' => $semana]);
        
        $output = $pdf->output();
        File::put(public_path().'/gafete.pdf',$output);

        $instituciones = DB::select(DB::raw('SELECT instituciones.id, instituciones.nombre, instituciones.latitud, instituciones.longitud,'.
		' instituciones.siglas, instituciones.telefono, instituciones.direccion_web,'.
		' instituciones.url_logo, instituciones.ciudad, users.id, users.id_institucion, coordinadores.id,'.
		' rol_usuario.id_usuario, rol_usuario.id_rol,users.email,'.
		' CONCAT(users.nombre," ", users.primer_apellido, " ", users.segundo_apellido) AS coordinador_nombre,'.
		' CONCAT(instituciones.calle," #", instituciones.numero, ", col. ", instituciones.colonia , ", C.P.", instituciones.cp) AS domicilio'.
		' FROM instituciones, coordinadores, users, rol_usuario'.
		' WHERE '.
		' users.id_institucion = instituciones.id'.
		' AND rol_usuario.id_usuario = users.id'.
		' AND users.id = coordinadores.id'.
		' AND rol_usuario.id_rol = 3;'));
        
        
        return view('alumno.mostrarGafete', compact(['semana','instituciones','pdf']));
        //return view('alumno.generarGafete',compact(['alumno','imagenes','semana']));   
    }
}
