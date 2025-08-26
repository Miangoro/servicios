<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class serviciosLabModel extends Model
{
    protected $table = 'servicios_lab_servicio';
    protected $primaryKey = 'id_servicio_lab';
    protected $fillable = [
        'id_servicio_lab',
        'id_servicio',
        'id_laboratorio',
        'precio'
    ];

    public function servicio()
    {
        return $this->belongsTo(serviciosModel::class, 'id_servicio', 'id_servicio');
    }

    public function laboratorio()
    {
        return $this->belongsTo(CatalogoLaboratorio::class, 'id_laboratorio', 'id_laboratorio');
    }
}
