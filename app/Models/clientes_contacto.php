<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clientes_contacto extends Model
{
    //{
   // use HasFactory;

    public $timestamps = false;
    protected $table = 'clientes_contacto';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'cliente_id', 
        'nombre_contacto',
        'telefono_contacto', 
        'correo_contacto', 
        'status', 
        'observaciones'
      ];
}

