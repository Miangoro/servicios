<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class preguntas_revision extends Model
{
    use HasFactory;
    protected $table = 'revision_preguntas';
    protected $primaryKey = 'id_pregunta'; 

    public function documentacion()
    {
        return $this->belongsTo(Documentacion::class, 'id_documento', 'id_documento');
    }
}
