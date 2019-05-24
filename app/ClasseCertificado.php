<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClasseCertificado extends Model
{
    protected $table = "classes_certificados";

    public function socio()
	{
		return $this->hasMany('App\User', 'classe_certificado', 'code');
	}
}


