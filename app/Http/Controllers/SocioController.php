<?php

namespace App\Http\Controllers;

use App\Socio;
use App\TipoLicenca;
use App\ClasseCertificado;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreSocio;
use Illuminate\Support\Facades\Auth;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('direcao', ['only' => ['create','store','destroy','mudarEstado']]);

        $this->middleware('verified');

    }
    
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

        //$socio = $request->validated();
        
        $socio = new Socio();
        $request->validated();
        $socio->fill($request->all());
        if(! is_null($request['file_foto'])) {
            $image = $request->file('file_foto');
            $name = time().'.'.$image->getClientOriginalExtension();
            $path = $request->file('file_foto')->storeAs('public/fotos', $name);
            $socio->foto_url = $name;
        }
        $socio->password = Hash::make($request->data_nascimento);
        $socio->save();

        //Socio::create($socio);
        

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

        $socio = Socio::findOrFail($id);

        if(Auth::user()->can('view',$socio)){
            $title = "Editar Sócio";
            $tipos_licenca = TipoLicenca::pluck('nome','code');
            $classes_certificado = ClasseCertificado::pluck('nome','code');
            return view("socios.edit", compact("title", "socio","tipos_licenca","classes_certificado"));
        } else {
            return redirect()
                    ->action("SocioController@index")
                    ->with("success", "Não tem permissões para efetuar essa ação.");
        }

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
        $socio = Socio::findOrFail($id);
        if(Auth::user()->can('update', $socio)){


            if(Auth::user()->direcao){

                $request = $request->all();

            } else if(Auth::user()->tipo_socio == 'P'){
                $request = $request->only(['nome_informal', 'name', 'email','foto_url','data_nascimento','nif','telefone','endereco','num_licenca','tipo_licenca','validade_licenca','num_certificado','classe_certificado','validade_certificado']);
            } else {

                $request = $request->only(['nome_informal', 'name', 'email','foto_url','data_nascimento','nif','telefone','endereco']);
            }


            if ($request->has("cancel")) {
                return redirect()->action("SocioController@index");
            }

            $request->validated();

            if(! is_null($request['file_foto'])) {
                $image = $request->file('file_foto');
                $name = time().'.'.$image->getClientOriginalExtension();
                $socio->foto_url = $name;
                $path = $request->file('file_foto')->storeAs('public/fotos', $name);
                // OR
                // Storage::putFileAs('public/img', $image, $name);
            }

            $socio->fill($request->all());
            $socio->save();
            return redirect()
                    ->action("SocioController@index")
                    ->with("success", "Sócio editado corretamente");
                
     
        } 

            
        



       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Socio::destroy($id);
        return redirect()->action("SocioController@index")->with('success', 'Sócio apagado corretamente');
    }

    public function mudarEstado($id){

        $socio = Socio::findOrFail($id);
        if($socio->ativo == 1){
            $socio->ativo = 0;
        } else {
            $socio->ativo = 1;
        }

        $socio->save();
        return redirect()->action("SocioController@index")->with('success', 'Estado alterado corretamente');
    }
}
