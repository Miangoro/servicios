<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestasAbiertas extends Model
{
    public $timestamps = false;
    protected $table = 'respuesta_abierta';
    protected $primaryKey = 'id_respuesta_abierta';
    protected $fillable = [
        'id_respuesta_abierta',
        'id_pregunta',
        'respuesta',
        'id_evaluado',
        'id_usuario',
        'created_at'
    ];

        public function opciones()
    {
        return $this->hasMany(OpcionesModel::class, 'id_opcion', 'id_opcion');
    }
}
