<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    protected $table = 'movimentos';
    protected $fillable = ['data','hora_descolagem', 'hora_aterragem', 'aeronave', 'num_diario', 'num_servico', 'piloto_id','aerodromo_partida','aerodromo_chegada','num_aterragens','num_descolagens','num_pessoas','conta_horas_inicio','conta_horas_fim','num_recibo'];
}
