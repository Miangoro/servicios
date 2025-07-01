<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresa_norma extends Model
{
    use HasFactory;
    protected $table = 'empresa_norma_certificar';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_norma',
        'id_empresa',
      ];
      public $timestamps = false;
}
