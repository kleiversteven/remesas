@extends('layouts.adm')

@section('otroscss')
    <link rel="stylesheet" href="{{ asset('assets/global/plugins/jquery-ui/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/jquery.comiseo.daterangepicker.css') }}">
@endsection
@section('content')

@if(!empty(session('mensaje')))
<div class="alert alert-success">
  <strong>Completado!</strong> {{session('mensaje')}}.
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Reporte de clientes
                </div>
                <div class="actions">
                    <b onclick="consultar()" class="btn btn-warning"  ><i class=""></i> &nbsp;Consultar </b>
                </div>
            </div>
            <div class="portlet-body row">
                <div class="form-group col-md-4">
                        <label >Fecha:</label>
                            <div class="input-group">
                                <input id="fechas" class="form-control"  name="fechas">
                                <span class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                </div>
                <div class="form-group form col-md-4">
                    <label>Buscar rol:</label>
                    <select name="cliente" id="cliente" class="form-control" onchange="usuriosroles(this.value)">
                        <option value="all" >Todos</option>
                        @foreach($roles as $r)
                        <option value="{{ $r->id }}" >{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4 clientes">
                
                </div>
                
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    <div class="col-md-12 reporte" style="display: none;">
        <div class="portlet box blue">
             <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file-pdf-o"></i>
                </div>
                <div class="actions">
                    <a href="javascript:;" class="btn btn-warning btn-dowload"  ><i class="fa fa-file-pdf-o"></i> &nbsp;Descargar </a>
                </div>
            </div>
            <div class="portlet-body row info-report">
                 <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"  cellspacing="0" width="100%">
                     <thead>
                        <tr class="table-header"></tr>
                     </thead>
                     <tbody  class="table-body">
                     </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/global/plugins/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/moment.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/jquery.comiseo.daterangepicker.js') }}"></script>


<script>
    
$(function() {
    
    jQuery(function($){
            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '&#x3C;Ant',
                nextText: 'Sig&#x3E;',
                currentText: 'Hoy',
                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
                    'Jul','Ago','Sep','Oct','Nov','Dic'],
                dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
            $.datepicker.setDefaults($.datepicker.regional['es']);
        });
    
    
    $("#fechas").daterangepicker({
          presetRanges: [{
             text: 'Hoy',
             dateStart: function() { return moment() },
             dateEnd: function() { return moment() }
         }, {
             text: 'Semana actual',
             dateStart: function() { return moment().startOf('week') },
             dateEnd: function() { return moment().endOf('week') }
         }, {
             text: 'Semana anterior',
             dateStart: function() { return moment().add('weeks', -1).startOf('week') },
             dateEnd: function() { return moment().add('week',-1).endOf('week')  }
         }, {
             text: 'Mes actual',
             dateStart: function() { return moment().startOf('month')},
             dateEnd: function() { return moment()  }
         }, {
             text: 'Mes anterior',
             dateStart: function() { return moment().add('month', -1).startOf('month')},
             dateEnd: function() { return moment().add('month', -1).endOf('month')  }
         }],
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
         applyOnMenuSelect: false,
         datepickerOptions: {
             minDate: null,
             maxDate: 0,
             numberOfMonths : 3
         }
     });
});
function usuriosroles(rol){
    $.get('usuarios','id='+rol,function(r){
        r = jQuery.parseJSON(r);
        var select = '<label>Seleccionar usuario:</label><select name="client" id="client" class="form form-control"   multiple="multiple" ><option value="all">Todos</option>';
        $.each(r, function( k, v ) {
          select+='<option value='+v.id+'>'+v.name+'</option>';
        });
        select += '</select>';
        $('.clientes').html(select);
        seleccionar();
    })
}
function seleccionar(){
    $('#client').select2({placeholder: 'Buscar usuario'});
}
function consultar(){
    var rol= $('#cliente').val();
    var clients= $('#client').val();
    var fechas=jQuery.parseJSON($("#fechas").val());
    var start=fechas.start;
    var end=fechas.end;
    var token = "{{ csrf_token() }}";
    var url = "{{ url('reporteClientePdfData') }}";
    var data  = "desde="+start+"&hasta="+end+"&rol="+rol+"&clientes="+clients;
    var header ='';
    var body ='';
    $.get("{{ url('reporteClientePdfData') }}",data,function(e){
        var i =1;
        if(e == 0){
            $('.reporte').fadeOut(500);
            $('.btn-dowload').attr({'href':'javascript:;'});
           alertify.error("No hay depositos registrados en el periodo seleccionado");
        }else{
           
           var response = jQuery.parseJSON(e);
            
            if(clients != undefined && clients != null && clients != 'all'){
                $('.btn-dowload').attr({'href':'{{ url("reporteClientePdf") }}?desde='+start+'&hasta='+end+'&rol='+rol+'&clientes='+clients });
                header+='<th>N°</th>';
                header+='<th>Nombre</th>';
                header+='<th>N° de deposito</th>';
                header+='<th>Moneda</th>';
                header+='<th>Entrada</th>';
                header+='<th>Salida</th>';
                $.each( response, function( key, value ) {
                  body+='<tr><td>'+i+'</td>';
                  body+='<td>'+value.nombre+'</td>';
                  body+='<td>'+value.referencia_into+'</td>';
                  body+='<td>'+value.descripcion+'</td>';
                  body+='<td>'+number_format(value.monto_entrada, 2, ',', '.')+'</td>';
                  body+='<td>'+number_format(value.monto_salida, 2, ',', '.')+'</td></tr>';
                    i++;
                });
                
            }else if(rol != 'all'){
                $('.btn-dowload').attr({'href':'{{ url("reporteClientePdf") }}?desde='+start+'&hasta='+end+'&rol='+rol+'&clientes='+clients });
                header+='<th>N°</th>';
                header+='<th>Tipo de usuario</th>';
                header+='<th>Usuario</th>';
                header+='<th>Moneda</th>';
                header+='<th>Entrada</th>';
                header+='<th>Salida</th>';
                $.each( response, function( key, value ) {
                  body+='<tr><td>'+i+'</td>';
                  body+='<td>'+value.name+'</td>';
                  body+='<td>'+value.nombre+'</td>';
                  body+='<td>'+value.descripcion+'</td>';
                  body+='<td>'+number_format(value.monto_entrada, 2, ',', '.')+'</td>';
                  body+='<td>'+number_format(value.monto_salida, 2, ',', '.')+'</td></tr>';
                    i++;
                });
                
            }else{
                $('.btn-dowload').attr({'href':'{{ url("reporteClientePdf") }}?desde='+start+'&hasta='+end+'&rol='+rol+'&clientes='+clients });
                header+='<th>N°</th>';
                header+='<th>Tipo de usuario</th>';
                header+='<th>Moneda</th>';
                header+='<th>Entrada</th>';
                header+='<th>Salida</th>';
                $.each( response, function( key, value ) {
                  body+='<tr><td>'+i+'</td>';
                  body+='<td>'+value.name+'</td>';
                  body+='<td>'+value.descripcion+'</td>';
                  body+='<td>'+number_format(value.monto_entrada, 2, ',', '.')+'</td>';
                  body+='<td>'+number_format(value.monto_salida, 2, ',', '.')+'</td></tr>';
                    i++;
                });
            }
            $('.table-header').html(header);
            $('.table-body').html(body);
             $('.reporte').fadeIn(500);
        }
    });
}
number_format = function (number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);

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