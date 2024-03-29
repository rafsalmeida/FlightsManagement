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

    protected $fillable = ['num_socio', 'name', 'nome_informal', 'email','nif','sexo','data_nascimento','telefone','endereco','tipo_socio','quota_paga','ativo','direcao','aluno','instrutor','num_licenca','tipo_licenca','licenca_confirmada','validade_licenca','num_certificado','classe_certificado','certificado_confirmado','validade_certificado','foto_url'];

    public function tipoLicenca()
    {
        return $this->belongsTo('App\TipoLicenca', 'tipo_licenca','code');

    }

    public function classeCertificado()
    {
        return $this->belongsTo('App\ClasseCertificado', 'classe_certificado','code');

    }

    public function movimentosPiloto(){
        return $this->hasMany('App\Movimento','piloto_id', 'id');
    }

    public function movimentosInstrutor(){
        return $this->hasMany('App\Movimento','instrutor_id', 'id');
    }

    public function aeronave()
    {
        return $this->belongsToMany('App\Aeronave','aeronaves_pilotos', 'piloto_id', 'matricula');
    }
    
    public function scopeIsPiloto()
    {
        if($this->tipo_socio=='P'){
            return true;
        }
        return false;
    }

    public function scopeGetPilotos()
    {
        return $this->where('tipo_socio','=','P');

    }

   
    
}
