@extends('layouts.site')

@section('content')
<div class="page-inicio" style="background-image:url({{ asset('images/fondo3.jpg') }});">
<div class="row col-lg-12 col-md-12 col-sm-12 animated bounceInButton "  >
    <div class="col-lg-3 col-md-3 col-sm-3 pos-sup content-moneda"   ><img src="{{ asset('images/soles.png') }}" class="img-moneda"  />Soles</div>
   <!-- <div class="col-lg-3 col-md-3 col-sm-3 pos-sup content-moneda"   ><img src="{{ asset('images/pesos.png') }}" class="img-moneda"  />Pesos</div> -->
    <div class="col-lg-3 col-md-3 col-sm-3 pos-sup content-moneda"   ><img src="{{ asset('images/bolivares.png') }}" class="img-moneda"  />Bolivares</div>
    <div class="col-lg-3 col-md-3 col-sm-3 pos-sup content-moneda"   ><img src="{{ asset('images/dolares.png') }}" class="img-moneda"  />Dolares</div>
    <hr class="img-linea"/>
</div>
<div class="row col-lg-12 col-md-12 col-sm-12 "  >
    
    <div  class=" row col-lg-6 col-md-6 col-sm-12 offset-md-1 offset-lg-1 animated bounceInRight" style="margin-top: 5%;">
        <div  class="slogan col-lg-4 col-md-4 col-sm-12 btn-block " >
            
            
            <p class="btn btn-outline-warning" style="font-size: 20px;">
                <b class="fech-font ">Fecha:</b><br>
            <?php
            date_default_timezone_set('America/Caracas');
            setlocale(LC_ALL,"es_ES");
            echo utf8_encode(strftime("%A %d "));
            echo "DE <br>";
            echo utf8_encode(strftime("%B del %Y"));
            ?>
                </p>
        </div>
      
        <div class="  col-lg-8 col-md-6 col-sm-12 table-monedas">
            <table class="table table-striped table-bordered table-hover dt-responsive"  style="border: none;">
                <tr><th style="border: none;"></th><th style="border: none;">=</th><th style="border: none;">Tasa de cambio</th></tr>
                <tr>
                    <th style="border: none;">
                        <span class="item-tasa"><img src="{{ asset('images/bolivares.png') }}" class="img-moneda2"  /></span>
                        <span class="item-tasa"><img src="{{asset('flags/ve.png') }}" class="img-moneda2"  /></span>
                    </th>
                    <th style="border: none;"  style="font-size:18px !important" class="align-middle"><span style="font-size:18px !important" > &nbsp; {{ number_format($sol_bs,2,",",".") }}</span> &nbsp; </th>
                    <th class="linea-table align-middle" style="border: none;">
                                <span class="item-tasa" style="font-size:18px !important" >1</span>
                                <span class="item-tasa"><img src="{{ asset('images/soles.png') }}" class="img-moneda2"  /></span>
                                <span class="item-tasa"><img src="{{asset('flags/pe.png') }}" class="img-moneda2"  /></span>
                    </th>
                    
                    
                </tr>
                <tr>
                    <th style="border: none;" class="align-middle"> 
                        
                        <span class="item-tasa"><img src="{{ asset('images/soles.png') }}" class="img-moneda2"  /></span>
                        <span class="item-tasa"><img src="{{asset('flags/pe.png') }}" class="img-moneda2"  /></span>
                            
                    </th>
                    <th style="border: none;"  style="font-size:18px !important" class="align-middle"><span style="font-size:18px !important" > &nbsp; {{ number_format($dol_so,2,",",".") }}</span> &nbsp; </th>
                    <th style="border: none;" class="linea-table align-middle"> 
                            <span class="item-tasa" style="font-size:18px !important" >1</span>
                            <span class="item-tasa"><img src="{{ asset('images/dolares.png') }}" class="img-moneda2"  /></span>
                            <span class="item-tasa"><img src="{{asset('flags/us.png') }}" class="img-moneda2"  /></span>
                        
                    </th>
                    
                    
                </tr>
                <tr>
                    <th style="border: none;"  class="align-middle">
                        <span class="item-tasa"><img src="{{ asset('images/bolivares.png') }}" class="img-moneda2"  /></span>
                        <span class="item-tasa"><img src="{{asset('flags/ve.png') }}" class="img-moneda2"  /></span>
                    </th>
                    <th style="border: none;"  style="font-size:18px !important" class="align-middle"><span style="font-size:18px !important" > &nbsp; {{ number_format($dol_bs,2,",",".") }}</span> &nbsp; </th>
                    <th style="border: none;" class="linea-table align-middle">
                        <span class="item-tasa" style="font-size:18px !important" >1</span>
                        <span class="item-tasa"><img src="{{ asset('images/dolares.png') }}" class="img-moneda2"  /></span>
                        <span class="item-tasa"><img src="{{asset('flags/us.png') }}" class="img-moneda2"  /></span>
                    </th>
                    
                    
                </tr>
            </table>
            <br>
        </div>
    </div>
    
    <div  class="calculadora row animated bounceInLeft col-lg-4 col-md-4 col-sm-4 offset-ld-1 offset-md-1 offset-sm-2 align-self-end"> 
        <h3>Calculadora de remesas:</h3>
        <div class="form-row">
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
                <label for="inputState">Monto:</label>
                <input class="form-control" id="monto" type="number" min="1" placeholder="Monto">
            </div>
            
            <div class="form-group col-md-12">
                <input type="text" class="form-control" id="resultado" type="text" placeholder="Resultado" readonly>
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
    $.get("calcular","isoa="+de+"&isob="+a+"&monto="+monto,function(e){
        console.log(e);
        //var calculo=monto * e[0]['cambio'];
        $('#resultado').val(e);
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