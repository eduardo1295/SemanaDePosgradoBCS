<?php

namespace App\Exports;

use App\Alumno;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlumnosExportar implements FromCollection, WithMapping, WithHeadings, WithTitle, ShouldAutoSize, ShouldQueue
{
    /**
    * @return Builder
    */
    public function collection()
    {
        $consulta = "SELECT * FROM (SELECT alumnos.semestre, alumnos.num_control,alumnos.id_director,
             users.nombre,users.primer_apellido,users.segundo_apellido,users.email,
             programas.nombre AS programa_nombre FROM alumnos,users,programas, instituciones
             WHERE alumnos.id=users.id AND alumnos.id_programa=programas.id AND programas.id_institucion = instituciones.id AND users.id_institucion = ? AND users.deleted_at IS NULL) t1
             INNER JOIN (SELECT users.id AS id_dir, CONCAT(users.nombre, ' ', users.primer_apellido, ' ', users.segundo_apellido) AS nombre_director FROM users,directores_tesis WHERE users.id = directores_tesis.id) t2 ON t1.id_director = t2.id_dir ORDER BY t1.num_control ASC, t1.semestre ASC;";
        $alumnos = DB::select($consulta,[auth()->user()->id_institucion]);
        
        
        //return Alumno::all();
        return collect($alumnos);
    }

     /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->num_control,
            $row->semestre,
            $row->nombre,
            $row->primer_apellido,
            $row->segundo_apellido,
            
            $row->email,
            $row->programa_nombre,
            $row->nombre_director
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Número de control',
            'Periodo',
            'Nombre',
            'Primer apellido',
            'Segundo apellido',
            
            'Email',
            'Programa de estudios',
            'Director de tesis'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Alumnos participantes';
    }
}
