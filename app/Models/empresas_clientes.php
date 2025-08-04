<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresas_clientes extends Model
{
    use HasFactory;

    protected $table = 'empresas_clientes'; // Asegúrate de que el nombre de tu tabla sea correcto

    protected $fillable = [
        'nombre',
        'rfc',
        'regimen', // O 'regimen_id' si es una FK
        'credito', // O 'tiene_credito', 'estado_credito', etc.
        'estado',
        'municipio',
        'localidad',
        'calle',
        'noext', // O 'no_exterior'
        'colonia',
        'codigo_postal',
        'telefono',
        'correo',
        'constancia',
        'tipo',
        'estatus', // Asegúrate de que esta columna exista para dar de baja/alta
        // ... otras columnas ...
    ];

    // Define la relación con el modelo catalogos_regimenes
    // Asumo que 'regimen' en empresas_clientes es la FK a 'id' en catalogos_regimenes
    public function catalogoRegimen()
    {
        return $this->belongsTo(catalogos_regimenes::class, 'regimen'); // 'regimen' es la FK en empresas_clientes
                                                                        // Si tu FK se llama 'regimen_id', cambia 'regimen' a 'regimen_id'
    }

    // Si tienes una columna para el estado de pago (ej. 'estado_pago')
    // public function estadoPago()
    // {
    //     return $this->belongsTo(EstadoPago::class, 'estado_pago_id'); // Ejemplo si es una FK a otra tabla
    // }

    // Si tienes una columna para el estado de crédito (ej. 'credito')
    // public function estadoCredito()
    // {
    //     return $this->belongsTo(EstadoCredito::class, 'credito_id'); // Ejemplo si es una FK a otra tabla
    // }

    // Si tienes contactos asociados
    public function clientesContactos()
    {
        return $this->hasMany(clientes_contacto::class, 'cliente_id');
    }
}
