<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicios_tracking_clientes extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'servicios_tracking_clientes';

    // Clave primaria de la tabla
    protected $primaryKey = 'id_tracking';

    // Indica si la clave primaria es auto-incremental
    // Este es el valor por defecto, pero es buena práctica ser explícito
    public $incrementing = true;

    // Desactiva los timestamps si la tabla no tiene created_at y updated_at
    public $timestamps = false;

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'observaciones',
        'fecha_registro',
        'id_usuario',
        'id_cliente',
        'id_empresa',
        'id_evento',
        'url_adjunto'
    ];
}