<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    
    protected $table = 'empresas_clientes';
    protected $fillable = [
        'id',
        'codigo',
        'nombre',
        'rfc',
        'credito',
        'regimen',
        'calle',
        'colonia',
        'estado',
        'localidad',
        'municipio',
        'constancia',
        'noext',
        'codigo_postal',
        'correo',
        'telefono',
        
      ];
       // Definiendo la relación con Contacto
       //codigo original
    public function contactos()
    {
        return $this->hasMany(clientes_contacto::class, 'cliente_id');
    }
    
    public function regimenFiscal()
    {
        
        return $this->belongsTo(catalogos_regimenes::class, 'regimen', 'id');
    }

   
}


