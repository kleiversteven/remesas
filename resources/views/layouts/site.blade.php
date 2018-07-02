<!DOCTYPE html>
<html lang="en">

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
	<link href="{{ asset('css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('css/mystyle.css') }}" rel="stylesheet">
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
        <a class="nav-link" href="./">Inicio </a>
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
		<li><a href="{{ route('login') }}" class="btn btn-outline-warning"><span class=" fa fa-sign-in"></span> Iniciar sesión</a></li>
      <li><a href="{{ route('register') }}" class="btn btn-outline-warning"><span class="fa fa-user"></span>Registrarse</a></li>
        @else
        <div class="dropdown " style="right: 30px;" >
  <button type="button" class="btn btn-outline-warning dropdown-toggle fa fa-user" data-toggle="dropdown">
     {{ Auth::user()->name }} 
  </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
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
</footer>

<script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
</script>


	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
	<script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    
    
    @yield('scripts')		
</body>

</html>
