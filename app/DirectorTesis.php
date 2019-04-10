<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectorTesis extends Model
{
    protected $table = 'directores_tesis';
    
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario', 'grado',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function trabajos()
    {
        return $this->hasMany(Trabajo::class, 'id_director', 'id_usuario');
    }
}