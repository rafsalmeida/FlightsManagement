<?php

namespace App\Http\Controllers;

use App\Movimento;
use Illuminate\Http\Request;
use App\AeronaveValor;
use App\User;
use App\Aeronave;
use App\Aerodromo;
use App\Http\Requests\StoreMovimento;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('verified');
    }

    public function confirm(Request $request){
        $checkboxes = $request->input('confirmar');


        var_dump($checkboxes);

        

        //foreach ($checkboxes as $id) {
        //    $movimento = Movimento::findOrFail($id);
        //    $movimento->confirmado = 1;
        //    $movimento->save();
        //}

        //return redirect('movimentos');
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

        if ($request->filled('piloto') && $request['piloto'] != null) {
            $piloto_id = $request->get('piloto'); //passar o piloto_id para $nome
            //$piloto_id = User::where('nome_informal','like',"%$nome%")->get()->pluck('id');
            $query->where('piloto_id', $piloto_id); //se quiser usar o nome passar o where para whereIn
        }

        if ($request->filled('instrutor') && $request['instrutor'] != null) {
            $instrutor_id = $request->get('instrutor'); //passar o piloto_id para $nome
            //$instrutor_id = User::where('nome_informal','like',"%$nome%")->get()->pluck('id');
            $query->where('instrutor_id', $instrutor_id); //se quiser usar o nome passar o where para whereIn
        }

        if ($request->filled('natureza') && $request['natureza'] != null) {
            $query->where('natureza', $request->get('natureza'));
        }

        if ($request->filled('confirmado') && $request['confirmado'] != null) {
            $query->where('confirmado', $request->get('confirmado'));
        }

        if ($request->filled('data_inf') && $request['data_inf'] != null) {
            $query->where('data', '>=', $request->get('data_inf'));
        }

        if ($request->filled('data_sup') && $request['data_sup'] != null) {
            $query->where('data', '<=', $request->get('data_sup'));
        }

        if ($request->filled('meus_movimentos') && $request['meus_movimentos'] != null) {
            $id = Auth::user()->id;
            $query->where('piloto_id', $id)->orWhere('instrutor_id', $id);
        }

        if($request->filled('ordenar') && $request['ordenar'] != null){
            if ($request->get('ordenar') == 'IDA') {
                $query->orderBy('id','ASC');
            }
            elseif ($request->get('ordenar') == 'IDD') {
                $query->orderBy('id','DESC');            }
            elseif ($request->get('ordenar') == 'AA') {
                $query->orderBy('aeronave','ASC');
            }
            elseif ($request->get('ordenar') == 'AD') {
                $query->orderBy('aeronave','DESC');
            }
            elseif ($request->get('ordenar') == 'DA') {
                $query->orderBy('data','ASC');
            }
            elseif ($request->get('ordenar') == 'DD') {
                $query->orderBy('data','DESC');
            }
            elseif ($request->get('ordenar') == 'TA') {
                $query->orderBy('natureza','ASC');
            }
            elseif ($request->get('ordenar') == 'TD') {
                $query->orderBy('natureza','DESC');
            }           
        }

        /*if ($request->filled('natureza') && $request['natureza'] != null && $request->filled('piloto') && $request['piloto'] != null && $request->filled('instrutor') && $request['instrutor'] != null ){

            $nome_piloto = $request->get('piloto');
            $natureza = $request->get('natureza');
            $nome_instrutor = $request->get('instrutor');
            $piloto_id = User::where('nome_informal','=', $nome_piloto)->get()->pluck('id'); 
            $instrutor_id = User::where('nome_informal','=', $nome_instrutor)->get()->pluck('id');
            $query->where('natureza', $natureza)
            ->where('instrutor_id' ,$instrutor_id)
            ->where('piloto_id',$piloto_id);

             //dd($piloto_id, $natureza, $nome_instrutor);
        }*/

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
        $aerodromos = Aerodromo::pluck('nome','code');
        $aerodromos[''] = "Escolha um aerodromo";
        $aeronaves = Auth::user()->aeronave->pluck('matricula', 'matricula');
        $aeronaves[''] = "Escolha uma aeronave";
        return view("movimentos.add", compact("title", "aerodromos", "aeronaves"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    



    public function store(StoreMovimento $request)
    {
        if ($request->has("cancel")) {
            return redirect()->action("MovimentoController@index");
        }
        
        $movimento = new Movimento();
       
        $request->validated();
        $movimento->fill($request->all());
        $request->request->add([
            'num_licenca_piloto' => $movimento->piloto->num_licenca,
            'validade_licenca_piloto' => $movimento->piloto->validade_licenca,
            'tipo_licenca_piloto' => $movimento->piloto->tipo_licenca,
            'num_certificado_piloto' => $movimento->piloto->num_certificado,
            'validade_certificado_piloto' => $movimento->piloto->validade_certificado,
            'classe_certificado_piloto' => $movimento->piloto->classe_certificado,
        ]);

        //dd($request);

        if($request->natureza == 'I'){
            $request->request->add([
            'num_licenca_instrutor' => $movimento->instrutor->num_licenca,
            'validade_licenca_instrutor' => $movimento->instrutor->validade_licenca,
            'tipo_licenca_instrutor' => $movimento->instrutor->tipo_licenca,
            'num_licenca_instrutor' => $movimento->instrutor->num_certificado,
            'validade_licenca_instrutor' => $movimento->instrutor->validade_certificado,
            'classe_certificado_instrutor' => $movimento->instrutor->classe_certificado,

            ]);
        }

        $movimento->fill($request->all());

        $dataRecente = $movimento->getAeronave->movimentos->max('data');
        $movimentoRecente = Movimento::where('data',$dataRecente)->where('aeronave', $movimento->getAeronave->matricula)->first();
        $contaHoras = $movimentoRecente->conta_horas_fim;


        if($request->conta_horas_inicio != $contaHoras && $request->hasConflito == 0){
            $request->request->add(['hasConflito' => "1"]);
            return redirect()->back()->withInput($request->all());

        }

        if($request->hasConflito == 1){
            if($request->conta_horas_inicio > $contaHoras){
                $request['tipo_conflito'] = 'B';
            } else {
                $request['tipo_conflito'] = 'S';
            }
        }

        $movimento->fill($request->all());

        dd($movimento);
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
        $aerodromos = Aerodromo::pluck('nome','code');
        $aerodromos[''] = "Escolha um aerodromo";
        $aeronaves = Auth::user()->aeronave->pluck('matricula', 'matricula');
        $aeronaves[''] = "Escolha uma aeronave";
        return view("movimentos.edit", compact("movimento","title", "aerodromos", "aeronaves"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMovimento $request, $id)
    {
        //validar e dar store na bd

        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }

        $movimento = Movimento::findOrFail($id);

        $request->validated();

        $request->request->add([
            'num_licenca_piloto' => $movimento->piloto->num_licenca,
            'validade_licenca_piloto' => $movimento->piloto->validade_licenca,
            'tipo_licenca_piloto' => $movimento->piloto->tipo_licenca,
            'num_certificado_piloto' => $movimento->piloto->num_certificado,
            'validade_certificado_piloto' => $movimento->piloto->validade_certificado,
            'classe_certificado_piloto' => $movimento->piloto->classe_certificado,
        ]);


        if($request->natureza == 'I'){
            $request->request->add([
            'num_licenca_instrutor' => $movimento->instrutor->num_licenca,
            'validade_licenca_instrutor' => $movimento->instrutor->validade_licenca,
            'tipo_licenca_instrutor' => $movimento->instrutor->tipo_licenca,
            'num_licenca_instrutor' => $movimento->instrutor->num_certificado,
            'validade_licenca_instrutor' => $movimento->instrutor->validade_certificado,
            'classe_certificado_instrutor' => $movimento->instrutor->classe_certificado,

            ]);
        }

        $movimento->fill($request->all());

        $dataRecente = $movimento->getAeronave->movimentos->max('data');
        $movimentoRecente = Movimento::where('data',$dataRecente)->first();
        $contaHoras = $movimentoRecente->conta_horas_fim;

        if($request->conta_horas_inicio != $contaHoras && $request->hasConflito == 0){
            $request->request->add(['hasConflito' => "1"]);
            return redirect()->back()->withInput($request->all());

        }

        if($request->hasConflito == 1){
            if($request->conta_horas_inicio > $contaHoras){
                $request['tipo_conflito'] = 'B';
            } else {
                $request['tipo_conflito'] = 'S';
            }
        }
        dd($movimentoRecente, $contaHoras);

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






    public function statistics(Request $request){

        $title="Estatísticas dos Movimentos";

        $aeronaves = Aeronave::paginate(15);
        $pilotos = User::getPilotos()->paginate(15);
        $titleAeronave = null;
        $titlePiloto = null;

        if($request->filled('matricula')){

            $titleAeronave = "Aeronave ".$request->get('matricula');

            //AERONAVE POR ANO -------------------------------

            $aeronaveYearTable = \Lava::DataTable();  // Lava::DataTable() if using Larave
            $aeronaveYearTable->addStringColumn('Ano')
                              ->addNumberColumn('Horas');

            $anos=[];
            $aeronave = Aeronave::findOrFail($request->get('matricula')); //$id
            foreach($aeronave->movimentos as $movimento){
                if(!in_array(date('Y',strtotime($movimento->data)),$anos)){
                    array_push($anos, date('Y',strtotime($movimento->data)));
                }
            }

            $temposAno = [];
            $sum = 0;
            $movimentos = $aeronave->movimentos;

            foreach ($anos as $ano) {
                $sum = 0;
                foreach ($movimentos as $movimento) {
                    if((date('Y',strtotime($movimento->data))==$ano)){
                        $sum = $sum + $movimento->tempo_voo;
                    }
                }
                array_push($temposAno, $sum);
            }


            for($i=0; $i < count($anos); $i++) {
                $aeronaveYearTable->addRow([
                        $anos[$i], $temposAno[$i]/60
                ]);     
            }

            
            \Lava::AreaChart('Aeronave/Ano', $aeronaveYearTable);
            echo \Lava::render('AreaChart', 'Aeronave/Ano', 'year-chart');

                    //AERONAVE POR MES -------------------------------

            $aeronaveMonthTable = \Lava::DataTable();  // Lava::DataTable() if using Larave
            $aeronaveMonthTable->addStringColumn('Mês')
                              ->addNumberColumn('Horas');
            $meses=[];
            $aeronave = Aeronave::findOrFail($request->get('matricula')); //$id
            foreach($aeronave->movimentos as $movimento){
                if(!in_array(date('m',strtotime($movimento->data)),$meses)){
                    array_push($meses, date('m',strtotime($movimento->data)));
                }
            }

            $temposMes = [];
            $sum = 0;
            $movimentos = $aeronave->movimentos;

            foreach ($meses as $mes) {
                $sum = 0;
                foreach ($movimentos as $movimento) {
                    if((date('m',strtotime($movimento->data))==$mes)){
                        $sum = $sum + $movimento->tempo_voo;
                    }
                }
                array_push($temposMes, $sum);
            }

            for($i=0; $i < count($meses); $i++) {
                $aeronaveMonthTable->addRow([
                        $meses[$i], $temposMes[$i]
                ]);     
            }

            
            \Lava::AreaChart('Aeronave/Mes', $aeronaveMonthTable);
            echo \Lava::render('AreaChart', 'Aeronave/Mes', 'month-chart');
            return view("movimentos.statistics", compact("title", "aeronaves", "pilotos", "titleAeronave", "titlePiloto"));
        }

        if($request->filled('id')){
            //PILOTO POR MES -------------------------------
            
            $titlePiloto="Piloto ".$request->get('id');

            $pilotMonthTable = \Lava::DataTable();  // Lava::DataTable() if using Larave
            $pilotMonthTable->addStringColumn('Mês')
                            ->addNumberColumn('Horas');


            $meses=[];
            $piloto = User::findOrFail($request->get('id')); //$id
            foreach($piloto->movimentosPiloto as $movimento){
                if(!in_array(date('m',strtotime($movimento->data)),$meses)){
                    array_push($meses, date('m',strtotime($movimento->data)));
                }
            }

            $temposMes = [];
            $sum = 0;
            $movimentos = $piloto->movimentosPiloto;

            foreach ($meses as $mes) {
                $sum = 0;
                foreach ($movimentos as $movimento) {
                    if((date('m',strtotime($movimento->data))==$mes)){
                        $sum = $sum + $movimento->tempo_voo;
                    }
                }
                array_push($temposMes, $sum);
            }


            for($i=0; $i < count($meses); $i++) {
                $pilotMonthTable->addRow([
                        $meses[$i], $temposMes[$i]
                ]);     
            }

            
            \Lava::AreaChart('Piloto/Mes', $pilotMonthTable);
            echo \Lava::render('AreaChart', 'Piloto/Mes', 'pilot-month-chart');

            //---------------------------------------------------------
                    //---------------------------------------------------------
            //---------------------------------------------------------
            //PILOTO POR ANO -------------------------------

            $pilotYearTable = \Lava::DataTable();  // Lava::DataTable() if using Larave
            $pilotYearTable->addStringColumn('Ano')
                            ->addNumberColumn('Horas');


            $anos=[];
            $piloto = User::findOrFail($request->get('id')); //$id
            foreach($piloto->movimentosPiloto as $movimento){
                if(!in_array(date('Y',strtotime($movimento->data)),$anos)){
                    array_push($anos, date('Y',strtotime($movimento->data)));
                }
            }

            $temposAno = [];
            $sum = 0;
            $movimentos = $piloto->movimentosPiloto;

            foreach ($anos as $ano) {
                $sum = 0;
                foreach ($movimentos as $movimento) {
                    if((date('Y',strtotime($movimento->data))==$ano)){
                        $sum = $sum + $movimento->tempo_voo;
                    }
                }
                array_push($temposAno, $sum);
            }

    
            for($i=0; $i < count($anos); $i++) {
                $pilotYearTable->addRow([
                        $anos[$i], $temposAno[$i]
                ]);     
            }

            
            \Lava::AreaChart('Piloto/Ano', $pilotYearTable);
            echo \Lava::render('AreaChart', 'Piloto/Ano', 'pilot-year-chart');
            return view("movimentos.statistics", compact("title", "aeronaves", "pilotos", "titleAeronave", "titlePiloto"));

        }

        return view("movimentos.statistics", compact("title", "aeronaves", "pilotos", "titleAeronave", "titlePiloto"));

        
    }

    public function pendentes(){
        $title = "Assuntos pendentes";
        $movimentosConflitos = Movimento::whereNotNull('tipo_conflito')->paginate(15);
        $movimentosConfirmar = Movimento::where('confirmado',0)->paginate(15);
        $licencasConfirmar = User::where('licenca_confirmada',0)->paginate(15);
        $certificadosConfirmar = User::where('certificado_confirmado',0)->paginate(15);

        return view("movimentos.pendentes-list", compact("title","movimentosConflitos", "movimentosConfirmar","licencasConfirmar", "certificadosConfirmar"));
    }

    
        
}
