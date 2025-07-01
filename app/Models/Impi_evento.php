<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TranslatableActivityLog;
use Spatie\Activitylog\Traits\LogsActivity;

class Impi_evento extends Model
{
    use HasFactory;

    protected $table = 'evento_impi';
    protected $primaryKey = 'id_evento';
    protected $fillable = [
        'id_evento',
        'id_impi', 
        'evento', 
        'descripcion',
        'url_anexo',
        'color'
    ];



    
}
