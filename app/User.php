<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, Eloquence, Mappable;

    use Eloquence, Mappable;

    protected $table ='web_usuario_app';
    protected $primaryKey = 'web_usuarioAPP';
    public $incrementing = false;
    public $timestamps = false;

    protected $hidden = [
        'web_usuarioAPP',
        'web_claveAPP',
        'fechaAlta',
    ];

    protected $maps = [
        'email' => 'web_usuarioAPP',
        'fecha_alta' => 'fechaAlta',
    ];

    protected $appends = [
        'email',
        'fecha_alta',
    ];

    public function getAuthPassword()
    {
        return $this->web_claveAPP;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function afiliado(){
        return $this->hasOne('App\Views\AfiliadoAlDiaActivoView','id','matricula');
    }
}
