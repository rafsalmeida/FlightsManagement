<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aeronave;
use App\AeronaveValor;

class AeronaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(Request $request)
    {
        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }

        $aeronave = $request->validate([
        'matricula' => 'unique:aeronaves|required|string|size:8',
        'marca' => 'required|string|max:40',
        'modelo' => 'required|string|max:40',
        'num_lugares' => 'required|integer|max:11',
        'conta_horas' => 'required|integer',
        'preco_hora' => 'required|regex:/^-?[0-9]{1,13}+(?:\.[0-9]{1,2})?$/',
        'minuto' => 'required|integer|max:60',///acrescentei
        ], [ // Custom Messages
        'preco_hora.regex' => 'Formato preço/hora: ex - xxx.xx (número inteiro até 13 digitos)',
        'marca' => 'Marca deve ser obrigatória e inferior 40 carateres',
        ]);

        Aeronave::create($aeronave);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //ir buscar a aeronave com um certo id
        //chamar o form de edit passando a aeronave
        //
        $title = "Editar Aeronave";
        $aeronave = Aeronave::findOrFail($id);
        $valores = AeronaveValor::where('matricula', $aeronave->matricula)->get();
        return view('aeronaves.edit', compact('title', 'aeronave', 'valores'));
        
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validar e dar store na bd
        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }

        $aeronave = $request->validate([
        'matricula' => 'unique:aeronaves|required|string|size:8',
        'marca' => 'required|string|max:40',
        'modelo' => 'required|string|max:40',
        'num_lugares' => 'required|integer|max:11',
        'conta_horas' => 'required|integer|max:11',
        'preco_hora' => 'required|regex:/^-?[0-9]{1,13}+(?:\.[0-9]{1,2})?$/'
        ], [ // Custom Messages
        'preco_hora.regex' => 'Formato preço/hora: ex - xxx.xx (número inteiro até 13 digitos)',
        'marca' => 'Marca deve ser obrigatória e inferior 40 carateres',
        ]);
        $aeronaveModel = Aeronave::findOrFail($id);
        $aeronaveModel->fill($aeronave);
        $aeronaveModel->save();
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
        Aeronave::destroy($id);
        return redirect()->action('AeronaveController@index');
    }
}
