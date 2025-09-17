<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class personalNombramientoModel extends Model
{
    public $timestamps = false;
    protected $table = 'personal_nombramiento';
    protected $primaryKey = 'id_nombramiento';
    protected $fillable = [
        'id_nombramiento',
        'id_usuario',
        'puesto',
        'area',
        'responsable',
        'signatario',
        'suplente',
        'fecha_llenado',
        'fecha_efectivo',
        'id_registra',
        'id_v_nombramiento',
        'id_v_actividad',
        'estatus',
        'id_habilitado'
    ];
}
