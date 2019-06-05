<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VistaLogin extends Model
{
    protected $table = 'vistaLogin';

    protected $fillable = [
        'id', 'url_imagen'
    ];
}
