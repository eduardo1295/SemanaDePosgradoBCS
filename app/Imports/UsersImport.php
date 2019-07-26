<?php

namespace App\Imports;

use App\User;
use App\Alumno;
use App\Programa;
use App\Rol;
use DB;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithBatchInserts;


class UsersImport implements ToModel,WithHeadingRow,WithValidation,SkipsOnError,WithBatchInserts
{
    use Importable,SkipsErrors;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
/*
        if (!isset($row['email'])) {
            return null;
        }
*/
        $user = new User([
                'nombre'     => $row['nombre'],
                'email'     => $row['email'],
                'password' => bcrypt($row['password']),
                'primer_apellido'   => $row['primer_apellido'], 
                'segundo_apellido'  => $row['segundo_apellido'], 
                'id_institucion'    => $row['id_institucion'],
                'id_semana' => $row['id_semana'],
        ]);
        /*  $alumno = new Alumno([
            'id_usuario'=>1,
            'id_programa'=>1,
            'semestre'=>1,
            'num_control'=>$row['num_control'],
        
        ]);
        */
        $user->save();
        
        //$alumno->save();
        
        $r = new Rol([
            'id_rol'     => 2,
        ]);
        
        $user->roles()->attach(2);
        return new Alumno([
            'id_usuario'=>User::select('id')->where('email','=',$row['email'])->get()[0]->id,
            //'id_programa'=>Progrma::select('id')->where('id_programa','=',$row['programa'])->get()[0]->id,
            'id_programa'=>1,
            'semestre'=>$row['semestre'],
            'num_control'=>$row['num_control'],
        ]); 
        
    }
    
    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            //Validacion campos usuario
            'email' => 'unique:users|required|email|max:60',
            '*.email' => 'unique:users|required|email|max:60',

            'nombre' => 'required|string|max:40',
            '*.nombre' => 'required|string|max:40',
            
            'password' => 'required|string|max:60',
            '*.password' => 'required|string|max:60',
            
            'primer_apellido'   => 'required|string|max:30',
            '*.primer_apellido' => 'required|string|max:30',
            
            'segundo_apellido'  => 'required|string|max:30',
            '*.segundo_apellido' => 'required|string|max:30',

            //Validacion campos extra para alumno
            'num_control'  => 'unique:alumnos|required|max:15',
            '*.num_control' => 'unique:alumnos|required|max:15',

            'semestre'  => 'required|numeric|digits_between:1,10',
            '*.semestre' => 'required|numeric|digits_between:1,10',

            'programa'  => 'required|exists:programas,id_programa|max:15',
            '*.programa' => 'required|exists:programas,id_programa|max:15',

            //determinar como se hace la conexión con asesor de tesis
            /*
            'email' => [
                'required',
                Rule::exists('staff')->where(function ($query) {
                    $query->where('account_id', 1);
                }),
            ],
            */
        ];
    }


    public function batchSize(): int
    {
        return 1000;
    }
}
