<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\DataBase\Eloquent\SoftDeletes;

class Institucion extends Model
{
    use SoftDeletes;
    
    protected $table = 'instituciones';
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_institucion', 'nombre', 'telefono', 'ciudad', 'calle', 'numero', 'colonia', 'cp', 'direccion_web', 'latitud','longitud', 'url_logo', 'req_horas_minimas', 'horas_minimas', 'sede', 'creado_por', 'actualizado_por',
    ];

    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->hasMany(User::class, 'id_institucion', 'id');
    }

    public function programas()
    {
        return $this->hasMany(Programa::class, 'id_institucion', 'id');
    }

    public function locaciones()
    {
        return $this->hasMany(Locacion::class, 'id_institucion', 'id_locacion');
    }
}