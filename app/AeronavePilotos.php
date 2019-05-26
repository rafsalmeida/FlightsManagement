<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AeronavePilotos extends Pivot
{
    protected $table = "aeronaves_pilotos";

    public $timestamps = false;

    protected $fillable = ['matricula', 'piloto_id'];

}
