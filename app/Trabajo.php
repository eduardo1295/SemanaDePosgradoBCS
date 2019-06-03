<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    protected $table = 'trabajos';
    protected $primaryKey = 'id_trabajo';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'id_usuario', 'id_director', 'id_semana', 'titulo', 'resumen', 'area', 'pal_clv1', 'pal_clv2', 'pal_clv3', 'pal_clv4', 'pal_clv5', 'fecha_entrega', 'autorizado', 'fecha_autorizacion', 'url',
    ];

    protected $dates = [
        'fecha_entrega',
        'fecha_autorizacion',
    ];

    public function horarios()
    {
        return $this->belongsTo(Horario::class, 'horarios', 'id_trabajo', 'id_locacion')
                    ->withPivot('creada_por', 'actualizado_por', 'dia', 'hora')
                    ->withTimestamps();
    }

    public function alumnos(){
        return $this->belongsTo(Alumno::class,'id_usuario');
    }
}