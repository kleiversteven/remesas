@extends('layouts.adm')

@section('content')
<div class="page-content-inner">
                            <div class="row widget-row">
                                <div class="col-md-3">
                                    <!-- BEGIN WIDGET THUMB -->
                                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                        <h4 class="widget-thumb-heading">Precio del dolar</h4>
                                        <div class="widget-thumb-wrap">
                                            <i class="widget-thumb-icon bg-green fa fa-money"></i>
                                            <div class="widget-thumb-body">
                                                <span class="widget-thumb-subtitle">USD</span>
                                                <span class="widget-thumb-body-stat" >{{ $dolar }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END WIDGET THUMB -->
                                </div>
                                <div class="col-md-3">
                                    <!-- BEGIN WIDGET THUMB -->
                                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                        <h4 class="widget-thumb-heading">Precio del sol</h4>
                                        <div class="widget-thumb-wrap">
                                            <i class="widget-thumb-icon bg-red fa fa-money"></i>
                                            <div class="widget-thumb-body">
                                                <span class="widget-thumb-subtitle">PEN</span>
                                                <span class="widget-thumb-body-stat">{{ $sol }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END WIDGET THUMB -->
                                </div>
                                <div class="col-md-3">
                                    <!-- BEGIN WIDGET THUMB -->
                                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                        <h4 class="widget-thumb-heading"><a href="{{ url('misdepositos') }}" >Mis depositos</a></h4>
                                        <div class="widget-thumb-wrap">
                                            <i class="widget-thumb-icon bg-purple icon-screen-desktop"></i>
                                            <a class="widget-thumb-body">
                                                <span class="widget-thumb-subtitle"></span>
                                                <span class="widget-thumb-body-stat">{{ $depositos }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END WIDGET THUMB -->
                                </div>
                                <div class="col-md-3">
                                    <!-- BEGIN WIDGET THUMB -->
                                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                        <h4 class="widget-thumb-heading"><a href="{{ url('misdepositos') }}" >Transacciones completas</a></h4>
                                        <div class="widget-thumb-wrap">
                                            <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                                            <a class="widget-thumb-body">
                                                <span class="widget-thumb-subtitle"></span>
                                                <span class="widget-thumb-body-stat">{{ $procesados }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END WIDGET THUMB -->
                                </div>
                            </div>
</div>
@if($parametros['BLOQUEO']['status'] == 1)
<div class="alert alert-info">
  <strong>Advertencia!</strong> la carga de pedidos ha sido deshabilitada debido:
    <p>
       &nbsp; &nbsp; &nbsp; {{ $parametros['BLOQUEO']['motivo'] }}
    </p>
</div>
@endif

@role('Super-admin')
<ul class="list-group">
    @foreach($deudas as $d)    
          @if($d->moneda_into == 'COP')
          <li style="cursor:pointer" data-iso="{{ $d->moneda_into }}" data-user="{{ $d->id }}" class="list-group-item list-group-item-info list-deudas" data-toggle="modal" data-target="#myModal"><table class="table table-borderless"><tr><th>Usuario:</th><td>{{ $d->name . $d->email }}</td>
              <th>Operaciones:</th><td>{{ $d->transacciones }}</td><th>Deuda:</th><td>{{$d->total}}</td><th>Trasferido:</th><td>{{ $d->trasferido }}</td><th>Moneda:</th><td>{{ $d->descripcion }}</td></tr></table></li>
          @elseif($d->moneda_into == 'PEN')
          <li style="cursor:pointer" data-iso="{{ $d->moneda_into }}" data-user="{{ $d->id }}" class="list-group-item list-group-item-warning list-deudas" data-toggle="modal" data-target="#myModal"><table class="table table-borderless"><tr><th>Usuario:</th><td>{{ $d->name . $d->email }}</td>
              <th>Operaciones:</th><td>{{ $d->transacciones }}</td><th>Deuda:</th><td>{{$d->total}}</td><th>Trasferido:</th><td>{{ $d->trasferido }}</td><th>Moneda:</th><td>{{ $d->descripcion }}</td></tr></table></li>
          @elseif($d->moneda_into == 'USD')
          <li style="cursor:pointer" data-iso="{{ $d->moneda_into }}" data-user="{{ $d->id }}" class="list-group-item list-group-item-success list-deudas" data-toggle="modal" data-target="#myModal"><table class="table table-borderless"><tr><th>Usuario:</th><td>{{ $d->name . $d->email }}</td>
              <th>Operaciones:</th><td>{{ $d->transacciones }}</td><th>Deuda:</th><td>{{$d->total}}</td><th>Trasferido:</th><td>{{ $d->trasferido }}</td><th>Moneda:</th><td>{{ $d->descripcion }}</td></tr></table></li>
          @endif
    @endforeach
    </ul>
@endrole



<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"> </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table class="table table-hover lista-transacciones">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Total</th>
                <th>Trasferido</th>
                <th>Comision</th>
                <th>Tasa</th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>
         </table>
      </div>

    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
$( document ).ready(function() {
  // Asociar un evento al botón que muestra la ventana modal
  $('.list-deudas').click(function() {
      $('.lista-transacciones tbody tr').remove();
      $('.modal-title').html('');
      var use = $(this).data('user');
      var iso = $(this).data('iso');
      var data = 'user='+use+'&iso='+iso;
    $.ajax({
        url : 'deudasuser',
        data : data,
        type : 'GET',
        dataType : 'html',
        success : function(respuesta) {
            var lista = jQuery.parseJSON(respuesta);
            
            
            $('.modal-title').html(lista[0].name+ ' - ' + lista[0].descripcion);
            $.each(lista, function(i, item) {
                var html='<tr><td>'+lista[i].fecha_into+'</td><td>'+lista[i].monto_into+'</td><td>'+ number_format(lista[i].trasferido, 2, ',', '.')+'</td><td>'+lista[i].comision+'%</td><td>'+ number_format(lista[i].tasa, 2, ',', '.')+'</td></tr>';
                $('.lista-transacciones tbody').append(html)
            });
        },
        error : function(xhr, status) {
            alert('Disculpe, existió un problema');
        },
    });
      
      
  });
});
    
    number_format = function (number, decimals, dec_point, thousands_sep) {
        //number = number.toFixed(decimals);

        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

        return x1 + x2;
    }
</script>
@endsection