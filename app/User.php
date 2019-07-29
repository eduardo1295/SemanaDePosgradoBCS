<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\DataBase\Eloquent\SoftDeletes;
use App\Notifications\ResetPassword;

class User extends Authenticatable implements MustVerifyEmail
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
        'email', 'nombre', 'primer_apellido', 
        'segundo_apellido', 'password', 'id_institucion', 
        'id_semana', 'creado_por', 'actualizado_por', 'primerContrasena',
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'primerContrasena'];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_usuario', 'id_usuario', 'id_rol')
            ->withTimestamps();
    }

    public function coordinadores()
    {
        return $this->hasOne(Coordinador::class, 'id', 'id');
    }

    public function directortesis()
    {
        return $this->hasOne(DirectorTesis::class, 'id', 'id');
    }

    public function alumnos()
    {
        return $this->hasOne(Alumno::class, 'id', 'id');
    }

    public function instituciones()
    {
        return $this->hasOne(Institucion::class, 'id', 'id_institucion')->withDefault(['nombre' => '']);
    }

    public function noticias()
    {
        return $this->hasMany(Noticia::class, 'creada_por', 'id');
    }


    public function trabajos()
    {
        return $this->hasOne(Trabajo::class, 'id_alumno', 'id');
    }

    public function hasRoles(array $roles)
    {

        foreach ($roles as $rol) {
            foreach ($this->roles as $rolUsuario) {
                if ($rolUsuario->nombre === $rol) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function programas()
    {
        return $this->hasManyThrough(Programa::class, Alumno::class, 'id', 'id', 'id', 'id_programa');
    }
}
