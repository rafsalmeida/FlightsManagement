<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Socio extends Model
{
    protected $table = 'users';
    use SoftDeletes;

    public function tipoLicenca()
	{
		return $this->belongsTo('App\TipoLicenca', 'tipo_licenca','code');

	}

	public function classeCertificado()
	{
		return $this->belongsTo('App\ClasseCertificado', 'classe_certificado','code');

	}
    
}
