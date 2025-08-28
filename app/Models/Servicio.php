<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servicio extends Model
{
    protected $table = 'servicios_servicios';
    protected $primaryKey = 'id_servicio';

    // Si no tienes las columnas created_at y updated_at, usa esta línea
    public $timestamps = false;

    protected $fillable = [
        'id_servicio',
        'precio',
        'habilitado',
        'nombre',
        'id_usuario',
        'fecha_registro',
        'duracion',
        'especificaciones',
        'clave',
        'tipo_duracion',
        'id_habilitado',
        'tipo_servicio',
        'url_requisitos',
        'resumen',
        'tags',
        'metodo',
        'tipo_muestra',
        'prueba',
        'analisis',
        'unidades',
        'id_acreditacion',
        'id_categoria',
        'cant_muestra',
        'requisitos' // Agrega esta columna si existe en la BD
    ];

    /**
     * Define la relación con los laboratorios.
     */
    public function laboratorios(): BelongsToMany
    {
        // CORRECCIÓN: Cambia 'servicios_laboratorios' por 'servicios_lab_servicio'
        return $this->belongsToMany(CatalogoLaboratorio::class, 'servicios_lab_servicio', 'id_servicio', 'id_laboratorio')
                    ->withPivot('precio');
    }
}