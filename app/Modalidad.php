<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\DataBase\Eloquent\SoftDeletes;

class Modalidad extends Model
{
    use SoftDeletes;
    
    protected $table = 'modalidades';
    protected $primaryKey = 'id_modalidad';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion', 'creado_por', 'actualizado_por',
    ];

    protected $dates = ['deleted_at'];

    public function locaciones()
    {
        return $this->belongsToMany(Locacion::class, 'locacion_modalidad', 'id_modalidad', 'id_locacion')
                    ->withPivot('creado_por', 'actualizado_por')
                    ->withTimestamps();
    }
}