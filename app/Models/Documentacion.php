<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentacion extends Model
{   
    use HasFactory;
    public $timestamps = false;
    protected $table = 'documentacion';
    protected $primaryKey = 'id_documento';
    protected $fillable = ['nombre', 'tipo', 'subtipo'];

    public function documentacionUrls()
    {
        return $this->hasMany(Documentacion_url::class, 'id_documento');
    }

    
}
