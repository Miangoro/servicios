<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogos_regimenes extends Model // ¡IMPORTANTE! El nombre de la clase debe ser 'CatalogoRegimen' (PascalCase)
{
    use HasFactory;

    protected $table = 'catalogos_regimenes'; // Este es el nombre de la tabla en tu base de datos (snake_case)
    protected $primaryKey = 'id'; // Define la clave primaria si no es 'id' por defecto
    protected $fillable = ['regimen', 'habilitado']; // Columnas que se pueden asignar masivamente
    public $timestamps = false; // Si tu tabla no usa timestamps (como es común en tablas de catálogo)
}
