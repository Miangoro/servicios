<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\TranslatableActivityLog;

class solicitudesValidacionesModel extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;
    protected $table = 'solicitudes_validaciones';
    protected $primaryKey = 'id_validacion';
    public $timestamps = false;
    protected $fillable = [
        'id_solicitud',
        'estatus',
        'tipo_validacion',
        'id_usuario',
        'fecha_realizo',
        'validacion',
        'puesto'
    ];

    // Método para obtener el nombre del registro que sirve para la trazabilidad
    public function getLogName2(): string
    {
        return 'validación'; // Devuelve el nombre que desees
    }

    public function solicitud()
    {
        return $this->belongsTo(solicitudesModel::class, 'id_solicitud', 'id_solicitud');
    }

    public function responsable()
    {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}
