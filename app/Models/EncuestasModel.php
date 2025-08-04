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
        'id_encuesta',
        'created_at',
        'updated_at',
    ];
    
}
