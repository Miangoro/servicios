<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class serviciosTrackingModel extends Model
{
    protected $table = 'servicios_tracking_servicios';
    protected $primaryKey = 'id_tracking';
    protected $fillable = [
        'id_tracking',
        'nombre',
        'observaciones',
        'fecha_registro',
        'id_usuario',
        'id_servicio',
        'id_evento',
        'url_adjunto'
    ];

    public function servicio()
    {
        return $this->belongsTo(serviciosModel::class, 'id_servicio', 'id_servicio');
    }

}
