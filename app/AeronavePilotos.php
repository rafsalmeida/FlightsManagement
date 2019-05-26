<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AeronavePilotos extends Model
{
    protected $table = "aeronaves_pilotos";

    public $timestamps = false;

    protected $fillable = ['matricula', 'piloto_id'];
}
