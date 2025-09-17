<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class personalConflictoInteresModel extends Model
{
    protected $table = 'personal_conflicto_interes';
    protected $primaryKey = 'id_evaluacion';
    public $timestamps = false;
    protected $fillable = [
        'fecha',
        'fecha_registro',
        'p_uno',
        'p_dos',
        'p_tres',
        'p_cuatro',
        'p_cinco',
        'p_seis',
        'p_siete',
        'p_ocho',
        'p_nueve',
        'p_diez',
        'p_once',
        'p_doce',
        'url_documento',
        'comentarios',
        'estatus',
        'habilitado',
        'id_usuario',
        'version',
        'area'
    ];
}
