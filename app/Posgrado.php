<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posgrado extends Model
{
    protected $table = 'modalidad_posgrado';
    protected $primaryKey = 'id';
    
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','id_modalidad','grado',
    ];

    public function periodos()
    {
        return $this->hasMany(Periodo::class,'id_posgrado', 'id');
    }
}
