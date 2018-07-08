@extends('layouts.site')

@section('content')
<div class="page-inicio" style="background-image:url({{ asset('images/fondo3.jpg') }});">
<div class="row col-lg-12 col-md-12 col-sm-12 animated bounceInButton "  >
    <div class="col-lg-3 col-md-3 col-sm-3 pos-sup content-moneda"   ><img src="{{ asset('images/soles.png') }}" class="img-moneda"  />Soles</div>
    <div class="col-lg-3 col-md-3 col-sm-3 pos-sup content-moneda"   ><img src="{{ asset('images/pesos.png') }}" class="img-moneda"  />Pesos</div>
    <div class="col-lg-3 col-md-3 col-sm-3 pos-sup content-moneda"   ><img src="{{ asset('images/bolivares.png') }}" class="img-moneda"  />Bolivares</div>
    <div class="col-lg-3 col-md-3 col-sm-3 pos-sup content-moneda"   ><img src="{{ asset('images/dolares.png') }}" class="img-moneda"  />Dolares</div>
    <hr class="img-linea"/>
</div>
<div class="row col-lg-12 col-md-12 col-sm-12 "  >
    
    <div  class=" col-lg-2 col-md-2 col-sm-2 offset-md-1 offset-lg-1 animated bounceInRight">
        <p  class="slogan">
          Seguridad confianza y puntualidad en tus envios de dinero.
        </p>
    </div>
    <div  class="calculadora row animated bounceInLeft col-lg-4 col-md-4 col-sm-4 offset-ld-5 offset-md-5 offset-sm-2 align-self-end"> 
        <h3>Calculadora de remesas:</h3>
        <div class="form-row">
            <div class="form-group col-md-12">
                <input type="text" class="form-control" id="resultado" type="text" placeholder="Resultado" readonly>
            </div>
             <div class="form-group col-md-12">
                <label for="inputState">Monto:</label>
                <input class="form-control" id="monto" type="number" min="1" placeholder="Monto">
            </div>
            <div class="form-group col-md-6">
                <label for="inputDe">De:</label>
                <select id="inputDe" class="form-control">
                    <option>Seleccionar</option>
                    
                    @foreach($monedas as $m)
                        <option value="{{ $m->iso }}" > {{ $m->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="inputA">A:</label>
                <select id="inputA" class="form-control">
                    <option>Seleccionar</option>
                    @foreach($monedas as $m)
                        <option value="{{ $m->iso }}" > {{ $m->descripcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-12">
                <button type="button" class="btn btn-lg btn-block btn-primary" onclick="calcular()">Calcular</button>
            </div>
        </div>
    </div>
    
    
</div>
</div>
<div class="cinta-coin">
    <br>
        <div class="mensaje-coin">
            Seguridad confianza y puntualidad en tus envios de dinero.
        </div>
</div>
<div class="container ">
    <div class=" row">
        <div class="col-md-3 info-coin tasas-cambio  animated bounceInDown ">
            <div class="">
                <img src="{{ asset('images/bolivares.png') }}">
                <div>
                    <h3>Bolivares</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td> Moneda</td>
                                <td> Tasa de cambio</td>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach($tasas as $t)
                                @if($t->iso == 'VEF')
                                    @if($t->isoa != $t->isob)
                                        <tr><td> 
                                            @if($t->isoa == 'VEF') 
                                                {{ $t->isob }}
                                            @else
                                                {{ $t->isoa }}
                                            @endif</td>    
                                        <td>{{ number_format($t->camb,2,",",".") }}</td></tr>
                                    @endif
                                @endif
                            @endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
        <div class="col-md-3 info-coin tasas-cambio  animated bounceInDown ">
            <div class="">
                <img src="{{ asset('images/pesos.png') }}">
                <div>
                    <h3>Pesos</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td> Moneda</td>
                                <td> Tasa de cambio</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasas as $t)
                                @if($t->iso == 'COP')
                                    @if($t->isoa != $t->isob)
                                        <tr><td>
                                           @if($t->isoa == 'COP') 
                                                {{ $t->isob }}
                                            @else
                                                {{ $t->isoa }}
                                            @endif
                                        </td>    
                                        <td>{{ number_format($t->camb,5,",",".") }}</td></tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3 info-coin tasas-cambio  animated bounceInDown ">
            <div class="">
                <img src="{{ asset('images/soles.png') }}">
                <div>
                    <h3>Soles</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td> Moneda</td>
                                <td> Tasa de cambio</td>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($tasas as $t)
                                @if($t->iso == 'PEN')
                                    @if($t->isoa != $t->isob)
                                        <tr><td>
                                           @if($t->isoa == 'PEN') 
                                                {{ $t->isob }}
                                            @else
                                                {{ $t->isoa }}
                                            @endif
                                        </td>    
                                        <td>{{ number_format($t->camb,5,",",".") }}</td></tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3 info-coin tasas-cambio  animated bounceInDown ">
            <div class="">
                <img src="{{ asset('images/dolares.png') }}">
                <div>
                    <h3>Dolares</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td> Moneda</td>
                                <td> Tasa de cambio</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasas as $t)
                                @if($t->iso == 'USD')
                                    @if($t->isoa != $t->isob)
                                        <tr><td>
                                           @if($t->isoa == 'USD') 
                                                {{ $t->isob }}
                                            @else
                                                {{ $t->isoa }}
                                            @endif
                                        </td>    
                                        <td>{{ number_format($t->camb,8,",",".") }}</td></tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
    
</div>
<br>
<br>
<div class="container col-md-12 list-site-bancos"  style="background-image:url({{ asset('images/cinta-bancos.jpg') }})">
  
</div>
@endsection


@section('scripts')
<script>
function calcular(){
    var de = $('#inputDe').val();
    var a = $('#inputA').val();
    var monto = $('#monto').val();
    $('#resultado').val(de/a);
    $.get("calcular","isoa="+de+"&isob="+a,function(e ){
        var calculo=monto * e[0]['cambio'];
        $('#resultado').val(calculo);
    })
}

    jQuery(function($) {
        $('.tasas-cambio').waypoint(function() {
            $(this).toggleClass( 'bounceIn animated' );
        },{
            offset: '70%',
            triggerOnce: true
    });

});
    
</script>
@endsection