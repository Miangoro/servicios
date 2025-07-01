<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresa_producto extends Model
{
    use HasFactory;
    protected $table = 'empresa_producto_certificar';
    protected $fillable = [
        'id_producto',
        'id_empresa',
      ];
}
