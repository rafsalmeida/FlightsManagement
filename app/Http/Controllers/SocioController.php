<?php

namespace App\Http\Controllers;

use App\Socio;
use App\TipoLicenca;
use Illuminate\Http\Request;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socios = Socio::paginate(15);
        $title = "Lista de Sócios";
        return view("socios.list", compact("socios","title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Adicionar Sócio";
        return view("socios.add", compact("title"));
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
            return redirect()->action("SocioController@index");
        }

        $socio = $request->validate([
        "num_socio" => "required|integer|max:11",
        "name" => "required|string|alpha|max:255",
        "nome_informal" => "required|string|alpha_dash|max:40",
        "email" => "required|email|max:255",
        "nif" => "digits:9|nullable",
        "data_nascimento" => "required|date",
        "telefone" => "string|max:20|nullable",
        "endereco" => "string|nullable",
        "num_licenca" => "string|size:30|nullable",
        "validade_licenca" => "date|nullable",
        "num_certificado" => "string|size:30|nullable",
        "validade_certificado" => "date|nullable",
        ]);

        Socio::create($socio);
        return redirect()
                 ->action("SocioController@index")            
                 ->with("success", "Sócio adicionado corretamente");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function show(Socio $socio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Editar Sócio";
        $socio = Socio::findOrFail($id);
        $tipos_licenca = TipoLicenca::all();
        return view("socios.edit", compact("title", "socio","tipos_licenca"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //validar e dar store na bd
        if ($request->has("cancel")) {
            return redirect()->action("SocioController@index");
        }
        $socio = $request->validate([
        "num_socio" => "required|integer|max:11",
        "name" => "required|string|alpha|max:255",
        "nome_informal" => "required|string|alpha_dash|max:40",
        "email" => "required|email|max:255",
        "nif" => "digits:9",
        "data_nascimento" => "required|date",
        "telefone" => "string|max:20",
        "endereco" => "string|nullable",
        "num_licenca" => "string|size:30|nullable",
        "validade_licenca" => "date|nullable",
        "num_certificado" => "string|size:30|nullable",
        "validade_certificado" => "date|nullable",
        ]);
        $socioModel = Socio::findOrFail($id);
        $socioModel->fill($aeronave);
        $socioModel->save();
        return redirect()
                ->action("SocioController@index")
                ->with("success", "Sócio editado corretamente");

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Socio $socio)
    {
        Socio::destroy($id);
        return redirect()->action("SocioController@index");
    }
}
