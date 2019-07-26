<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Imports\UsersImport;
use App\Alumno;
use App\Institucion;
use App\Programa;
use App\Semana;
use DataTables;
use App;
use DB;
use File;
use Jenssegers\Date\Date;
//use App\Http\Requests\coodinador\StoreCoordinadorRequest;
//use App\Http\Requests\usuarios\UpdateAlumnoRequest;
use App\Http\Requests\alumno\StoreAlumnoRequest;
use App\Http\Requests\alumno\UpdateAlumnoRequest;
use App\Http\Requests\excel\ExcelRequest;
use Excel;
use App\Http\Requests\usuarios\UpdateEditarPerfilRequest;
use Validator;
use App\Exports\AlumnosExportar;
use Illuminate\Support\Arr;

class AlumnoController extends Controller
{
    public function __construct(){
        $this->middleware(['admin.auth:admin','verificarcontrasena','admin.verified'])->only(['alumnos']);
        $this-> middleware('auth')->only('generarGafete');
        $this->middleware(['verificarcontrasena','verified'])->only(['generarGafete','edit']);
        $this-> middleware(['esusuario'])->only(['store','update','edit','destroy','reactivar']);

     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
        return Excel::download(new AlumnosExportar, 'users.xlsx');
        (new AlumnosExportar)->store('invoices.xlsx');

return back()->withSuccess('Export started!');
        (new AlumnosExportar)->store('invoices.xlsx');
*/
       
        
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
        if($request->ajax()){
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
            $user->roles()->attach([$user->id => ['id_rol'=>'5']]);
        }
        
        return \Response::json($user);
        }else {
            return abort(403);
        }
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
    public function edit(Request $request, $id)
    {
        
        if(auth()->user() && auth()->user()->hasRoles(['alumno'])){
            if(auth()->user()->id != $id){
                return abort(403);
            }
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
                $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('alumnos:id,semestre,num_control','instituciones:id,nombre')->where('id',$id)->first();
                return view('alumno.editarAlumno',compact(['usuario','semana','instituciones']));
            
        }else if ($request->ajax() && (auth('admin')->user() || (auth()->user() && auth()->user()->hasRoles(['coordinador'])) )) {
            $usuario = User::select('id','id_institucion','nombre','primer_apellido','segundo_apellido','email')->with('alumnos:alumnos.id,alumnos.id_programa,semestre,num_control,alumnos.id_director','instituciones:id,nombre','programas:programas.id,programas.id_programa,programas.nombre')->where('id',$id)->first();
            //$director = User::select('users.id')->whereHas('roles', function($q){$q->where('nombre', '=', 'director');})->where('id',$usuario->alumnos->id_director)->first();
            return \Response::json([$usuario]);
        }else {
            return abort(403);
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
                $user->roles()->sync([$user->id => ['id_rol'=>'5']]);
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
    public function destroy(Request $request, $id)
    {
        if($request->ajax()){
        $user = User::where('id',$id)->delete();
        return \Response::json($user);
        }else{
            return abort(403);
        }
    }

    /**
     * reactiva el recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reactivar(Request $request, $id)
    {
        if($request->ajax()){
        $user = User::withTrashed()->where('id',$id)->restore();
        return \Response::json($user);
        }else{
            return abort(403);
        }
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
        if(!auth()->user() && !auth('admin')->user()){
            return abort(403);
        }
        
        $semana = DB::select(DB::raw("SELECT semanas.id_semana	
		FROM semanas
        WHERE vigente = 1"));
        $id_selectSemana = $semana[0]->id_semana;
        $busqueda = $request->busqueda;
        if($busqueda == 'activos' || $busqueda == 'activoscoor'){
            //AND users.id_institucion = ?'
            $finalConsulta="";
            if(auth('admin')->user() || ($busqueda != 'activoscoor' && auth()->user() && auth()->user()->hasRoles(['subadmin']))){
                $finalConsulta = ' users.id_institucion = instituciones.id';
                
            }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
                $finalConsulta = ' programas.id_institucion = instituciones.id AND users.id_institucion = ?';
                
            }
            
            $consulta = "SELECT * FROM (SELECT alumnos.id, alumnos.num_control,alumnos.id_director,
             users.nombre,users.primer_apellido,users.segundo_apellido,users.email,
             users.fecha_actualizacion as fecha_usuario,instituciones.nombre AS institucion_nombre,
             (SELECT id_semana FROM alumno_constancia WHERE id_semana = $id_selectSemana  AND id_alumno=alumnos.id ) AS id_sem_constancia, 
             programas.nombre AS programa_nombre FROM alumnos,users,programas, instituciones
             WHERE alumnos.id=users.id AND alumnos.id_programa=programas.id AND $finalConsulta AND users.deleted_at IS NULL) t1
             INNER JOIN (SELECT users.id AS id_dir, users.nombre AS director_nombre, users.primer_apellido AS director_pa, users.segundo_apellido AS director_sa FROM users,directores_tesis WHERE users.id = directores_tesis.id) t2 ON t1.id_director = t2.id_dir;";

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
            /*
            $consulta = 'SELECT alumnos.num_control,alumnos.id,'.
            ' users.nombre,users.id,users.primer_apellido,users.segundo_apellido,users.email,'.
            ' users.fecha_actualizacion as fecha_usuario,instituciones.nombre AS institucion_nombre,'.
            ' programas.nombre AS programa_nombre FROM alumnos,users,programas, instituciones'.
            ' WHERE alumnos.id=users.id AND alumnos.id_programa=programas.id AND users.id_institucion = instituciones.id AND users.deleted_at IS NOT NULL';
            */
            $finalConsulta="";
            if (auth('admin')->user()){
                $finalConsulta = ' users.id_institucion = instituciones.id';
                
            }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
                $finalConsulta = ' programas.id_institucion = instituciones.id AND users.id_institucion = ?';
                
            }
            $consulta = "SELECT * FROM (SELECT alumnos.id, alumnos.num_control,alumnos.id_director,
             users.nombre,users.primer_apellido,users.segundo_apellido,users.email,
             users.fecha_actualizacion as fecha_usuario,instituciones.nombre AS institucion_nombre,
             (SELECT id_semana FROM alumno_constancia WHERE id_semana = $id_selectSemana  AND id_alumno=alumnos.id ) AS id_sem_constancia, 
             programas.nombre AS programa_nombre FROM alumnos,users,programas, instituciones
             WHERE alumnos.id=users.id AND alumnos.id_programa=programas.id AND $finalConsulta AND users.deleted_at IS NOT NULL) t1
             INNER JOIN (SELECT users.id AS id_dir, users.nombre AS director_nombre, users.primer_apellido AS director_pa, users.segundo_apellido AS director_sa FROM users,directores_tesis WHERE users.id = directores_tesis.id) t2 ON t1.id_director = t2.id_dir;";

            $alumnos = new User();
            if (auth('admin')->user()){
                $alumnos = DB::select(DB::raw($consulta));
                
            }else if(auth()->user() && auth()->user()->hasRoles(['coordinador'])){
                //$consultaF = $consulta.' AND users.id_institucion = ?';
                
                $alumnos = DB::select($consulta,[auth()->user()->id_institucion]);
                
            }
            $usuarios = User::onlyTrashed()->select('users.id','users.id_institucion','users.nombre','primer_apellido','segundo_apellido','email','users.fecha_actualizacion')->with('alumnos:alumnos.id,alumnos.id_programa,num_control,semestre,constancia_generada,fecha_constancia,gafete_generado,fecha_gafete','instituciones:instituciones.id,instituciones.nombre','programas:programas.id,programas.id_programa,programas.nombre')->whereHas('roles', function($q){$q->where('nombre', '=', 'alumno');});
            return datatables()->of($alumnos)
            ->addColumn('director', function($alumnos){
                return $alumnos->director_nombre .' '. $alumnos->director_pa .' '. $alumnos->director_sa;
            }
            
            )
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
        if(!auth()->user() && !auth('admin')->user()){
            return abort(403);
        }
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
        if(file_exists( public_path(). '/img/logo/conacyt.png') || file_exists( public_path(). '/img/logo/conacyt.jpg')){
            $conacyt =  asset('img/logo/conacyt.png');    
            $imagenes .= '<img style="vertical-align: top;width:100px;height:70px;"src = "'.$conacyt.'">';
        }
        
        
        $pdf = App::make('dompdf.wrapper');
        //$pdf->setPaper('A6','portrait');
        $pdf->setPaper('letter','portrait');
        //$pdf->loadHTML('<h1>Test</h1>');
        $pdf->loadView('alumno.generarGafete',['alumno' => $alumno, 'imagenes' => $imagenes, 'semana' => $semana]);
        
        $output = $pdf->output();
        File::put(public_path().'/gafete.pdf',$output);

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
        
        
        return view('alumno.mostrarGafete', compact(['semana','instituciones','pdf']));
        //return view('alumno.generarGafete',compact(['alumno','imagenes','semana']));   
    }
    public function ExportarAlumnos(){
        if(auth()->user()){
            $institucion = Institucion::select('nombre')->where('id',auth()->user()->id_institucion)->first();
            $semana = DB::select(DB::raw("SELECT semanas.id_semana	
		    FROM semanas
            WHERE vigente = 1"));
            $id_selectSemana = $semana[0]->id_semana;

            $id_institucion = auth()->user()->id_institucion;
            $consulta = "SELECT num_control,nombre, primer_apellido,segundo_apellido,semestre
                            FROM users u , alumnos a
                            WHERE a.id = u.id AND u.id_institucion = $id_institucion
                            ORDER BY semestre ASC, num_control ASC";
            $alumnos = DB::select($consulta);


            $pdf = App::make('dompdf.wrapper');
            $pdf->setPaper('letter','landscape');
            //$pdf->loadHTML('<h1>Test</h1>');
            $semana = Semana::All()->last();
            $fInicio = new Date($semana->fecha_inicio);
            $fFin = new Date($semana->fecha_fin);
            $fInicio = $fInicio->format('l d').' de '.$fInicio->format('F');
            $fFin = $fFin->format('l d').' de '.$fFin->format('F').' del '.$fFin->format('Y');
            
            $pdf->loadView('listaAlumnos',['alumnos' => $alumnos, 'semana' => $semana ,'fInicio' => $fInicio, 'fFin' => $fFin, 'institucion' => $institucion]);
            //return $pdf->download('invoice.pdf');
            return $pdf->stream();
        }
        
        //$output = $pdf->output();
        //File::put(public_path().'\documentos\modalidad\\'.$modalidad->nombre .'.pdf',$output);
        //return \Response::json("Listo");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\excelrequest\ExcelUploadRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function importarAlumnos(ExcelRequest $request) 
    {
        /*
        $errores=[];
        
            //funcionando
            $array =Excel::toArray(new UsersImport, request()->file('archivo'));
            $arrayaux = []; 
            $arrayaux = Arr::add($arrayaux, 'usuario',$array[0]);
            
            $rulesArreglo = [
                'usuario' => 'required|array|min:1|max:40',
            ];

            $rules = [
                'usuario.*.email' => 'unique:users,email|required|email|distinct|max:60',
                'usuario.*.nombre' => 'required|string|max:40',
                'usuario.*.password' => 'required|string|min:5|max:60|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$^&-]).{6,}$/',
                'usuario.*.primer_apellido' => 'required|string|max:30',
                'usuario.*.segundo_apellido' => 'string|nullable|max:30',
                'usuario.*.id_institucion'    => 'required|exists:instituciones,id',
                
                'usuario.*.num_control'  => 'required|max:15',
                'usuario.*.semestre'  => 'required|max:30',
                'usuario.*.id_programa'  => 'required',function($attribute, $value, $fail){
                    if($value==='MCMRC'){
                        $fail($attribute.' is invalid');
                    }
                },
                'usuario.*.id_programa'  => 'required|exists:programas,id_programa',
                //'usuario.*.id_programa'  => 'required',Rule::exists('programas')->where(function($query){$query->where('id_programa','MCMRC');}),
                'usuario.*.email_director'  => 'required|exists:users,email',                
            ];

            
            
            $attributesArreglo = [
                'usuario' => 'archivo de alumonos',
            ]; 
            
            $attributes = [];
            
            $re =[];
            $arrayFinal = [];
            $arrayFinal = Arr::add($arrayFinal,'usuario',[]);
            
            foreach($arrayaux['usuario'] as $key => $row)
            {
                $arrayAux2 = array_filter($row);
                if(!empty($arrayAux2)){
                    $arrayFinal['usuario'] = Arr::add($arrayFinal['usuario'], $key,$arrayAux2);
                }
            }

            $validatorArreglo = Validator::make($arrayFinal, $rulesArreglo,[],$attributesArreglo);
            if(!$validatorArreglo->fails()){
                $contador = 1;
                foreach($arrayaux['usuario'] as $key => $row)
                {
                    $contador = 1;
                    $contador = $contador+$key+1;
                    $attributes['usuario.'.$key.'.email'] = 'email en renglón '.($contador);
                    $attributes['usuario.'.$key.'.password'] = 'password en renglón '.($contador);
                    $attributes['usuario.'.$key.'.nombre'] = 'nombre en renglón '.($contador);
                    $attributes['usuario.'.$key.'.primer_apellido'] = 'primer apellido en renglón '.($contador);
                    $attributes['usuario.'.$key.'.segundo_apellido'] = 'segundo apellido en renglón '.($contador);
                    $attributes['usuario.'.$key.'.id_institucion'] = 'institución en renglón '.($contador);
    
                    $attributes['usuario.'.$key.'.num_control'] = 'número de control en renglón '.($contador);
                    $attributes['usuario.'.$key.'.semestre'] = 'semestre en renglón '.($contador);
                    $attributes['usuario.'.$key.'.programa_de_estudio'] = 'programa de estudios en renglón '.($contador);
                    $attributes['usuario.'.$key.'.email_director'] = 'director de tesis en renglón '.($contador);
                    
                }
                
                $validator = Validator::make( $arrayFinal, $rules,[],$attributes );
                
                $errores = [];
                foreach ($validator->messages()->getMessages() as $key => $message) {
                    $errores[$key] = $message[0];
                }
                ksort($errores, SORT_NATURAL);
                if(!$validator->fails()) {
                    return back()->with('bien', 'Alumnos registrados exitosamente');
                }
                else{
                    return back()->with('errores',$errores);
                }
            }else{
                return back()->with('errores',$validatorArreglo->messages()->all());
            }
            
        

*/

        
        $errores=[];
        DB::beginTransaction();
        try {
            //funcionando
            $array =Excel::toArray(new UsersImport, request()->file('archivo'));
            $array = $array[0];
            $rules = [
                'email' => 'unique:users,email|required|email|distinct|max:60',
                'nombre' => 'required|string|max:40',
                //'contrasena' => 'required|string|min:5|max:60|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$^&-]).{6,}$/',
                'contrasena' => 'required',
                'primer_apellido' => 'required|string|max:30',
                'segundo_apellido' => 'string|nullable|max:30',
                //'id_institucion'    => 'required|exists:instituciones,id',
                'num_control'  => 'required|unique:alumnos,num_control|max:15',
                'semestre' => [
                    'required',
                    'numeric',
                    
                    function($attribute, $value, $fail){
                        
                        if ($value < 1 || $value >10 ) {
                            $fail('Semestre no válido.');
                        }
                    },
                ],
                /*'id_programa'  => 'required',function($attribute, $value, $fail){
                    if($value==='MCMRC'){
                        $fail($attribute.' is invalid');
                    }
                },*/
                'id_programa'  => 'required|exists:programas,id_programa',
                //'usuario.*.id_programa'  => 'required',Rule::exists('programas')->where(function($query){$query->where('id_programa','MCMRC');}),
                //'email_director'  => 'required|exists:users,email',
                /*'email_director'  => 'required|exists:users,email|',function($attribute, $value, $fail){
                    
                    $rol_director = DB::select('SELECT id_rol FROM rol_usuario, users WHERE email = ? AND users.id = rol_usuario.id_usuario;', [$value]);
                    if ($value === 'c@gmail.com') {
                        $fail($attribute.' is invalid.');
                    }
                },*/
                'email_director' => [
                    'required',
                    'exists:users,email',
                    function($attribute, $value, $fail){
                        $rol_director = DB::select('SELECT id_rol FROM rol_usuario, users WHERE email = ? AND users.id = rol_usuario.id_usuario;', [$value]);
                        $encontrado = false;
                        foreach ($rol_director as $key => $value) {
                            if($value->id_rol === 4){
                                $encontrado = true;
                                break;
                            }
                        }
                        if (!$encontrado) {
                            $fail('Director de tesis no se encuentra registrado.');
                        }
                    },
                ]  
            ];
            $messages = [
                'email.unique' => 'Email ya se encuentra registrado o aparece más de una vez en su archivo.',
                'num_control.unique' => 'Número de control ya se encuentra registrado o aparece más de una vez en su archivo.',
            ];

            $rulesArreglo = [
                'usuarios' => 'required|array|min:1|max:40',
            ];
            $arrayaux = []; 
            $arrayaux = Arr::add($arrayaux, 'usuarios',$array);
            
            $validatorArreglo = Validator::make($arrayaux, $rulesArreglo);
            
            $re =[];
            if(count($validatorArreglo->messages()->all())==0){
                foreach($array as $key => $row)
                {
                    $arrayAux = array_filter($row);
                    if(!empty($arrayAux)){
                        $validator = Validator::make( $row, $rules, $messages );
                        if ($validator->fails()) {                        
                            $re[] = [['Renglon: '.((int)$key+2)],$validator->messages()->all()];
                        }
                        else{
                            $user = new User([
                                'nombre'     => $row['nombre'],
                                'email'     => $row['email'],
                                'password' => bcrypt($row['contrasena']),
                                'primer_apellido'   => $row['primer_apellido'], 
                                'segundo_apellido'  => $row['segundo_apellido'], 
                                'id_institucion'    => 3,
                                //'id_semana' => $row['id_semana'],
                            ]);
                            $user->save();
                            
                            $alumno = new Alumno([
                                //'id_usuario'=>User::select('id')->where('email','=',$user->email)->get()[0]->id,
                                'id'=>$user->id,
                                'id_programa'=>Programa::select('id')->where('id_programa','=',$row['id_programa'])->get()[0]->id,
                                'id_director'=>User::select('id')->where('email','=',$row['email_director'])->get()[0]->id,
                                'semestre'=>$row['semestre'],
                                'num_control'=>$row['num_control'],
                            ]);
                            
                            $alumno->save();
                            
                            $user->roles()->attach([$user->id => ['id_rol'=>'5']]);
                        }
                    }
                }
                if(empty($re)) {
                    DB::commit();
                    $cadena = [];
                    $cadena [] = 'Alumnos registrados exitosamente';
                    return \Response::json([
                        'bien' => $cadena,
                    ], 200);
                    return back()->with('bien', 'Alumnos registrados exitosamente');
                }
                else{
                    DB::rollback();
                    $cadena = [];
                    foreach ($re as $key => $value) {
                        //dd($value[0][0]);
                        $cadena []= "<strong>".$value[0][0]."</strong><ul>";
                        
                        
                        foreach ($value[1] as $key => $valor) {
                            $cadena [] = "<li>" . $valor ."</li>";
                        }
                        $cadena[] = "</ul>";
                        
                    }
                    
                    return \Response::json([
                        'errors' => $cadena,
                    ], 422);
                    return back()->with('errores',$cadena);
                }
            }else{
                $errorArreglo = $validatorArreglo->messages()->all();
                $cadena = [];
                
                foreach ($errorArreglo as $key => $value) {
                    //dd($value[0][0]);
                
                    $cadena[]= 
                        "<ul><li>".
                            $value.
                        "</li></ul>";
                    
                }
                dd("oas");
                return \Response::json([
                    'errors' => $cadena,
                ], 422);
                return back()->with('errores',$cadena);
            }
            
        } 
        catch (Exception $e) {
            dd("oqmweoqw");
            DB::rollback();
            return \Response::json([
                'errors' => $e->errors(),
            ], 404);
            return back()->withErrors($e->errors());
        }

        
    }

    public function exportarXLSAlumnos(){
        return Excel::download(new AlumnosExportar, 'Alumnos Participantes.xlsx');
    }
}
