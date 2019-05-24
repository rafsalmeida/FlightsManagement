<?php

namespace App\Http\Controllers;

use App\Movimento;
use Illuminate\Http\Request;
use Illuminate\validation\Rule;
use App\AeronaveValor;
use App\User;

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
        $pilotos = User::all();
        return view('movimentos.list', compact('movimentos','title','pilotos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Adicionar Movimento";
        return view("movimentos.add", compact("title"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has("cancel")) {
            return redirect()->action("MovimentoController@index");
        }
        
        $movimento = new Movimento();
       
        $movimentoModel = $request->validate([
        'data' => 'required',
        'hora_descolagem' => 'required',
        'hora_aterragem' => 'required',
        'aeronave' => 'required|string|exists:aeronaves,matricula',
        'natureza' => 'required',
        'num_diario' => 'required|integer',
        'num_servico' => 'required|integer',
        'piloto_id' => 'required|integer|exists:aeronaves_pilotos,piloto_id,matricula,'.$request->aeronave.'',
        'aerodromo_partida' => 'required|string|exists:aerodromos,code',
        'aerodromo_chegada' => 'required|string|exists:aerodromos,code',
        'num_aterragens' => 'required|integer',
        'num_descolagens' => 'required|integer',
        'num_pessoas' => 'required|integer',
        'conta_horas_inicio' => 'required|integer',
        'conta_horas_fim' => 'required|integer|min:'.$request->conta_horas_inicio.'+1',
        'num_recibo' => 'required|integer',
        'instrutor_id' => 'nullable|required_if:natureza,I|exists:aeronaves_pilotos,piloto_id,matricula,'.$request->aeronave.'',
        'tipo_instrucao' => 'required_if:natureza,I',
        'modo_pagamento' => 'required',
        'observacoes' => 'nullable'
        ]);

        $piloto = User::find($request->piloto_id);

        $movimento->fill($movimentoModel);

        $movimento->hora_aterragem = date('Y-m-d', strtotime($request->data)).' '.$request->hora_aterragem;
        $movimento->hora_descolagem = date('Y-m-d', strtotime($request->data)).' '.$request->hora_descolagem;
        $movimento->num_licenca_piloto = $piloto->num_licenca;
        $movimento->validade_licenca_piloto = $piloto->validade_licenca;
        $movimento->tipo_licenca_piloto = $piloto->tipo_licenca;
        $movimento->num_certificado_piloto = $piloto->num_certificado;
        $movimento->validade_certificado_piloto = $piloto->validade_certificado;
        $movimento->classe_certificado_piloto = $piloto->classe_certificado;
        $movimento->tempo_voo = ($request->conta_horas_fim-$request->conta_horas_inicio)*6;
        $aeronave_precos = AeronaveValor::whereMatricula($request->aeronave)->whereUnidadeContaHoras($request->conta_horas_fim-$request->conta_horas_inicio)->first();
        $movimento->preco_voo = $aeronave_precos->preco;
        $movimento->confirmado = 0;
        if ($request->natureza == 'I'){
            $instrutor = User::find($request->piloto_id);
            $movimento->num_licenca_instrutor = $instrutor->num_licenca;
            $movimento->validade_licenca_instrutor = $instrutor->validade_licenca;
            $movimento->tipo_licenca_instrutor = $instrutor->tipo_licenca;
            $movimento->num_certificado_instrutor = $instrutor->num_certificado;
            $movimento->validade_certificado_instrutor = $instrutor->validade_certificado;
            $movimento->classe_certificado_instrutor = $instrutor->classe_certificado;
        }

        if($request->conta_horas_inicio<5){

        }

        $movimento->save();

        return redirect()
                 ->action("MovimentoController@index")            
                 ->with("success", "Movimento adicionado corretamente");
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
        'aeronave' => 'required|string|exists:aeronaves,matricula',
        'natureza' => 'required',
        'num_diario' => 'required|integer',
        'num_servico' => 'required|integer',
        'piloto_id' => 'required|integer|exists:aeronaves_pilotos,piloto_id,matricula,'.$request->aeronave.'',
        'aerodromo_partida' => 'required|string|exists:aerodromos,code',
        'aerodromo_chegada' => 'required|string|exists:aerodromos,code',
        'num_aterragens' => 'required|integer',
        'num_descolagens' => 'required|integer',
        'num_pessoas' => 'required|integer',
        'conta_horas_inicio' => 'required|integer',
        'conta_horas_fim' => 'required|integer',
        'num_recibo' => 'required|integer',
        'instrutor_id' => 'nullable|required_if:natureza,I|exists:aeronaves_pilotos,piloto_id,matricula,'.$request->aeronave.'',
        'tipo_instrucao' => 'required_if:natureza,I',
        'modo_pagamento' => 'required',
        'observacoes' => 'nullable'
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
