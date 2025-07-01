<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogo_aduanas extends Model
{
   use HasFactory;
    // Por si Laravel no detecta bien el nombre de la tabla (no pluraliza)
    protected $table = 'catalogo_aduanas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'aduana',
    ];
       public $timestamps = false;

}
