<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresas_clientes extends Model
{
    use HasFactory;

    // Define la clave primaria y el nombre de la tabla
    protected $primaryKey = 'id';
    protected $table = 'empresas_clientes';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'rfc',
        'regimen',
        'credito',
        'estado',
        'municipio',
        'localidad',
        'calle',
        'noext',
        'colonia',
        'codigo_postal',
        'telefono',
        'correo',
        'constancia',
        'tipo',
        'estatus'
    ];

    /**
     * Define la relación inversa: un cliente pertenece a un régimen.
     * La clave foránea en esta tabla es 'regimen'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function catalogoRegimen()
    {
        return $this->belongsTo(catalogos_regimenes::class, 'regimen');
    }

    /**
     * Define la relación uno a muchos: un cliente puede tener varios contactos.
     * La clave foránea en la tabla 'clientes_contactos' es 'cliente_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientesContactos()
    {
        return $this->hasMany(clientes_contacto::class, 'cliente_id');
    }
}
