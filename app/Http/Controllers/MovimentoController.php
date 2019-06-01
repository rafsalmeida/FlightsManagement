<?php

namespace App\Http\Controllers;

use App\Movimento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\AeronaveValor;
use App\User;
use App\Aeronave;
use App\Aerodromo;
use App\Policies\UserPolicy;
use App\Http\Requests\StoreMovimento;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


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
        $this->middleware('passwd_changed');
        $this->middleware('deleted');

    }

    public function confirm(Request $request){
        $checkboxes = $request->input('confirmar');

        $confirmados=0;
        $naoConfirmados = 0;

        foreach ($checkboxes as $id) {
            $movimento = Movimento::findOrFail($id);
            if ($movimento->confirmado == 0) {
                $movimento['confirmado'] = 1;
                $movimento->save();
                $aeronave = $movimento->getAeronave;
                if($aeronave->conta_horas < $movimento->conta_horas_fim){
                    $aeronave->conta_horas = $movimento->conta_horas_fim;
                    $aeronave->save();
                }
                $confirmados++;
            }
            else{
                $naoConfirmados++;
            }
        }

        if ($naoConfirmados != 0 && $confirmados == 0) {
            return redirect('movimentos')->with('success', 'O(s) movimento(s) que estava a tentar confirmar já se encontrava confirmado(s)');
        }
        elseif ($naoConfirmados != 0) {
            return redirect('movimentos')->with('success', 'Algun(s) do(s) movimento(s) que tentou confirmar já estavam confirmado(s)');
        }
        else{
            return redirect('movimentos')->with('success', 'Movimento(s) confirmado(s) com sucesso');
        }
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
            $piloto_id = $request->get('piloto'); 
            $query->where('piloto_id', $piloto_id); 
        }

        if ($request->filled('instrutor') && $request['instrutor'] != null) {
            $instrutor_id = $request->get('instrutor');
            $query->where('instrutor_id', $instrutor_id); 
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

        if(Auth::user()->can('createMovimento', Auth::user())){
            if ($request->filled('meus_movimentos') && $request['meus_movimentos'] != null) {
                $id = Auth::user()->id;
                $query->where('piloto_id', $id)->orWhere('instrutor_id', $id);
            }
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
        $this->authorize('createMovimento', Auth::user());
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

        $this->authorize('createMovimento', Auth::user());


        $movimento = new Movimento();
       
        $request->validated();


        $hora_descolagem = $request->data.' '.$request->hora_descolagem;



        $hora_aterragem = $request->data.' '.$request->hora_aterragem;



        $movimento->fill($request->all());

        $diferenca = $movimento->conta_horas_fim - $movimento->conta_horas_inicio;
        $resto = $diferenca % 10;
        $decima = intdiv($diferenca,10);
        $posicao_decima = $movimento->getAeronave->getMinutos(10);
        $tempo_voo = ($posicao_decima->minutos*$decima);
        $custo = ($posicao_decima->preco*$decima);
        if($resto>0){
            $posicao_resto = $movimento->getAeronave->getMinutos($resto);
            $tempo_voo += $posicao_resto->minutos;
            $custo += $posicao_resto->preco;
        }
        if($tempo_voo!=$request->tempo_voo || $custo != $request->perco_voo){
            return redirect()->back()->withInput($request->all())->with('success', 'To do or not to do, don\'t try! Tempo/custo alterados indevidamente');
        }
        $request->request->add([
            'num_licenca_piloto' => $movimento->piloto->num_licenca,
            'validade_licenca_piloto' => $movimento->piloto->validade_licenca,
            'tipo_licenca_piloto' => $movimento->piloto->tipo_licenca,
            'num_certificado_piloto' => $movimento->piloto->num_certificado,
            'validade_certificado_piloto' => $movimento->piloto->validade_certificado,
            'classe_certificado_piloto' => $movimento->piloto->classe_certificado,
            'hora_aterragem' => date('Y-m-d h:i:s',strtotime($hora_aterragem)),
            'hora_descolagem' => date('Y-m-d h:i:s',strtotime($hora_descolagem)),
            'confirmado' => 0,
        ]);

        //dd($request);

        if($request->natureza == 'I'){
            $request->request->add([
            'num_licenca_instrutor' => $movimento->instrutor->num_licenca,
            'validade_licenca_instrutor' => $movimento->instrutor->validade_licenca,
            'tipo_licenca_instrutor' => $movimento->instrutor->tipo_licenca,
            'num_certificado_instrutor' => $movimento->instrutor->num_certificado,
            'validade_certificado_instrutor' => $movimento->instrutor->validade_certificado,
            'classe_certificado_instrutor' => $movimento->instrutor->classe_certificado,


            ]);
        }

        $movimento->fill($request->all());

        $contaHoras = $movimento->getAeronave->movimentos->max('conta_horas_fim');

        if($request->conta_horas_inicio != $contaHoras && $request->hasConflito == 0){
            $request->request->add(['hasConflito' => "1"]);
            if($request->conta_horas_inicio > $contaHFinalMovAnt){
                    \Session::flash('unsuccess','Aviso! Conflito de conta-horas do tipo buraco');
            } else if($request->conta_horas_inicio < $contaHFinalMovAnt){
                    \Session::flash('danger','Aviso! Conflito de conta-horas do tipo sobreposição');
            } else if ($request->conta_horas_fim < $contaHInicialMovSeg){
                    \Session::flash('unsuccess','Aviso! Conflito de conta-horas do tipo buraco');
            } else if ($request->conta_horas_fim > $contaHInicialMovSeg){
                    \Session::flash('danger','Aviso! Conflito de conta-horas do tipo sobreposição');
            }

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
        $movimento = Movimento::findOrFail($id);

        if(Auth::user()->can('updateMovimento', $movimento->piloto) || Auth::user()->can('updateMovimento', $movimento->instrutor)){
            $title = "Editar Movimento";

            if($movimento->confirmado == 1){
                return redirect()->action("MovimentoController@index")            
                     ->with("unsuccess", "Movimento confirmado não pode ser alterado.");
            }
            $aerodromos = Aerodromo::pluck('nome','code');
            $aerodromos[''] = "Escolha um aerodromo";
            if(Auth::user()->direcao == 1){
                $aeronaves = Aeronave::all()->pluck('matricula','matricula');
            }
            else{
                $aeronaves = Auth::user()->aeronave->pluck('matricula', 'matricula');
            }
            $aeronaves[''] = "Escolha uma aeronave";
            return view("movimentos.edit", compact("movimento","title", "aerodromos", "aeronaves"));
        } else {
            throw new AccessDeniedHttpException('Unauthorized.');
        }


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
        $movimento = Movimento::findOrFail($id);

        if(Auth::user()->can('updateMovimento', $movimento->piloto) || Auth::user()->can('updateMovimento', $movimento->instrutor)){


            if ($request->has('confirmar')) {
                $request['confirmado'] = 1;
                $aeronave = $movimento->getAeronave;
                if($aeronave->conta_horas < $request->conta_horas_fim){
                    $aeronave->conta_horas = $request->conta_horas_fim;
                    $aeronave->save();
                }
            }
            else{
                $request['confirmado'] = 0;
            }

            $request->validated();

            $hora_descolagem = $request->data.' '.$request->hora_descolagem;



            $hora_aterragem = $request->data.' '.$request->hora_aterragem;



            $request->request->add([
                'num_licenca_piloto' => $movimento->piloto->num_licenca,
                'validade_licenca_piloto' => $movimento->piloto->validade_licenca,
                'tipo_licenca_piloto' => $movimento->piloto->tipo_licenca,
                'num_certificado_piloto' => $movimento->piloto->num_certificado,
                'validade_certificado_piloto' => $movimento->piloto->validade_certificado,
                'classe_certificado_piloto' => $movimento->piloto->classe_certificado,
                'hora_descolagem' => date('Y-m-d h:i:s',strtotime($hora_descolagem)),
                'hora_aterragem' => date('Y-m-d h:i:s',strtotime($hora_aterragem)),
            ]);

            


            if($request->natureza == 'I'){
                $request->request->add([
                'num_licenca_instrutor' => $movimento->instrutor->num_licenca,
                'validade_licenca_instrutor' => $movimento->instrutor->validade_licenca,
                'tipo_licenca_instrutor' => $movimento->instrutor->tipo_licenca,
                'num_certificado_instrutor' => $movimento->instrutor->num_certificado,
                'validade_certificado_instrutor' => $movimento->instrutor->validade_certificado,
                'classe_certificado_instrutor' => $movimento->instrutor->classe_certificado,

                ]);
            }

            $movimento->fill($request->all());

            $diferenca = $movimento->conta_horas_fim - $movimento->conta_horas_inicio;
            $resto = $diferenca % 10;
            $decima = intdiv($diferenca,10);
                $posicao_decima = $movimento->getAeronave->getMinutos(10);
                $tempo_voo = ($posicao_decima->minutos*$decima);
                $custo = ($posicao_decima->preco*$decima);
            if($resto > 0){
                $posicao_resto = $movimento->getAeronave->getMinutos($resto);
                $tempo_voo += $posicao_resto->minutos;
                $custo += $posicao_resto->preco;
            }
            if($tempo_voo!=$request->tempo_voo || $custo != $request->preco_voo){
                return redirect()->back()->withInput($request->all())->with('success', 'To do or not do, don\'t try! Tempo/custo alterados indevidamente');
            }
            //--- VER PROBLEMAS COM CONFLITOS TENDO EM CONTA O MOVIMENTO ANTERIOR ----
            $contaHFinalMovAnt = $movimento->getAeronave->movimentos->where('conta_horas_fim','<=', $movimento->conta_horas_inicio)->where('id','!=',$movimento->id)->max('conta_horas_fim');


            //--- VER PROBLEMAS COM CONFLITOS TENDO EM CONTA O MOVIMENTO SEGUINTE ----
            $contaHInicialMovSeg = $movimento->getAeronave->movimentos->where('conta_horas_inicio','>=', $movimento->conta_horas_fim)->where('id','!=',$movimento->id)->min('conta_horas_inicio');
            

            if(( $request->hasConflito == 0 && $request->conta_horas_inicio != $contaHFinalMovAnt ) || ($request->hasConflito == 0 && $contaHInicialMovSeg != null &&$request->conta_horas_fim != $contaHInicialMovSeg ) ){
                if($request->conta_horas_inicio > $contaHFinalMovAnt){
                    \Session::flash('unsuccess','Aviso! Conflito de conta-horas do tipo buraco');
                } else if($request->conta_horas_inicio < $contaHFinalMovAnt){
                    \Session::flash('danger','Aviso! Conflito de conta-horas do tipo sobreposição');
                } else if ($request->conta_horas_fim < $contaHInicialMovSeg){
                    \Session::flash('unsuccess','Aviso! Conflito de conta-horas do tipo buraco');
                } else if ($request->conta_horas_fim > $contaHInicialMovSeg){
                    \Session::flash('danger','Aviso! Conflito de conta-horas do tipo sobreposição');
                }


                $request->request->add(['hasConflito' => "1"]);
                return redirect()->back()->withInput($request->all());

            }

            $movimento->fill($request->all());
            if($request->hasConflito == 1){


                if($request->conta_horas_inicio > $contaHFinalMovAnt){
                    $request['tipo_conflito'] = 'B';
                } else if($request->conta_horas_inicio < $contaHFinalMovAnt){
                    $request['tipo_conflito'] = 'S';
                } else if ($request->conta_horas_fim < $contaHInicialMovSeg){
                    $request['tipo_conflito'] = 'B';
                } else if ($request->conta_horas_fim > $contaHInicialMovSeg){
                    $request['tipo_conflito'] = 'S';
                }

            }


            
            $movimento->fill($request->all());


            $movimento->save();
            return redirect()
                    ->action('MovimentoController@index')
                    ->with('success', 'Movimento editada corretamente');
        } else {
            throw new AccessDeniedHttpException('Unauthorized.');

        }

        

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
        if(Auth::user()->can('updateMovimento', $movimento->piloto) || Auth::user()->can('updateMovimento', $movimento->instrutor)){
            if($movimento->confirmado == 0){
                $movimento->delete();
            } else {
                return redirect()->action("MovimentoController@index")->with('unsuccess', 'Movimento Confirmado. Impossível Apagar');
            }

            return redirect()->action("MovimentoController@index")->with('success', 'Movimento apagado corretamente');
            }

    }




private function agrupar($movimentos,$tipo){
    return $movimentos->groupBy(DB::raw("DATE_FORMAT(data,'%".$tipo."')"))->select(DB::raw("SUM(tempo_voo) as horas,DATE_FORMAT(data,'%".$tipo."') as tipo"))->orderBy(DB::raw("DATE_FORMAT(data,'%".$tipo."')"))->pluck('horas','tipo')->toArray();
}
    public function statistics(Request $request){
        /*
         SELECT SUM(tempo_voo)
        FROM movimentos
        WHERE aeronave='CS-AQN'
        GROUP BY DATE_FORMAT(data,'%m');
        //$tempos = $aeronave->movimentos()->groupBy(DB::raw("DATE_FORMAT(data,'%Y')"))->select(DB::raw("SUM(tempo_voo) as horas,DATE_FORMAT(data,'%Y') as ano"))->pluck('horas','ano')->toArray();
         */
        
        $titleAeronave = null;
        $titlePiloto = null;
        $title="Estatísticas dos Movimentos";

        $aeronavesAno = Aeronave::paginate(15, ['*'], 'aeronavesAno');
        $aeronavesMes= Aeronave::paginate(15, ['*'], 'aeronavesMes');
        $pilotosAno = User::getPilotos()->paginate(15, ['*'], 'pilotosAno');
        $pilotosMes = User::getPilotos()->paginate(15, ['*'], 'pilotosMes');

        $anos  = DB::table("movimentos")->select(DB::raw("DISTINCT(DATE_FORMAT(data,'%Y')) as data"))->pluck('data','data')->toArray();
        $meses  = DB::table("movimentos")->select(DB::raw("DISTINCT(DATE_FORMAT(data,'%m')) as data"))->pluck('data','data')->toArray();
        asort($meses);

        $aeronavesAno->map(function ($value, $key) {
            $value['estatistica'] = $this->agrupar($value->movimentos(),"Y");
            return $value;
        });
        $aeronavesMes->map(function ($value, $key) {
            $value['estatistica'] = $this->agrupar($value->movimentos(),"m");
            return $value;
        });
        $pilotosAno->map(function ($value, $key) {
            $value['estatistica'] = $this->agrupar($value->movimentosPiloto(),"Y");
            return $value;
        });
        $pilotosMes->map(function ($value, $key) {
            $value['estatistica'] = $this->agrupar($value->movimentosPiloto(),"m");
            return $value;
        });

        $aeronaves = Aeronave::paginate(15, ['*'], 'aeronaves');
        $pilotos = User::getPilotos()->paginate(15, ['*'], 'pilotos');
        if(!$request->filled("matricula") && !$request->filled("id")){
            return view("movimentos.statistics", compact("title", "aeronaves", "pilotos", "titleAeronave", "titlePiloto","aeronavesAno","aeronavesMes","pilotosAno","pilotosMes","anos","meses"));
        }
        /************* HORAS POR ANO *************************/

            $yearTable = \Lava::DataTable();  
            $yearTable->addStringColumn('Ano')
                              ->addNumberColumn('Horas');
        if($request->filled('matricula')) {
            $titleAeronave = "Aeronave " . $request->get('matricula');
            $aeronave = Aeronave::findOrFail($request->get('matricula')); 
            $tempos = $this->agrupar($aeronave->movimentos(), "Y");
            $titleG = 'Aeronave/Ano';

        }elseif($request->filled('id')) {
            $piloto = User::findOrFail($request->get('id')); 
            $titlePiloto="Piloto ".$request->get('id');
            $tempos = $this->agrupar($piloto->movimentosPiloto(), "Y");
            $titleG = 'Piloto/Ano';
        }
        foreach ($tempos as $ano => $tempo) {
            $yearTable->addRow([
                $ano, number_format($tempos[$ano]/60, 2,'.','')
            ]);
        }
            \Lava::AreaChart($titleG, $yearTable);
            echo \Lava::render('AreaChart', $titleG, 'year-chart');


        /************* HORAS POR MES ********************/

        $monthTable = \Lava::DataTable();  
        $monthTable->addStringColumn('Mês')
            ->addNumberColumn('Horas');
        if($request->filled('matricula')) {
            $titleAeronave = "Aeronave " . $request->get('matricula');
            $aeronave = Aeronave::findOrFail($request->get('matricula')); 
            $tempos = $this->agrupar($aeronave->movimentos(), "m");
            $titleG = 'Aeronave/Mes';

        }elseif($request->filled('id')) {
            $piloto = User::findOrFail($request->get('id')); 
            $titlePiloto="Piloto ".$request->get('id');
            $tempos = $this->agrupar($piloto->movimentosPiloto(), "m");
            $titleG = 'Piloto/Mes';
        }
        foreach ($tempos as $mes => $tempo) {
            $monthTable->addRow([
                $mes, number_format($tempos[$mes]/60, 2,'.','')
            ]);
        }
        \Lava::AreaChart($titleG, $monthTable);
        echo \Lava::render('AreaChart', $titleG, 'month-chart');


        



        return view("movimentos.statistics", compact("title", "aeronaves", "pilotos", "titleAeronave", "titlePiloto","aeronavesAno","aeronavesMes","pilotosAno","pilotosMes","anos","meses"));
    }

     public function pendentes(){
        $title = "Assuntos pendentes";

        $licencasValidade = User::where('validade_licenca','<=',Carbon::now()->addDays(60))->orderBy('validade_licenca','ASC')->paginate(15, ['*'], 'licencasValidade');
        $certificadosValidade = User::where('validade_certificado','<=',Carbon::now()->addDays(60))->orderBy('validade_certificado','ASC')->paginate(15, ['*'], 'certificadosValidade');
        $movimentosConflitos = Movimento::whereNotNull('tipo_conflito')->paginate(15, ['*'], 'movimentosConflitos');
        $movimentosConfirmar = Movimento::where('confirmado',0)->paginate(15, ['*'], 'movimentosConfirmar');
        $licencasConfirmar = User::where('licenca_confirmada',0)->paginate(15, ['*'], 'licencasConfirmar');
        $certificadosConfirmar = User::where('certificado_confirmado',0)->paginate(15, ['*'], 'certificadosConfirmar');

        return view("movimentos.pendentes-list", compact("title","movimentosConflitos", "movimentosConfirmar","licencasConfirmar", "certificadosConfirmar", "licencasValidade","certificadosValidade"));
    }

    
        
}
