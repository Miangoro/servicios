<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudTipo extends Model
{   
    protected $table = 'solicitudes_tipo';
    protected $primaryKey = 'id_tipo';

    use HasFactory;

    protected $fillable = [
        'tipo',
        
    ];
}
