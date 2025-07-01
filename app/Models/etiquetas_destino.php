<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class etiquetas_destino extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'etiquetas_destino';
    protected $fillable = [
        'id_etiqueta',
        'id_direccion',
    ];

}
