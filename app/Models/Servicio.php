<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servicio extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'servicios_servicios';

    // Clave primaria de la tabla
    protected $primaryKey = 'id_servicio';

    // Deshabilita las columnas de timestamps (created_at, updated_at)
    public $timestamps = false;

    // Atributos que se pueden asignar masivamente
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
        'id_requiere_muestra', // Corrección: Cambiado a id_requiere_muestra
        'nombre_Acreditacion',
        'descripcion_Acreditacion',
        'descripcion_Muestra',
    ];

    // Cast para manejar el campo id_requiere_muestra como booleano
    protected $casts = [
        'id_requiere_muestra' => 'boolean', // Corrección: Cambiado a id_requiere_muestra
        'id_acreditacion' => 'boolean'
    ];

    /**
     * Define la relación con los laboratorios.
     * Es una relación de muchos a muchos (BelongsToMany).
     */
    public function laboratorios(): BelongsToMany
    {
        return $this->belongsToMany(CatalogoLaboratorio::class, 'servicios_lab_servicio', 'id_servicio', 'id_laboratorio')
            ->withPivot('precio');
    }

    /**
     * Accessor para obtener el valor de acreditación en formato legible
     */
    public function getAcreditacionAttribute()
    {
        return $this->id_acreditacion ? 'Acreditado' : 'No acreditado';
    }
}
