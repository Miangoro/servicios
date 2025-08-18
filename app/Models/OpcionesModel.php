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

    // Nueva relación: una opción pertenece a una pregunta
    public function pregunta()
    {
        return $this->belongsTo(PreguntasModel::class, 'id_pregunta', 'id_pregunta');
    }
}