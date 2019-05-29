<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\excelrequest\ExcelUploadRequest;
use App\Imports\UsersImport;
use App\Imports\usercollec;
use App\User;
use Excel;
use File;
use DB;
use DataTables;
use Validator, Input, Redirect; 
use App\Alumno;
use App\Programa;
use App\Rol;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(){
        $this->middleware(['auth']);
        

    }
    public function index()
    {
        
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
        //
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



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cargaExcel(){
        $data = User::select('nombre','email','password',"primer_apellido","segundo_apellido")->get();
        
        return view('excelim', compact('data'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\excelrequest\ExcelUploadRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function import(ExcelUploadRequest $request) 
    {
        $errores=[];
        DB::beginTransaction();
        try {
            //funcionando
            $array =Excel::toArray(new UsersImport, request()->file('archivo'));
            $array = $array[0];
            
            $rules = [
                'email' => 'email|unique:users',
                'nombre' => 'required',
                'primer_apellido' => 'required',
                'password' => 'required',
            ];
            
            $re =[];
            foreach($array as $key => $row)
            {
                $arrayAux = array_filter($row);
                if(!empty($arrayAux)){
                    $validator = Validator::make( $row, $rules );
                    if ($validator->fails()) {
                        $re[] = [['Renglon: '.((int)$key+2)],$validator->messages()->all()];
                    }
                    else{
                        $user = new User([
                            'nombre'     => $row['nombre'],
                            'email'     => $row['email'],
                            'password' => bcrypt($row['password']),
                            'primer_apellido'   => $row['primer_apellido'], 
                            'segundo_apellido'  => $row['segundo_apellido'], 
                            'id_institucion'    => $row['id_institucion'],
                            'id_semana' => $row['id_semana'],
                        ]);
                        $user->save();
                        
                        $alumno = new Alumno([
                            'id_usuario'=>User::select('id')->where('email','=',$user->email)->get()[0]->id,
                            'id_programa'=>Programa::select('id')->where('id_programa','=',$row['programa'])->get()[0]->id,
                            'semestre'=>$row['semestre'],
                            'num_control'=>$row['num_control'],
                        ]);
                        $alumno->save();
                        /*
                        $r = new Rol([
                            'id_rol'     => 2,
                            'creada_por' => 1,
                        ]);
                        */
                        $user->roles()->attach([$user->id => ['id_rol'=>'2', 'creada_por'=>'1']]);
                    }
                }
            }
            if(empty($re)) {
                DB::commit();
                return back()->with('bien', 'Alumnos registrados exitosamente');
            }
            else{
                DB::rollback();
                return back()->with('errores',$re);
            }
        } 
        catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->errors());
        }

    }

    
    function import2(Request $request)
    {
     $this->validate($request, [
      'select_file'  => 'required|mimes:xls,xlsx'
     ]);

     $path = $request->file('select_file')->getRealPath();

     $data = Excel::load($path)->get();

     if($data->count() > 0)
     {
      foreach($data->toArray() as $key => $value)
      {
       foreach($value as $row)
       {
        $insert_data[] = array(
            'nombre'     => $row['nombre'],
            'email'    => $row['email'], 
            'password' => Hash::make($row['password']),
            'primer_apellido'   => $row['primer_apellido'], 
            'segundo_apellido'  => $row['segundo_apellido'], 
            'id_institucion'    => $row['id_institucion'],
            'id_semana' => $row['id_semana']
        );
       }
      }

      if(!empty($insert_data))
      {
       DB::table('users')->insert($insert_data);
      }
     }
     return back()->with('success', 'Excel Data Imported successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function usuarios(){
        return view('admin.usuarios');
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listUsuarios(){
        $usuarios = User::all();
        return Datatables::of($usuarios)
        ->addColumn('action', function ($user) {
            return '<div class=" mx-auto" style="width:195px">
            <a href="#" class="btn btn-xs btn-primary" style="height:40px"><span><i class="fas fa-edit"></i>
            </span> Editar</a>
            <a href="#" class="btn btn-xs btn-danger" style="height:40px"><span><i class="fas fa-trash-alt"></i>
            </span> Eliminar</a>
            </div>';
        })
        ->editColumn('id', 'ID: {{$id}}')
        ->make(true);
        
    }
}
