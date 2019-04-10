<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\DataBase\Eloquent\SoftDeletes;

class Programa extends Model
{
    use SoftDeletes;

    protected $table = 'programas';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_programa', 'nombre', 'nivel', 'periodo', 'creado_por', 'actualizado_por',
    ];

    protected $dates = ['deleted_at'];

    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'id_programa', 'id');
    }
}