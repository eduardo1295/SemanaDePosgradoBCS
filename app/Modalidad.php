<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    
    public function niveles()
    {
        return $this->hasMany(Posgrado::class,'id_modalidad', 'id_modalidad');
    }
    
}