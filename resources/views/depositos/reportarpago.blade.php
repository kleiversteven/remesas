@extends('layouts.adm')
@section('otroscss')
<style>
    .form-registrar{
        width: 100%;
        height: 100%;
        position: fixed;
        background-color: #0000008c;
        top: 0;
        z-index: 9995;
    }

</style>
@endsection
@section('content')

@if(!empty(session('mensaje')))
<div class="alert alert-success">
  <strong>Completado!</strong> {{session('mensaje')}}.
</div>
@endif
@if(!empty(session('error')))
<div class="alert alert-danger">
  <strong>Error!</strong> {{session('error')}}.
</div>
@endif


<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Reportar pago en efectivo</div>
                <div class="tools"> <b class="btn btn-success" onclick="reportar()">Reportar pago</b></div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Deposito</th>
                            <th class="all">Monto</th>
                            <th class="all">Moneda</th>
                            <th class="all">Fecha</th>
                            <th class="all small">Seleccionar</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($depositos as $d)
                        <tr class=" {{ $d->mnd_ent_desc }} ">
                            <td>{{ str_pad($d->codeefec,8,0,STR_PAD_LEFT) }}</td>
                            <td>{{ $d->monto_into }}</td>
                            <td>{{ $d->mnd_ent_desc }}</td>
                            <td>{{ $d->fecha_into }}</td>
                            <td><input type="checkbox" onclick="agregar(this)" data-id="{{$d->codeefec}}" data-iso="{{$d->mnd_ent_iso }}" class="form-control checkbox"></td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>

    
<div class="form-registrar" style=" width: 100%;
        height: 100%;
        position: fixed;
        background-color: #0000008c;
        top: 0;    left: 0;
        z-index: 9995;display: none;">
    <div class="fomulario row col-md-12" style="">
        <h3 class="col-md-8 col-md-offset-2" style="    margin-top: 4%;
    background: #3598dc;
    padding: 10px;
    box-sizing: border-box;
    margin-bottom: 1px;
    color: #fff;">&nbsp; &nbsp; Reporte de pago</h3>
        <div class="content col-md-8 col-md-offset-2 " style=" height: 300px; overflow: auto;  background-color: #fff;">
            <br>
            
            <ul class="list-group list-depo">
                
            </ul>
            
            
            
             <div class="portlet-body form">
        <!-- BEGIN FORM-->
            {!! Form::open(['url'=>'savedereporte','method'=>'POST','enctype'=>'multipart/form-data','class'=>'horizontal-form','id'=>'save-deposito']) !!}
            
                 <input type="hidden" name="depositos" id="depositos">
                 <div class="form-body"> 
                <h3 class="form-section">Datos del deposito</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Monto:', null, ['class' => 'control-label']) }}
                            {!! Form::text('monto',null,['class'=>'form-control  placeholder-no-fix','disabled'=>'disabled','id'=>'monto','placeholder'=>'Monto' ]) !!}
                            <input type="hidden" name="montotal" id="montotal">
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group ">
                            {{ Form::label('Moneda:', null, ['class' => 'control-label']) }}
                            {!! Form::text('Moneda',null,['class'=>'form-control  placeholder-no-fix','disabled'=>'disabled','id'=>'moneda','placeholder'=>'Moneda' ]) !!}
                            <input type="hidden" name="monedareal" id="monedareal">
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Banco:', null, ['class' => 'control-label']) }}
                                @foreach($bancos as $b)
                                    @if($b->entrada ==1)  
                                        <?php $option[$b->idbank]=$b->banco ;  ?>
                                    @endif
                                @endforeach
                                {{ Form::select('banco-into',$option,null,['class' => 'form-control','placeholder' => 'Seleccione banco'])}}
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Operacion:', null, ['class' => 'control-label']) }}
                            {!! Form::text('ref-into',null,['class'=>'form-control  placeholder-no-fix','placeholder'=>'N° de Operacion' ]) !!}</div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Fecha:', null, ['class' => 'control-label']) }}
                            {!! Form::date('fecha-into',null,['class'=>'form-control  placeholder-no-fix','placeholder'=>'N° Referencia','max'=>date('Y-m-d') ]) !!}
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <input type="file" name="comprobante" title="Cargar comprobante">
                        </div>
                        
                    </div>
                </div>
                
            </div>
            <div class="form-actions right">
                {{ Form::button('Cancelar',['class'=>'btn default','onclick'=>'cerrar()']) }}
                <button type="submit" class="btn blue">
                    <i class="fa fa-check"></i> Guardar</button>
            </div>
        {!! Form::close() !!}
        <!-- END FORM-->
    </div>
        </div>    
</div>
</div>    
    
@endsection
@section('scripts')
<script>
    var iso='';
    
    function reportar(){
        var lista=[];
        var p=0;
        $( ".checkbox" ).each(function( i ) {
            if($(this).is(':checked')){
                lista[p]=$(this).data('id');
                p++;
            }
          
        });
      if(p > 0){
          
          $('.list-group-item').remove();
          
         
          $.get("listareporte","lista="+lista,function(r){
              var obj = jQuery.parseJSON(r);
              var montotal=0;
              var moneda='';
              var monedareal='';
              var mnd_vj='';
              var dif = 0;
              $.each( obj, function( key, value ) {
                  monedareal = obj[key].moneda_into;
                  if(key == 0)
                      mnd_vj = obj[key].moneda_into;
                  
                  if(mnd_vj != monedareal)
                      dif = 1;
              });
            if(dif == 0){
                $('.form-registrar').fadeIn(300);
                  $.each( obj, function( key, value ) {
                      $('.list-depo').append('<li class="list-group-item">'+obj[key].monto_into + ' '+ obj[key].descripcion +'</li>');
                      moneda =obj[key].descripcion;
                      monedareal=obj[key].moneda_into;
                      montotal+=obj[key].monto_into;
                    });
              
                  $('#monto').val(montotal);
                  $('#montotal').val(montotal);

                  $('#moneda').val(moneda);
                  $('#monedareal').val(monedareal);
                  $('#depositos').val(lista);
              }else{
                  alertify.error("Los pagos seleccionados no tienen el mismo tipo de moneda de cambio");
              }
          })
          
      }else{
          $('.form-registrar').fadeOut(300);
          alertify.error("Debe indicar la operacion a reportar");
      }
    }

function agregar(e){
    var isob = $(e).data('iso');
    if(iso == isob)
        iso = $(e).data('iso');
}

function cerrar(){
    $('.form-registrar').fadeOut(300);
}
</script>
@endsection