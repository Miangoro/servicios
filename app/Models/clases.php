<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clases extends Model
{
    use HasFactory;
    protected $table = 'catalogo_clases';
    protected $primaryKey = 'id_clase';
    protected $fillable = [
        'id_clase',
        'clase',
    ];
}

