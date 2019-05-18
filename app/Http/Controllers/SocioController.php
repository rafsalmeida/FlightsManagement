<?php

namespace App\Http\Controllers;

use App\Socio;
use App\TipoLicenca;
use App\ClasseCertificado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreSocio;

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
        $tipos_licenca = TipoLicenca::pluck('nome','code');
        $classes_certificado = ClasseCertificado::pluck('nome','code');
        return view("socios.add", compact("title","tipos_licenca","classes_certificado"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSocio $request)
    {
        if ($request->has("cancel")) {
            return redirect()->action("SocioController@index");
        }

        $socio = $request->validated();

        //$socio->password = Hash::make($request->data_nascimento);

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
        $tipos_licenca = TipoLicenca::pluck('nome','code');
        $classes_certificado = ClasseCertificado::pluck('nome','code');
        return view("socios.edit", compact("title", "socio","tipos_licenca","classes_certificado"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSocio $request,  $id)
    {
        //validar e dar store na bd
        if ($request->has("cancel")) {
            return redirect()->action("SocioController@index");
        }
        $socio = $request->validated();

        $socioModel = Socio::findOrFail($id);
        $socioModel->fill($socio);
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
