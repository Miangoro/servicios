<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Documentacion_url extends Model
{
    protected $table = 'documentacion_url';
       // use LogsActivity, TranslatableActivityLog, HasFactory;
       use  HasFactory;
        protected $fillable = [
            'id_empresa',
            'url',
            'id_relacion',
            'id_usuario_registro',
            'nombre_documento',
            'fecha_vigencia',
            'id_documento',
            'id_doc'

        ];

      // Método para obtener el nombre del registro que sirve para la trazabilidad
     /*   public function getLogName2(): string
        {
            return 'documentación'; // Devuelve el nombre que desees
        }*/


      public function marca()
      {
          return $this->belongsTo(marcas::class, 'id_relacion', 'id_marca');
      }

      public function documentacion()
      {
          return $this->belongsTo(Documentacion::class, 'id_documento');
      }

      public function documentacionInstalaciones()
      {
        return $this->belongsTo(Instalaciones::class, 'id_relacion', 'id_instalacion');
      }

      
}
