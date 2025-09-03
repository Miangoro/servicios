<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class expedientePersonalModel extends Model
{
    public $timestamps = false;
    protected $table = 'expediente_personal';
    protected $primaryKey = 'id_expediente';
    protected $fillable = [
        'id_expediente',
        'id_empleado',
        'd_personales',
        'profesion',
        'experiencia',
        'cursos',
        'actividades',
        'habilidades',
        'habilitado',
        'fecha_registro',
        'id_usuario'
    ];

    
}
