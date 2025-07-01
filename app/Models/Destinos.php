<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Destinos extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    // Puedes especificar la tabla si no sigue la convención
    protected $table = 'direcciones';

    protected $primaryKey = 'id_direccion'; // Clave primaria de la tabla

    // Define los campos que se pueden llenar de forma masiva
    protected $fillable = [
        'tipo_direccion',
        'id_empresa',
        'direccion',
        'destinatario',
        'aduana',
        'pais_destino',
        'nombre_recibe',
        'correo_recibe',
        'celular_recibe',
    ];

    public function getLogName2(): string
    {
        return 'destinos'; // Devuelve el nombre que desees
    }

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }


}
