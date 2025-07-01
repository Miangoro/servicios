<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogo_actividad_cliente extends Model
{
    use HasFactory;
    protected $table = 'catalogo_actividad_cliente';
    protected $primaryKey = 'id_actividad';
    protected $fillable = [
        'actividad',
        'id_norma',
    ];


}
