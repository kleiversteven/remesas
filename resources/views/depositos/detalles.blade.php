@extends('layouts.adm')
<link rel="stylesheet" href="{{ asset('plugins/fancybox/jquery.fancybox.css') }}" type="text/css" media="screen" />
@section('otroscss')
    
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
                    <i class="fa fa-globe"></i>Transaccion</div>
                <div class="actions"> <a href="{{ url('listardepositos') }}" class="btn btn-warning fa fa-preview" >Volver</a> </div>
            </div>
            <div class="portlet-body row">
                <div class="col-md-6" ><span class=" col-md-2"><b>Estatus: </b></span>
                   <span class="estatus col-md-5">
                    
                   @if($deposito[0]->estatus == 1)
                        <span class="label label-info"> Deposito sin validar </span>
                    @elseif($deposito[0]->estatus == 2)
                        <span class="label label-danger"> Rechazado </span>
                    @elseif($deposito[0]->estatus == 3)
                        <span class="label label-primary"> Transferencia en progreso </span>
                    @elseif($deposito[0]->estatus == 4)
                        <span class="label label-success"> Transacción completa </span>
                    @endif
                     
                    </span>
                    
                    <span class="botones col-md-4">
                        <b class="fa fa-pencil" style="cursor: pointer;" onclick="estatus('{{ $deposito[0]->idtrans }}','{{ $deposito[0]->estatus }}')"></b>
                    </span>
                    
                    <br>
                    
                </div>
                <div class="col-md-12">
                    <legend>Deposito realizado por: </legend>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4">{{ $deposito[0]->name }}</div>
                    <div class="col-md-4">{{ $deposito[0]->email }}</div>
                </div>
                <div class="col-md-12">
                    <legend>Detalles de deposito: </legend>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4"><b>Fecha:</b> {{ $deposito[0]->fecha_into }} </div>
                    <div class="col-md-4"><b>Moneda depositada:</b> {{ $deposito[0]->mnd_ent_desc }} </div>
                    <div class="col-md-4"><b>Banco:</b> {{ $deposito[0]->b_ent }}</div>
                    <div class="col-md-4"><b>Referencia:</b> {{ $deposito[0]->referencia_into }}</div>
                    <div class="col-md-4"><b>Monto:</b> {{ $deposito[0]->depo_into }} {{ $deposito[0]->moneda_into }}</div>
                    <div class="col-md-4"><b>Tasa de cambio:</b> {{ number_format($deposito[0]->tasa,2,",",".") }}</div>
                    <div class="col-md-4"><b>Monto en {{ $deposito[0]->mnd_sal_desc }}:</b> {{ number_format($deposito[0]->monto_out,2,",",".") }} {{ $deposito[0]->moneda_out }}</div>
                    @if(!empty($deposito[0]->comprobante_into))
                    <div class="col-md-4"><b>Comprobante:</b>
                        <a class="fancybox" href="{{ asset('../storage/') }}/app/{{ $deposito[0]->comprobante_into }}" data-fancybox="images" data-width="2048" data-height="1365">
                            <img class="grouped_elements" style="width: 150px;" src=" {{ asset('../storage/') }}/app/{{ $deposito[0]->comprobante_into }}">
                        </a>
                    </div>
                    @else
                        <div class="col-md-4"> </div>
                    @endif
                </div>
                <div class="col-md-12">
                    <legend>A quien trasferir: </legend>
                </div>
                <div class="col-md-12">
                   <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"  cellspacing="0">
                       <thead>
                        <tr>
                            <th class="all">Titular</th>
                            <th class="all">Cedula</th>
                            <th class="all">Banco</th>
                            <th class="all">Tipo</th>
                            <th class="none">Cuenta: </th>
                            <th class="none">Transferir:</th>
                            <th class="none">Conversion:</th>
                            <th class="none">Referencia:</th>
                            <th class="none">Comprobante:</th>
                            <th class="none"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deposito as $d)
                        {!! Form::open(['url'=>'savedreferencia','method'=>'POST','enctype'=>'multipart/form-data','class'=>'horizontal-form','id'=>'save-deposito']) !!}
                        <input type="hidden" name="idtrans" value="{{ $d->codesali }}">
                        <input type="hidden" id="imagen" value="{{ asset(Storage::url($d->comprobante_out )) }}">
                        <input type="hidden" id="referencia" value="{{ $d->referencia_out }} ">
                        <tr>
                            <td>{{ $d->titular }}</td>
                            <td>{{ $d->cedula }}</td>
                            <td>{{ $d->b_sal }}</td>
                            <td>
                                @if($d->tipo == 0)
                                    Corriente.
                                @else
                                    Ahorro.
                                @endif
                            </td>
                            <td>{{ $d->cuenta }}</td>
                            <td>{{ $d->monto_into }} {{ $d->moneda_into }}</td>
                            <td>{{  number_format($d->monto_out,2,",",".") }} {{ $d->moneda_out }}</td>
                            <td class="input">
                                {{$d->referencia_out}}
                            </td>
                            <td class="file">
                                @if(!empty($d->comprobante_out))
                                <a class="fancybox" href="{{ asset(Storage::url($d->comprobante_out  )) }}" data-fancybox="images" data-width="2048" data-height="1365">
                                <img class="grouped_elements" style="max-width: 100px;max-height: 120px;" src="{{ asset(Storage::url($d->comprobante_out  )) }}">
                                </a>
                                @endif
                            </td>
                            <td class="depositar" data-salida='{{ $d->codesali }}'>
                                
                                @if($deposito[0]->estatus == 3)
                                    <b class="btn btn-primary fa fa-pencil" onclick="editar({{ $d->codesali }},this)"></b>
                                @endif
                            
                            </td>
                        </tr>
                        {!! Form::close() !!}
                        @endforeach
                    </tbody>
                   </table>
                </div>
                
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('plugins/fancybox/jquery.fancybox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/fancybox/jquery.mousewheel-3.0.6.pack.js') }}"></script>
    
    <script>
    function estatus(idtrans,estatus){
        
        var btns = '';
            btns+= '<b class="btn fa fa-times" onclick=cancelar("'+estatus+'") ></b>';
            btns+= '<b class="btn fa fa-check" onclick=guardar("'+idtrans+'") ></b>';
        var select ='';
            select+='<select id="status" class="form-control">';
            select+='<option value="1" ';    
        if(estatus ==  1){ select+= 'selected'; }  
            select+='>Deposito sin validar</option>';
            select+='<option value="2" ';    
        if(estatus ==  2){ select+= 'selected'; }  
            select+='>Rechazado</option>';
            select+='<option value="3" ';    
        if(estatus ==  3){ select+= 'selected'; }  
            select+='>Transferencia en progreso</option>';
            select+='<option value="4" ';   
        if(estatus ==  4){ select+= 'selected'; }  
            select+='>Transacción completa</option>';
            select+='</select>';
        
        $('.estatus').html(select);
        $('.botones').html(btns);
      
    }
    function cancelar(estatus,idtrans){
        var btns = '';
            btns+= ' <b class="fa fa-pencil" style="cursor: pointer;" onclick=estatus("'+idtrans+'")></b>';
        var select ='';
        if(estatus ==  1){ select+= '<span class="label label-info"> Deposito sin validar </span>'; }   
        if(estatus ==  2){ select+= '<span class="label label-danger"> Rechazado </span>'; }
        if(estatus ==  3){ select+= '<span class="label label-primary"> Transferencia en progreso </span>'; }
        if(estatus ==  4){ select+= '<span class="label label-success"> Transacción completa </span>'; }
        $('.estatus').html(select);
        $('.botones').html(btns);
    }
        
    function guardar(idtrans){
        var estatus = $('#status').val();
        var html = '';
        $.get("{{ url('modtransaccion') }}",'transac='+idtrans+'&estatus='+estatus,function(response){
             if(estatus ==  3){
                 var sal = $('.depositar').data('salida');
                 html+='<b class="btn btn-primary fa fa-pencil" onclick=editar("'+sal+'",this)></b>';
             }
            $('.depositar').html(html);
            cancelar(estatus,idtrans);
        })
        
    }
        
    function editar(code,e){
        var html= '<b class="btn btn-danger fa fa-times" onclick=cancela(this) ></b>';
        var form = '{!! Form::open(["url"=>"savereferencia","method"=>"POST","enctype"=>"multipart/form-data","class"=>"horizontal-form","id"=>"save-deposito"]) !!}';
        var input= '<input type="number" name="referencia" placeholder="N° de referencia" class="form-control" >';
        var file= '<input type="file" name="capture" placeholder="comprobante" class="form-control" >';
            file+= '<input type="hidden" name="transc" value="'+code+'" placeholder="comprobante" class="form-control" >';
        var element = e;
        form += input + file + "<input type='submit' value='guardar' class='btn btn-primary btn-block fa fa-check' > {!! Form::close() !!}";
        
        $(element).parents('tr').children( "td:eq( 7 )" ).attr({'colspan':2});
        $(element).parents('tr').children( "td:eq( 7 )" ).html(form);
        $(element).parents('tr').children( "td:eq( 8 )" ).remove();
        $(element).parents('td').html(html);
    }
        
function cancela(e){
    var image = $("#imagen").val();
    var file='';
        if(image!='')
        {
            file+= '<a class="fancybox" href="'+image+'" data-fancybox="images" data-width="2048" data-height="1365">';
            file+='<img class="grouped_elements" style="max-width: 100px;max-height: 120px;" src="'+image+'">';
            file+='</a>'
        }
    var referencia = $("#referencia").val();
    var element = $(e).parents('tr');
     element.children( "td:eq( 7 )" ).attr({'colspan':1});
     element.children( "td:eq( 7 )" ).text(referencia);
     element.children( "td:eq( 8 )" ).remove();
     element.append('<td>'+file+'</td>');
     element.append('<td><b class="btn btn-primary fa fa-pencil" onclick="editar(this,this)"></b></td>');
}
        
    $(document).ready(function() {
        $(".fancybox").fancybox({
             'width' : '75%',
             'height' : 'auto',
             'align' : 'center',
             'autoScale' : true,
             'transitionIn' : 'none',
             'transitionOut' : 'none',
             'type' : 'iframe'
         });
    });
    </script>
@endsection