<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LocalRemesas</title>
    <!-- css -->
	<link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    
	<link href="{{ asset('css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('css/mystyle.css') }}" rel="stylesheet">
    @yield('otros')
    <link rel="shortcut icon" href="{{ asset('images/icono.png') }}" type="image/x-icon"/>
</head>

<body >
<div class="">
<nav class="navbar navbar-expand-lg navbar-light bg-turquesa">
  <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}" class="img-logo" /></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{ url('inicio') }}">Inicio </a>
      </li><li class="nav-item active">
        <a class="nav-link" href="#">¿Quienes somos? </a>
      </li><li class="nav-item active">
        <a class="nav-link" href="#">Preguntas frecuentes </a>
      </li><li class="nav-item active">
        <a class="nav-link" href="contacto">Contacto </a>
      </li>
    </ul>
	<ul class="nav navbar-nav navbar-right  options-user">
        @if (Auth::guest())
		<li><a href="{{ route('login') }}" class="btn btn-outline-primary"><span class=" fa fa-sign-in"></span> Iniciar sesión</a></li>
      <li><a href="{{ route('register') }}" class="btn btn-outline-primary"><span class="fa fa-user"></span>Registrarse</a></li>
        @else
        <div class="dropdown " style="right: 30px;" >
  <button type="button" class="btn btn-outline-warning dropdown-toggle fa fa-user" data-toggle="dropdown">
     {{ Auth::user()->name }} 
  </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="administrar" > Administrar cuenta  </a>
            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
        </div>
        </div>
        
	   @endif
        </ul>
  </div>
</nav>
</div>


    <section id="content" class="wraper content contain">
@yield('content')
</section>
    

<footer>
    
    <div class="row container col-md-10 offset-md-1">
        <div class="col-md-12" style="text-align: center;">
            <font color="#ffc107">RUC:&nbsp; </font> &nbsp; 20603289812
            <br>
            <button  class="btn btn-outline-warning"> Se emite boleta electronica de la SUNAT </button>
            <br>
            <br>
            <br>
        </div>
        <div class="col-md-4">
            <img class="icons-footer" src="{{ asset('images/ico-gmail.png') }}">
            Localremesas@gmail.com
        </div>
        <div class="col-md-4">
            <img class="icons-footer" src="{{ asset('images/ico-send.png') }}">&nbsp;
            <img class="icons-footer" src="{{ asset('images/ico-instagram.png') }}">
            @Localremesas
        </div>
        <div class="col-md-4 row">
            <span class="col-md-2"><img class="icons-footer" src="{{ asset('images/ico-ws.png') }}"></span>
            <span class="col-md-8">
                +51 961 451647
                <br>
                +51 915 013559
            </span>
                
                
        </div>
    </div>
    <br><br>
</footer>

    
<script>
    
   
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

</script>


	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
	<script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
    
    @yield('scripts')		
</body>

</html>
