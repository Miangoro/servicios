<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProveedoresContactos extends Model
{
    public $timestamps = false;
    protected $table = 'catalogo_proveedores_contactos';
    protected $primaryKey = 'id_contacto';
    protected $fillable = [
        'id_contacto',
        'id_proveedor',
        'contacto',
        'telefono',
        'correo',
        'cargo',
        'fecha_registro',
        'habilitado',
        'id_usuario'
    ];

    /**
     * Get the provider that owns the contact.
     */
    public function proveedor()
    {
        return $this->belongsTo(CatalogoProveedor::class, 'id_proveedor', 'id_proveedor');
    }
}