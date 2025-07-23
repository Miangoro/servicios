<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluacionProveedor extends Model
{
    public $timestamps = false;
    protected $table = 'evaluacion_proveedor';
    protected $primaryKey = 'id_evaluacion';
    protected $fillable = [
        'id_evaluacion',
        'id_compra',
        'material',
        'proveedor',
        'n_evaluacion',
        'fecha_recepcion',
        'fecha_evaluacion',
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
        'comentarios',
        'habilitado',
        'id_usuario'
    ];

    public function catalogoProveedor()
    {
        return $this->belongsTo(CatalogoProveedor::class, 'proveedor', 'id_proveedor');
    }
}