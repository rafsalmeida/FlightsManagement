<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'users';
    use SoftDeletes;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = ['num_socio', 'name', 'nome_informal', 'email','nif','sexo','data_nascimento','telefone','endereco','num_licenca','validade_licenca','num_certificado','validade_certificado'];

    public function tipoLicenca()
    {
        return $this->belongsTo('App\TipoLicenca', 'tipo_licenca','code');

    }

    public function classeCertificado()
    {
        return $this->belongsTo('App\ClasseCertificado', 'classe_certificado','code');

    }

    public function movimentos(){
        return $this->hasMany('App\Movimentos');
    }
   
    
}
