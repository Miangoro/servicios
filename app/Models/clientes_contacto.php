<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Asegúrate de que esta línea esté si usas factories

class clientes_contacto extends Model
{
    use HasFactory; // Si no lo usas, puedes comentarlo o eliminarlo

    public $timestamps = false; // Indica que este modelo no usa las columnas created_at y updated_at
    protected $table = 'clientes_contacto'; // Define el nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Define la clave primaria de la tabla

    // Campos que pueden ser asignados masivamente (mass assignable)
    protected $fillable = [
        'id',
        'cliente_id',
        'nombre_contacto',
        'telefono_contacto',
        'correo_contacto',
        'status',
        'observaciones'
    ];

    // Define la relación inversa uno a muchos con el modelo empresas_clientes
    public function empresa()
    {
        return $this->belongsTo(empresas_clientes::class, 'cliente_id', 'id');
    }
}
