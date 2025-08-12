<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicios_tracking_clientes extends Model
{
    use HasFactory;

    // Define la clave primaria y el nombre de la tabla
    protected $primaryKey = 'id_tracking';
    protected $table = 'servicios_tracking_clientes';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'id_tracking',
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
