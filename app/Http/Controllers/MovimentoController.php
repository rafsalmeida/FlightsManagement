<?php

namespace App\Http\Controllers;

use App\Movimento;
use Illuminate\Http\Request;
use App\AeronaveValor;
use App\User;
use App\Aeronave;
use App\Http\Requests\StoreMovimento;
use Khill\Lavacharts\Lavacharts;

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
        $this->middleware('ativo');
    }

    
    public function index(Request $request)
    {
        $query = Movimento::limit(10);

        if ($request->filled('id') && $request['id'] != null) {
            $query->where('id', $request->get('id'));
        }

        if ($request->filled('aeronave') && $request['aeronave'] != null) {
            $matricula = $request->get('aeronave');
            $query->where('aeronave', 'like', "%$matricula%");
        }

        if ($request->filled('nome_informal_piloto') && $request['nome_informal_piloto'] != null) {
            $nome = $request->get('nome_informal_piloto');
            $piloto_id = User::where('nome_informal','like',"%$nome%")->get()->pluck('id');
            $query->whereIn('piloto_id', $piloto_id);
        }

        if ($request->filled('nome_informal_instrutor') && $request['nome_informal_instrutor'] != null) {
            $nome = $request->get('nome_informal_instrutor');
            $instrutor_id = User::where('nome_informal','like',"%$nome%")->get()->pluck('id');
            $query->whereIn('instrutor_id', $instrutor_id);
        }

        if ($request->filled('natureza') && $request['natureza'] != null) {
            $query->where('natureza', $request->get('natureza'));
        }

        if ($request->filled('confirmado') && $request['confirmado'] != null) {
            $query->where('confirmado', $request->get('confirmado'));
        }

        $movimentos = $query->paginate(15);

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
       
        $request->validated();

        $movimento->fill($request->all());

        $movimento->observacoes = $request->observacoes;
        $movimento->hora_aterragem = date('Y-m-d', strtotime($request->data)).' '.$request->hora_aterragem;
        $movimento->hora_descolagem = date('Y-m-d', strtotime($request->data)).' '.$request->hora_descolagem;
        $movimento->num_licenca_piloto = $movimento->piloto->num_licenca;
        $movimento->validade_licenca_piloto = $movimento->piloto->validade_licenca;
        $movimento->tipo_licenca_piloto = $movimento->piloto->tipo_licenca;
        $movimento->num_certificado_piloto = $movimento->piloto->num_certificado;
        $movimento->validade_certificado_piloto = $movimento->piloto->validade_certificado;
        $movimento->classe_certificado_piloto = $movimento->piloto->classe_certificado;
        $movimento->tempo_voo = ($request->conta_horas_fim-$request->conta_horas_inicio)*6;
        $movimento->preco_voo = $movimento->thisAeronave->valores->where('unidade_conta_horas', '$request->conta_horas_fim-$request->conta_horas_inicio')->first->preco->preco;
        $movimento->confirmado = 0;
        if ($request->natureza == 'I'){
            $movimento->num_licenca_instrutor = $movimento->instrutor->num_licenca;
            $movimento->validade_licenca_instrutor = $movimento->instrutor->validade_licenca;
            $movimento->tipo_licenca_instrutor = $movimento->instrutor->tipo_licenca;
            $movimento->num_certificado_instrutor = $movimento->instrutor->num_certificado;
            $movimento->validade_certificado_instrutor = $movimento->instrutor->validade_certificado;
            $movimento->classe_certificado_instrutor = $movimento->instrutor->classe_certificado;
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

    public function statistics(){

        $aeronaveYearTable = \Lava::DataTable();  // Lava::DataTable() if using Larave
        $aeronaveYearTable->addDateColumn('Ano')
                          ->addNumberColumn('Horas');
        $anos=[];
        $aeronave = Aeronave::findOrFail('D-EAYV');
        foreach($aeronave->movimentos as $movimento){
            if(!in_array(date('Y',strtotime($movimento->data)),$anos)){
            array_push($anos, date('Y',strtotime($movimento->data)));
        }
        }
        dd($anos);
        // Random Data For Example
        foreach (Aeronave::first()->movimentos->get() as $movimento) {
            $aeronaveYearTable->addRow([
                $movimento->data->format('Y'), 
            ]);
        }
        
        /*for ($a = 1; $a < 30; $a++) {
            $stocksTable->addRow([
              '2015-10-' . $a, rand(800,1000), rand(800,1000)
            ]);
        }*/

        $chart = \Lava::LineChart('MyStocks', $stocksTable);
        echo \Lava::render('LineChart', 'MyStocks', 'stocks-chart');
    
       return view("movimentos.statistics");

        
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

        $request->validated();
            
        $movimento = Movimento::findOrFail($id);
        $movimento->fill($request->all());

        $movimento->save();
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
    public function destroy($id)
    {
        $movimento = Movimento::findOrFail($id);
        //$movimentos = $socio->movimentos;
        if($movimento->confirmado == 0){
            $movimento->delete();
        } else {
            return redirect()->action("MovimentoController@index")->with('sucess', 'Movimento Confirmado. Impossivel Apagar');
        }

        return redirect()->action("MovimentoController@index")->with('success', 'Movimento apagado corretamente');
    }
}
