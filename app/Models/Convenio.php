<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    use HasFactory;

    /**
     * Indica si el modelo debe ser timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * El nombre de la tabla asociada al modelo.
     * @var string
     */
    protected $table = 'catalogo_convenio';

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clave',
        'nombre_proyecto',
        'investigador_responsable',
        'duracion',
        'tipo_duracion',
    ];

    /**
     * Los atributos que deberían ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Aquí puedes agregar casts si es necesario, por ejemplo:
        // 'duracion' => 'integer',
    ];
}