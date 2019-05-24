<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aeronave;
use App\AeronaveValor;
use App\Http\Requests\StoreAeronave;


class AeronaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('direcao', ['only' => ['create','store','edit','update','destroy']]);
        $this->middleware('ativo');
        $this->middleware('verified');

    }

    public function index()
    {
        $aeronaves = Aeronave::All();
        $title = "Lista de Aeronaves";

        return view('aeronaves.list', compact('aeronaves','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $title = "Adicionar Aeronave";
        return view('aeronaves.add', compact('title'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAeronave $request)
    {


        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }

        $aeronave = $request->validated();

        

        $aeronaveCriada = Aeronave::create($aeronave); ////
        $valor = array();
        for($i=0; $i<10;$i++){
            $valor['matricula'] = $aeronaveCriada->matricula;
            $valor['unidade_conta_horas'] = $i+1;
            $valor['minutos'] = $aeronave['tempos'][$i];
            $valor['preco'] =$aeronave['precos'][$i];
            AeronaveValor::create($valor);
        }
        return redirect()
                 ->action('AeronaveController@index')            
                 ->with('success', 'Aeronave adicionada corretamente');
                
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id //
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //ir buscar a aeronave com um certo id
        //chamar o form de edit passando a aeronave
        

        $title = "Editar Aeronave";

        $aeronave = Aeronave::findOrFail($id);
        $valores = $aeronave->valores;
        return view('aeronaves.edit', compact('title', 'aeronave', 'valores'));
        
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAeronave $request, $id)
    {

        //validar e dar store na bd
        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }
        $dadosAGravar = $request->validated();
        $aeronave = Aeronave::findOrFail($id);
        $aeronave->fill($dadosAGravar);
        $aeronave->save();

        $valores= $aeronave->valores;
   
      
        
        
        foreach ( $valores as $valor) {
        
            $valor->minutos = $dadosAGravar['tempos'][$valor->unidade_conta_horas];
            $valor->preco =$dadosAGravar['precos'][$valor->unidade_conta_horas];
    
            $valor->save();
          
        }
           
        return redirect()
                ->action('AeronaveController@index')
                ->with('success', 'Aeronave editada corretamente');

        

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    }
    public function destroy($id)
    {
        $aeronave = Aeronave::findOrFail($id);
        $movimentos = $aeronave->movimentos;

        if(count($movimentos)==0){
            $aeronave->forceDelete();
            $valores = $aeronave->valores;
         
            foreach ($valores as $valor) {
                $valor->delete();
            }
        }else{
            $aeronave->delete();
        }
        return redirect()->action('AeronaveController@index')
                         ->with('success', 'Aeronave apagada corretamente');;
    }
}
