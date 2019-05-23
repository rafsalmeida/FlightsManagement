<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Socio extends Model
{
    protected $table = 'users';
    use SoftDeletes;
    protected $fillable = ['num_socio', 'name', 'nome_informal', 'email','nif','data_nascimento','telefone','endereco','num_licenca','validade_licenca','num_certificado','validade_certificado'];

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
