<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Dictamen_instalaciones extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;
    protected $table = 'dictamenes_instalaciones';
    protected $primaryKey = 'id_dictamen';
    protected $fillable = [
        'id_dictamen',
        'id_inspeccion',
        'tipo_dictamen',
        'num_dictamen',
        'fecha_emision',
        'fecha_vigencia',
        'id_firmante',
        'estatus',
        'observaciones',
        'id_instalacion'
      ];

      // Método para obtener el nombre del registro que sirve para la trazabilidad
        public function getLogName2(): string
        {
            return 'dictamen de instalaciones'; // Devuelve el nombre que desees
        }

      public function inspeccione()
        {
            return $this->belongsTo(inspecciones::class, 'id_inspeccion', 'id_inspeccion');
        }

        public function instalaciones()
        {
            return $this->belongsTo(instalaciones::class, 'id_instalacion', 'id_instalacion');
        }

        Public function certificado()
        {
            return $this->belongsTo(Certificados::class, 'id_dictamen', 'id_dictamen');   
        }  
        
        public function firmante()
        {
            return $this->belongsTo(User::class, 'id_firmante', 'id');
        }
}
