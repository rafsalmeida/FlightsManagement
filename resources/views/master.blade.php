<!DOCTYPE html>
<html lang=pt>
    <head>
    	<meta charset="utf-8">
        <title>@yield('title')</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
    	<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    </head>
    <body>
	    <nav class="navbar navbar-expand-lg navbar-dark bg-primary static-top">
		    <div class="container-fluid">
		      <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				    <i class="fas fa-bars"></i>
			  </button>
		      <a href="{{action('HomeController@index')}}"class="navbar-brand"><i class="fas fa-plane"></i> FlightClub</a>
              <div class="dropdown navbar-nav ml-auto" >
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="far fa-user-circle"></i> {{ Auth::user()->name }} <span class="caret"></span>
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu bg-light dropdown-menu-right rounded-bottom" style="min-width: 13.5rem; text-align: center;">
                        <li><a class="text-primary" href="{{action('SocioController@edit', Auth::user()->id)}}"><i class="fas fa-user-circle"></i> Perfil</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="text-primary" href="{{ action('Auth\ChangePasswordController@showForm')}}"><i class="fas fa-key"></i> Alterar Password</a></li>
                        <div class="dropdown-divider"></div>
                        <li><form action="{{ action('Auth\LoginController@logout')}}" method="post" class= "form-group"> 
                        @csrf 
                        <button type="submit" class="btn btn-link navbar-btn navbar-link font-weight-bold"><i class="fas fa-sign-out-alt"></i> Terminar sessão</button></form></li>
                    </ul>
               </div>
		      
		    </div>
	    </nav> 

        <div class="container-fluid">
            <div class="row">
	               <div class="col-md-2 collapse navbar-collapse show" id="collapsibleNavbar" style="padding: 0; margin: 0; min-height: 91vh;background-color: #ececec; "> 
                        <ul class="vertical-menu navbar-nav nav-navtabs">
                          <li class="nav-item">
                            <a class="btn" href="{{action('AeronaveController@index')}}"><i class="fas fa-plane"></i> Gerir Aeronaves</a>
                          </li>
                          <li class="nav-item">
                            <a class="btn" href="{{action('SocioController@index')}}"><i class="fas fa-plane"></i> Gerir Sócios</a>
                          </li>
                          <li class="nav-item">
                            <a class="btn" href="{{action('MovimentoController@index')}}" ><i class="fas fa-plane"></i> Movimentos</a>
                          </li> 
                        </ul>
                </div>
                <div class="col-md-10">
                    <div class="container-fluid" >
                        @if (session('success'))
                            @include('partials.success')
                        @endif
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
            $(".vertical-menu .nav-item").on("click", function(){
               $(".vertical-menu").find(".active").removeClass("active");
               $(this).addClass("active");
            });
        </script>
</html>
