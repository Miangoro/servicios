<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntasModel extends Model
{
    public $timestamps = false;
    protected $table = 'preguntas';
    protected $primaryKey = 'id_pregunta';
    protected $fillable = [
        'id_pregunta',
        'id_encuesta',
        'pregunta',
        'tipo_pregunta',
    ];

    public function opciones()
    {
        return $this->hasMany(OpcionesModel::class, 'id_pregunta', 'id_pregunta');
    }

        public function encuesta()
    {
        return $this->belongsTo(EncuestasModel::class);
    }
}
