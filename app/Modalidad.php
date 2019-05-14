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
        'nombre', 'descripcion', 'creada_por', 'actualizado_por',
    ];

    protected $dates = ['deleted_at'];

    
    public function niveles()
    {
        return $this->belongsToMany(Nivel::class, 'modalidad_nivel', 'id_modalidad', 'id')
                    ->withPivot('creada_por', 'actualizado_por')
                    ->withTimestamps();
    }
    
}