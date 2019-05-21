<?php

namespace App\Http\Controllers;

use App\Movimento;
use Illuminate\Http\Request;

class MovimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        $movimentos = Movimento::paginate(15);
        $title = "Lista de Movimentos";
        return view('movimentos.list', compact('movimentos','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function show(Movimento $movimento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Editar Movimento";
        $movimento = Movimento::findOrFail($id);
        return view("movimentos.edit", compact("title", "movimento"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validar e dar store na bd

        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }

        $movimento = $request->validate([
        'aeronave' => 'required|string',
        'num_diario' => 'required|integer',
        'num_servico' => 'required|integer',
        'piloto_id' => 'required|integer',
        'aerodromo_partida' => 'required|string',
        'aerodromo_chegada' => 'required|string',
        'num_aterragens' => 'required|integer',
        'num_descolagens' => 'required|integer',
        'num_pessoas' => 'required|integer',
        'conta_horas_inicio' => 'required|integer',
        'conta_horas_fim' => 'required|integer',
        'num_recibo' => 'required|integer',
        ]);
        $movimentoModel = Movimento::findOrFail($id);
        $movimentoModel->fill($movimento);
        $movimentoModel->save();
        return redirect()
                ->action('MovimentoController@index')
                ->with('success', 'Movimento editada corretamente');

        

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movimento $movimento)
    {
        //
    }
}
