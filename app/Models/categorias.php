<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categorias extends Model
{
    use HasFactory;
    protected $table = 'catalogo_categorias';
    protected $primaryKey = 'id_categoria';
    protected $fillable = [
        'id_categoria',
        'categoria',
      ];
}