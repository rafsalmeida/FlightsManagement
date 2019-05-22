@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifique o endereço de email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Um link de verificação foi enviado para o seu endereço de email') }}
                        </div>
                    @endif

                    {{ __('Antes de proceder, verifique o seu email para o link de verificação') }}
                    {{ __('Senão recebeu o email') }}, <a href="{{ route('verification.resend') }}">{{ __('clique aqui para receber outro') }}</a>.
                </div>
            </div>
        </div>

    </div>
    <div class = "row justify-content-center" style="padding-top: 10px">
        <form action="{{ action('Auth\LoginController@logout')}}" method="post" class= "form-group"> 
        @csrf 
        <button type="submit" class="btn btn-sm btn-xs btn-primary rounded-pill"><i class="fas fa-sign-out-alt"></i> Terminar sessão</button>
        </form>

    </div>
        
</div>
@endsection
