<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestasAbiertas extends Model
{
    public $timestamps = false;
    protected $table = 'respuestas_cerrada';
    protected $primaryKey = 'id_respuesta';
    protected $fillable = [
        'id_respuesta',
        'id_opcion',
        'id_evaluado',
        'id_usuario',
        'created_at'
    ];

        public function opciones()
    {
        return $this->hasMany(OpcionesModel::class, 'id_opcion', 'id_opcion');
    }
}
