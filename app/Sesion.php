<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sesion extends Model
{
    use SoftDeletes;
    protected $table = 'sesiones';
    protected $primaryKey = 'id_sesion';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_modalidad','nombre','dia','hora_inicio','hora_fin','cantidad','lugar',
    ];
    protected $dates = ['deleted_at'];

}
