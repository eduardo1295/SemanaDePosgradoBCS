<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use SoftDeletes;

    protected $table = 'noticias';
    protected $primaryKey = 'id_noticia';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creada_por', 'titulo', 'contenido','resumen', 'url_imagen', 'actualizado_por',
    ];

    protected $dates = ['deleted_at'];
}