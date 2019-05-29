<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aerodromo extends Model
{
    protected $table = "aerodromos";

    public function movimentos(){
    	return $this->hasMany("App\Movimento");
    }
}
