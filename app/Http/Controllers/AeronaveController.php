<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aeronave;
use App\AeronaveValor;
use App\AeronavePilotos;
use App\Http\Requests\StoreAeronave;
use App\User;

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

    public function index(Request $request)
    {
        $title = "Lista de Aeronaves";

        $query = Aeronave::limit(10);
            if ($request->filled('matricula') && $request['matricula'] != null) {
                $query->where('matricula', $request->get('matricula'));
            }

            if ($request->filled('marca') && $request['marca'] != null) {
                $marca = $request->get('marca');
                $query->where('marca', 'like', "%$marca%");
            }

            if ($request->filled('modelo') && $request['modelo'] != null) {
                $modelo = $request->get('modelo');
                $query->where('modelo', 'like', "%$modelo%");
            }
            if ($request->filled('num_lugares') && $request['num_lugares'] != null) {
                $num_lugares = $request->get('num_lugares');
                $query->where('num_lugares', 'like', "%$num_lugares%");
            }

            $aeronaves = $query->paginate(15);
        return view('aeronaves.list', compact('aeronaves', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $title = "Adicionar Aeronave";
        $aeronave = new Aeronave();
        return view('aeronaves.add', compact('title', 'aeronave'));

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

        //$aeronave = $request->validated();

        

        $aeronave = new Aeronave();
        $aeronave->fill($request->all());
        $aeronave->save();////
       
        for($i=1; $i<11;$i++){
            $aeronavevalor = new AeronaveValor();
            $aeronavevalor->matricula = $aeronave->matricula;
            $aeronavevalor->unidade_conta_horas = $i;
            $aeronavevalor->minutos = $request->tempos[$i];
            $aeronavevalor->preco =$request->precos[$i];

            $aeronavevalor->save();
            


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
            $valores = $aeronave->valores;
            $aeronave->forceDelete();
            
           
            foreach ($valores as $valor) {
                $valor->delete();
            }
        }else{
            $aeronave->delete();
        }
        return redirect()->action('AeronaveController@index')
                         ->with('success', 'Aeronave apagada corretamente');
    }


    public function getJson($id){
        $aeronave = Aeronave::findOrFail($id);

        //dd(response()->json($aeronave->valores->makeHidden(['id', 'matricula'])));
        return response()
                ->json($aeronave->valores->makeHidden(['id', 'matricula']));

    }


}
