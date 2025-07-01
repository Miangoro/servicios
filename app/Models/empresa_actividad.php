<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresa_actividad extends Model
{
    use HasFactory;
    protected $table = 'empresa_actividad_cliente';
    protected $fillable = [
        'id_actividad',
        'id_empresa',
      ];
}
