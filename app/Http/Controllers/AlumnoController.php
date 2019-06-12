<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Alumno;
use App\Institucion;
use App\Semana;
use DataTables;
use DB;
//use App\Http\Requests\coodinador\StoreCoordinadorRequest;
//use App\Http\Requests\usuarios\UpdateAlumnoRequest;
use App\Http\Requests\alumno\StoreAlumnoRequest;
use App\Http\Requests\alumno\UpdateAlumnoRequest;
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
        $user = new User([
            'nombre'     => $request->nombre_al,
            'email'     => $request->email_al,
            'password' => bcrypt($request->password_al),
            'primer_apellido'   => $request->primer_apellido_al, 
            'segundo_apellido'  => $request->segundo_apellido_al, 
            'id_institucion'    => $request->id_institucion_al,
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
        if(auth()->user()){
            $instituciones = Institucion::select('id','nombre','url_logo','latitud','longitud','telefono','direccion_web',DB::raw("CONCAT(calle,' #', numero, ', col. ', colonia , ', C.P.', cp) as domicilio "))->get();
            $semana = Semana::select('id_semana as id','url_logo','url_convocatoria')->where('vigente',1)->first();
            $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('alumnos:id,semestre,num_control','instituciones:id,nombre')->where('id',$id)->first();
            return view('alumno.editarAlumno',compact(['usuario','semana','instituciones']));
        }else if (auth('admin')->user()) {
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
        if(auth()->user()){
            $user = User::find($id);    
            $user->nombre = ucfirst($request->nombre_al);
            $user->primer_apellido = ucfirst($request->primer_apellido_al);
            $user->segundo_apellido = ucfirst($request->segundo_apellido_al);
            if(!empty($request->password_al))
                $user->password = bcrypt($request->password_al);
            
            $user->save();
        }else if (auth('admin')->user()) {
            $user = User::find($id);
            $user->nombre = ucfirst($request->nombre_al);
            $user->primer_apellido = ucfirst($request->primer_apellido_al);
            $user->segundo_apellido = ucfirst($request->segundo_apellido_al);
            $user->id_institucion = $request->id_institucion_al;
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
            $alumnos = DB::select(DB::raw('SELECT alumnos.num_control,alumnos.id,'.
            ' users.nombre,users.id,users.primer_apellido,users.segundo_apellido,users.email,'.
            ' users.fecha_actualizacion as fecha_usuario,instituciones.nombre AS institucion_nombre,'.
            ' programas.nombre AS programa_nombre FROM alumnos,users,programas, instituciones'.
            ' WHERE alumnos.id=users.id AND alumnos.id_programa=programas.id AND users.id_institucion = instituciones.id AND users.deleted_at IS NULL'));

            $usuarios = User::select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('alumnos:alumnos.id,alumnos.id_programa,num_control,semestre,constancia_generada,fecha_constancia,gafete_generado,fecha_gafete','instituciones:instituciones.id,instituciones.nombre','programas:programas.id,programas.id_programa,programas.nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'alumno');});
            return datatables()->of($alumnos)
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
            $alumnos = DB::select(DB::raw('SELECT alumnos.num_control,alumnos.id,'.
            ' users.nombre,users.id,users.primer_apellido,users.segundo_apellido,users.email,'.
            ' users.fecha_actualizacion as fecha_usuario,instituciones.nombre AS institucion_nombre,'.
            ' programas.nombre AS programa_nombre FROM alumnos,users,programas, instituciones'.
            ' WHERE alumnos.id=users.id AND alumnos.id_programa=programas.id AND users.id_institucion = instituciones.id AND users.deleted_at IS NOT NULL'));

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
        $programas = Institucion::select('instituciones.id')->with('programas:programas.id_institucion,programas.id,programas.id_programa,programas.nombre')->where('id',$id)->first();
        $directores = User::select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('directortesis:directores_tesis.id,directores_tesis.grado')->whereHas('roles', function($q){$q->where('nombre', '=', 'director');})->where('id_institucion',$id)->get();
        $busquedas = collect([$programas->programas, $directores]);
        return $busquedas;
        
    }
}
