<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';
    
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario', 'id_programa', 'num_control', 'semestre', 'constancia_generada', 'fecha_constancia', 'gafete_generado', 'fecha_gafete',
    ];

    protected $dates = [
        'fecha_constancia',
        'fecha_gafete',
    ];

    public function trabajos()
    {
        return $this->hasMany(Trabajo::class, 'id_usuario', 'id_usuario');
    }
    
}