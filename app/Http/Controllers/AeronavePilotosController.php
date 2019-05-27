<?php

namespace App\Http\Controllers;

use App\User;
use App\Aeronave;
use App\AeronaveValor;
use App\AeronavePilotos;
use Illuminate\Http\Request;

class AeronavePilotosController extends Controller
{
    public function index($id){
        $aeronave = Aeronave::findOrFail($id);
        $title = "Pilotos da Aeronave ".$aeronave->matricula;
        $pilotos = $aeronave->user()->paginate(15);

       /** Pilotos Não Autorizados (e apenas pilotos) **/
        $pilotosNaoAutorizados= User::whereDoesntHave('aeronave', function ($query) use($id) {
                $query->where('aeronaves_pilotos.matricula','=',$id);
            })->where('tipo_socio','=','P')
        ->paginate(15); 
        return view('aeronaves.pilotos-list', compact('pilotos','title','pilotosNaoAutorizados', 'aeronave'));
    }

    public function store($matricula,$piloto){
    	$aeronave = Aeronave::findOrFail($matricula);
    	$aeronave->user()->attach($piloto);

    	return redirect()
    				->action('AeronavePilotosController@index', $aeronave->matricula)
                	->with('success', 'Piloto adicionado corretamente');

    }

    public function destroy($matricula,$piloto){
    	$aeronave = Aeronave::findOrFail($matricula);
    	$aeronave->user()->detach($piloto);

    	return redirect()
    				->action('AeronavePilotosController@index', $aeronave->matricula)
                	->with('success', 'Piloto removido corretamente');

    }




}
