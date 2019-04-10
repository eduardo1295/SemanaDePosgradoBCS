<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locacion extends Model
{
    protected $table = 'locaciones';
    protected $primaryKey = 'id_locacion';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creado_por', 'nombre', 'actualizado_por',
    ];

    public function modalidades()
    {
        return $this->belongsToMany(Modalidad::class, 'locacion_modalidad', 'id_locacion', 'id_modalidad')
                    ->withPivot('creado_por', 'actualizado_por')
                    ->withTimestamps();
    }


    public function horarios()
    {
        return $this->belongsToMany(Horario::class, 'horarios', 'id_locacion', 'id_trabajo')
                    ->withPivot('creada_por', 'actualizado_por', 'dia', 'hora')
                    ->withTimestamps();
    }
}