<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresas_clientes extends Model
{
    use HasFactory;

    public $timestamps = false; // Indica que este modelo no usa las columnas created_at y updated_at
    protected $table = 'empresas_clientes'; // Define el nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Define la clave primaria de la tabla

    // Campos que pueden ser asignados masivamente (mass assignable)
    protected $fillable = [
        'id',
        'nombre',
        'rfc',
        'credito',
        'regimen',
        'calle',
        'colonia',
        'estado',
        'localidad',
        'municipio',
        'constancia',
        'noext',
        'codigo_postal',
        'correo',
        'telefono',
        'tipo'
        // 'contactos_data' ya no es necesario aquí, se manejará en la tabla clientes_contacto
    ];

    // Define la relación uno a muchos con el modelo clientes_contacto
    public function clientesContactos()
    {
        return $this->hasMany(clientes_contacto::class, 'cliente_id', 'id');
    }
}
