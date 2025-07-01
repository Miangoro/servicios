<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'telefono',
        'puesto',
        'estatus',
        'firma',
        'id_contacto',
        'password',
        'id_empresa',
        'password_original',
        'tipo'
    ];

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function inspecciones()
    {
        return $this->hasMany(inspecciones::class, 'id_inspector', 'id');
    }
    public function dictamenesEnvasado()
    {
        return $this->hasMany(Dictamen_Envasado::class, 'id_firmante');
    }

    public function solicitudesHologramas()
    {
        return $this->hasMany(solicitudHolograma::class, 'id_solicitante', 'id_empresa');
    }
}
