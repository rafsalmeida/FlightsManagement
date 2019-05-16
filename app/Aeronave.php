<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aeronave extends Model
{
	protected $table = 'aeronaves';
    use SoftDeletes;
    protected $primaryKey = 'matricula';
    public $incrementing = false;
    protected $fillable = ['matricula', 'marca', 'modelo', 'num_lugares','conta_horas','preco_hora'];

    
}
