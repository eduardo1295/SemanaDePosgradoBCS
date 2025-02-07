<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\DataBase\Eloquent\SoftDeletes;

class Carrusel extends Model
{
    use SoftDeletes;

    protected $table = 'carrusel';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creado_por', 'titulo', 'contenido', 'url_imagen', 'actualizado_por',
    ];

    protected $dates = ['deleted_at'];
}
