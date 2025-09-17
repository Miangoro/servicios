<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class puestosModel extends Model
{
    public $timestamps = false;
    protected $table = 'catalogo_puestos';
    protected $primaryKey = 'id_puesto';
    protected $fillable = [
        'id_puesto',
        'id_laboratorio',
        'perfil_puesto',
        'requisitos',
        'conocimiento',
        'signatario',
        'experiencia',
        'actividades',
        'responsabilidades',
        'autorizaciones',
        'habilidades',
        'nombre',
        'fecha_registro',
        'id_usuario',
        'habilitado'
    ];

    
}
