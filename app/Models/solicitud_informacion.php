<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitud_informacion extends Model
{
    use HasFactory;
    protected $table = 'solicitud_informacion';
    protected $fillable = [
        'i',
        'id_empresa',
        'medios',
        'competencia',
        'capacidad',
        'comentarios'
      ];
}
