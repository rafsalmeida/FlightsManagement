<?php

namespace App\Http\Controllers;

use App\User;
use App\TipoLicenca;
use App\ClasseCertificado;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreSocio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

        $this->middleware('ativo');

        $this->middleware('passwd_changed');


    }
    
    public function index(Request $request)
    {



        $title = "Lista de Sócios";

            $query = User::limit(10);
            if ($request->filled('num_socio') && $request['num_socio'] != null) {
                $query->where('num_socio', $request->get('num_socio'));
            }

            if ($request->filled('nome_informal') && $request['nome_informal'] != null) {
                $nome = $request->get('nome_informal');
                $query->where('nome_informal', 'like', "%$nome%");
            }

            if ($request->filled('email') && $request['email'] != null) {
                $email = $request->get('email');
                $query->where('email', 'like', "%$email%");
            }

            if ($request->filled('tipo') && $request['tipo'] != null) {
                $query->where('tipo_socio', $request->get('tipo'));
            }

            if ($request->filled('direcao') && $request['direcao'] != null) {
                $query->where('direcao', $request->get('direcao'));
            }

        if(Auth::user()->can('viewSociosDesativados', Auth::user())){

            if ($request->filled('quotas_pagas') && $request['quotas_pagas'] != null) {
                $query->where('quota_paga', $request->get('quotas_pagas'));
            }

            if ($request->filled('ativo') && $request['ativo'] != null) {
                $query->where('ativo', $request->get('ativo'));
            } 
        }

        if(Auth::user()->can('viewSociosDesativados', Auth::user())){
            $socios =  $query->paginate(15);

        } else {
            $socios = $query->where('ativo',1)->paginate(15);
                        
        }

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
        $tipos_licenca[''] = 'Escolha uma licença';
        $classes_certificado = ClasseCertificado::pluck('nome','code');
        $classes_certificado[''] = 'Escolha um certificado';
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
        
        $socio = new User();

        $request->ativo = 0;
        $request->validated();
        $socio->fill($request->all());
        if(! is_null($request['file_foto'])) {
            
            $image = $request->file('file_foto');
            $name = time().'.'.$image->getClientOriginalExtension();
            $path = $request->file('file_foto')->storeAs('public/fotos', $name);
            $socio->foto_url = $name;
        }

        if(! is_null($request['file_licenca'])) {
            $fileLicenca = $request->file('file_licenca');
            $name = 'licenca_'.$request->id.'.'.$fileLicenca->getClientOriginalExtension();
            $path = $request->file('file_licenca')->storeAs('docs_piloto', $name);
        }

        if(! is_null($request['file_certificado'])) {
            $fileCertificado = $request->file('file_certificado');
            $name = 'certificado_'.$request->id.'.'.$fileCertificado->getClientOriginalExtension();
            $path = $request->file('file_certificado')->storeAs('docs_piloto', $name);
        }

        $socio->password = Hash::make($request->data_nascimento);
        $socio->save();
        $socio->sendEmailVerificationNotification();
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

        $socio = User::findOrFail($id);

        if(Auth::user()->can('view',$socio)){
            $title = "Editar Sócio";
            $tipos_licenca = TipoLicenca::pluck('nome','code');
            $tipos_licenca[''] = 'Escolha uma licença';
            $classes_certificado = ClasseCertificado::pluck('nome','code');
            $classes_certificado[''] = 'Escolha um certificado';
            return view("socios.edit", compact("title", "socio","tipos_licenca","classes_certificado"));
        } else {

            throw new AccessDeniedHttpException('Unauthorized.');
           /* return redirect()
                    ->action("SocioController@index")
                    ->with("success", "Não tem permissões para efetuar essa ação.");*/
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
        $socio = User::findOrFail($id);


        if ($request->has("cancel")) {
            return redirect()->action("SocioController@index");
        }


        $request->validated();


        if(Auth::user()->can('update', $socio) && Auth::user()->can('view', $socio)){

            if(Auth::user()->direcao){
                $socio->fill($request->all());

            } else if(Auth::user()->tipo_socio == 'P'){
                $socio->fill($request->only(['nome_informal', 'name', 'email','foto_url','data_nascimento','nif','telefone','endereco','num_licenca','tipo_licenca','validade_licenca','num_certificado','classe_certificado','validade_certificado']));
            } else {
                $socio->fill($request->only(['nome_informal', 'name', 'email','foto_url','data_nascimento','nif','telefone','endereco']));
            }


            if(! is_null($request['file_foto'])) { 
                if(isset($socio->foto_url)){
                    Storage::delete('public/fotos/'.$socio->foto_url);
                }
                $image = $request->file('file_foto');
                $name = time().'.'.$image->getClientOriginalExtension();
                $socio->foto_url = $name;
                $path = $request->file('file_foto')->storeAs('public/fotos', $name);
                // OR
                // Storage::putFileAs('public/img', $image, $name);
            }

            if(! is_null($request['file_licenca'])) {
                $fileLicenca = $request->file('file_licenca');
                $name = 'licenca_'.$request->id.'.'.$fileLicenca->getClientOriginalExtension();
                $path = $request->file('file_licenca')->storeAs('docs_piloto', $name);
            }

            if(! is_null($request['file_certificado'])) {
                $fileCertificado = $request->file('file_certificado');
                $name = 'certificado_'.$request->id.'.'.$fileCertificado->getClientOriginalExtension();
                $path = $request->file('file_certificado')->storeAs('docs_piloto', $name);
            }
            $socio->save();
             if(Auth::user()->isPiloto()) {
                if ($socio->wasChanged(['num_licenca', 'tipo_licenca', 'validade_licenca'])) {
                    $socio->licenca_confirmada = 0;
                    $socio->save();
                }
                if ($socio->wasChanged(['num_certificado', 'classe_certificado', 'validade_certificado'])) {
                    $socio->certificado_confirmado = 0;
                    $socio->save();
                }
            }
            return redirect()
                    ->action("SocioController@index")
                    ->with("success", "Sócio editado corretamente");
                
     
        } else {
            throw new AccessDeniedHttpException('Unauthorized.');
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
        $socio = User::findOrFail($id);
        $movimentos = $socio->movimentos;
        if(($socio->instrutor || $socio->tipo_socio == 'P') && count($movimentos) > 0){
            $socio->delete();
        } else {
            $socio->forceDelete();
        }

        return redirect()->action("SocioController@index")->with('success', 'Sócio apagado corretamente');
    }

    public function mudarEstado($id){

        $socio = User::findOrFail($id);
        if($socio->ativo == 1){
            $socio->ativo = 0;
        } else {
            $socio->ativo = 1;
        }

        $socio->save();
        return redirect()->action("SocioController@index")->with('success', 'Estado alterado corretamente');
    }

    public function mudarEstadoQuota($id){

        $socio = User::findOrFail($id);
        if($socio->quota_paga == 1){
            $socio->quota_paga = 0;
        } else {
            $socio->quota_paga = 1;
        }

        $socio->save();
        return redirect()->action("SocioController@index")->with('success', 'Estado de quotas alterado corretamente');
    }

    public function enviarEmailConfirmacao($id){

        $socio = User::findOrFail($id);
        $socio->sendEmailVerificationNotification();
        return redirect()
                ->action("SocioController@index")
                ->with("success", "Email reenviado corretamente");
    }

    public function mostrarFicheiroCertificado($id){
        $socio = User::findOrFail($id);
        $this->authorize('view', $socio);
        return response()->file(storage_path('app/docs_piloto/certificado_'.$socio->id.'.pdf'));
    }

    public function mostrarFicheiroLicenca($id){
        $socio = User::findOrFail($id);
        $this->authorize('view', $socio);
        return response()->file(storage_path('app/docs_piloto/licenca_'.$socio->id.'.pdf'));
    }

    public function resetQuotas(){    
        User::where('quota_paga','=',1)->update(['quota_paga' => 0]);  
        return redirect()
                ->action("SocioController@index")
                ->with('success', 'Estado de quotas de todos os sócios alterado corretamente');
    }

    public function desativarSemQuotas(){    
        User::where('quota_paga','=',0)->update(['ativo' => 0]);  
        return redirect()
                ->action("SocioController@index")
                ->with('success', 'Estado de quotas dos sócios desativados alterado corretamente');
    }


}
