<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AeronaveValor extends Model
{
    protected $table = "aeronaves_valores";

    public $timestamps = false;

    protected $fillable = ['matricula', 'unidade_conta_horas', 'minutos', 'preco'];

    public function aeronaves(){
    	return $this->belongsTo('App\Aeronave' , 'id' , 'matricula');
    }
  
}
