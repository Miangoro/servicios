<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpcionesModel extends Model
{
    public $timestamps = false;
    protected $table = 'preguntas_opciones';
    protected $primaryKey = 'id_opcion';
    protected $fillable = [
        'id_opcion',
        'id_pregunta',
        'opcion',
    ];
}
