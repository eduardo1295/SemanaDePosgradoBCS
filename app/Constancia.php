<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Constancia extends Model
{
    protected $table = 'constancias';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cComponentes','cCSS','cHTML', 'id_semana', 'url_imagen_fondo',
    ];
}