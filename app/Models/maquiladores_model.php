<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maquiladores_model extends Model
{
    use HasFactory;
    protected $table = 'maquiladores';
    public $timestamps = false;
    protected $fillable = [
        'id_maquilador',
        'id_maquiladora'
    ];
    
}
