<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\DataBase\Eloquent\SoftDeletes;

class Nivel extends Model
{
    use SoftDeletes;
    
    protected $table = 'niveles';
    protected $primaryKey = 'id';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grado', 'semestre','trimestre','cuatrimestre','creado_por', 'actualizado_por',
    ];

    protected $dates = ['deleted_at'];

    public function modalidades()
    {
        return $this->belongsToMany(Modalidad::class, 'modalidad_nivel','id','id_modalidad')
                    ->withPivot('creada_por', 'actualizado_por')
                    ->withTimestamps();
    }
}

