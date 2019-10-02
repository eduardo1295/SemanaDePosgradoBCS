<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Semana extends Model
{
    protected $table = 'semanas';
    protected $primaryKey = 'id_semana';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'url_logo','id_sede','desc_general','url_convocatoria', 'fecha_inicio', 'fecha_fin', 'creado_por', 'actualizado_por', 'vigente',
    ];

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_semana', 'id_semana');
    }

    public function instituciones()
    {
        return $this->hasMany(Institucion::class, 'id', 'id_sede');
    }

    public function contarSemanas(){
        $contarSemanas = DB::select('SELECT COUNT(id_semana) AS contar FROM semanas WHERE vigente=1');
        return $contarSemanas[0];
    }
}