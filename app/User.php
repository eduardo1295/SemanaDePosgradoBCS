<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\DataBase\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'nombre', 'primer_apellido', 'segundo_apellido', 'password', 'id_institucion', 'id_semana', 'creado_por', 'actualizado_por',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_usuario', 'id_usuario', 'id_rol')
                    ->withPivot('creada_por', 'actualizado_por')
                    ->withTimestamps();
    }

    public function coordinadores()
    {
        return $this->hasOne(Coordinador::class, 'id', 'id')->withDefault(['grado'=>'']);
    }

    public function directortesis()
    {
        return $this->hasOne(DirectorTesis::class, 'id', 'id')->withDefault(['grado'=>'']);
    }

    public function alumnos()
    {
        return $this->hasOne(Alumno::class, 'id', 'id');
    }

    public function instituciones()
    {
        return $this->hasOne(Institucion::class, 'id', 'id_institucion')->withDefault(['nombre'=>'']);
    }

    public function noticias()
    {
        return $this->hasMany(Noticia::class, 'creada_por', 'id');
    }

    /*
    public function trabajos()
    {
        return $this->hasManyThrough('App\Trabajo', 'App\Alumno', 'id','id');
    }
    */

    public function hasRoles(array $roles){

        foreach ($roles as $rol) {
            foreach ($this->roles as $rolUsuario) {
                if($rolUsuario->nombre === $rol){
                return true;
            }    
            }
            
        }

        return false;
    }
}