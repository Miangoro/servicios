<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestasModel extends Model
{
    public $timestamps = false;
    protected $table = 'encuestas';
    protected $primaryKey = 'id_encuesta';
    protected $fillable = [
        'id_encuesta',
        'encuesta',
        'tipo',
        'id_usuario',
        'created_at',
        'updated_at',
    ];
    
    public function preguntas()
    {
        return $this->hasMany(PreguntasModel::class, 'id_encuesta', 'id_encuesta');
    }
}
