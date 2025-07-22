<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoProveedor extends Model
{
    public $timestamps = false;
    protected $table = 'catalogo_proveedores';
    protected $primaryKey = 'id_proveedor';
    protected $fillable = [
        'id_proveedor',
        'razon_social',
        'direccion',
        'rfc',
        'd_bancarios', // Este campo parece no usarse directamente si n_banco y clave son los relevantes
        'n_banco',
        'clave',
        'tipo',
        'url_adjunto',
        'fecha_registro',
        'habilitado',
        'id_usuario'
    ];

    /**
     * Get the contacts for the provider.
     */
    public function contactos()
    {
        return $this->hasMany(ProveedoresContactos::class, 'id_proveedor', 'id_proveedor');
    }

    /**
     * Get the evaluations for the provider.
     */
    public function evaluaciones()
    {
        // Asumiendo que 'proveedor' en 'evaluacion_proveedor' es el id del proveedor.
        // Si 'proveedor' almacena el nombre o la razón social, necesitarías ajustarlo o normalizarlo.
        // Para una relación directa con id_proveedor, esto es lo más común.
        return $this->hasMany(EvaluacionProveedor::class, 'proveedor', 'id_proveedor');
    }
}