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
        'd_bancarios',
        'n_banco',
        'clave',
        'tipo',
        'url_adjunto',
        'fecha_registro',
        'habilitado',
        'id_usuario'
    ];

    public function contactos()
    {
        return $this->hasMany(ProveedoresContactos::class, 'id_proveedor', 'id_proveedor');
    }

    public function evaluaciones()
    {
        return $this->hasMany(EvaluacionProveedor::class, 'proveedor', 'id_proveedor');
    }
}