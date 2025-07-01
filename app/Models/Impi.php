<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TranslatableActivityLog;
use Spatie\Activitylog\Traits\LogsActivity;

class Impi extends Model
{
    use HasFactory;

    protected $table = 'tramite_impi';
    protected $primaryKey = 'id_impi';
    protected $fillable = [
        'id_impi',
        'folio', 
        'tramite', 
        'fecha_solicitud',
        'cliente',
        'contrasena',
        'pago',
        'estatus',
        'observaciones',
    ];


    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa', 'id_empresa');
    }

    public function empresaNumClientes()
    {
        return $this->hasMany(empresaNumCliente::class, 'id_empresa','id_empresa');
    }

    
    
}
