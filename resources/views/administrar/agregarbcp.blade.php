@extends('layouts.adm')

@section('otroscss')
    
@endsection
@section('content')

@if(!empty(session('mensaje')))
<div class="alert alert-success">
  <strong>Completado!</strong> {{session('mensaje')}}.
</div>
@endif
@if(!empty(session('error')))
<div class="alert alert-danger">
  <strong>Completado!</strong> {{session('error')}}.
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Movimientos en el banco</div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                {!! Form::open(['url'=>'savemovimiento','method'=>'POST','class'=>'horizontal-form','id'=>'update-tasas']) !!}
                 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Monto:', null, ['class' => 'control-label']) }}
                            {!! Form::text('monto',null,['class'=>'form-control  placeholder-no-fix','id'=>'monto','placeholder'=>'Monto','onkeyup'=>'calmonto()' ]) !!}
                            
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Operacion:', null, ['class' => 'control-label']) }}
                            {!! Form::text('ref-into',null,['class'=>'form-control placeholder-no-fix','placeholder'=>'N° de Operacion' ]) !!}</div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Fecha:', null, ['class' => 'control-label']) }}
                            {!! Form::text('fecha-into',date("Y/m/d"),['class'=>'form-control datepicker placeholder-no-fix','placeholder'=>'YYYY-mm-dd','data-date-format'=>'yyyy-mm-dd','data-date-start-date'=>'-7d','data-date-end-date'=>'0d','data-date-max-date'=>'0d','data-date-min-date'=>'-7d' ]) !!}
                            
                        </div>
                    </div>
                  
                </div>
                <div class="form-actions right">
                    {{ Form::button('Cancelar',['class'=>'btn default']) }}
                    <button type="submit" class="btn blue">
                        <i class="fa fa-check"></i> Guardar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@endsection

@section('scripts')
<script>
<script>
$(function(){

   $('#save-deposito').submit(function(){
        
        var formData = new FormData(document.getElementById("save-deposito"));
        var t = 0;
        var monto = $('#monto').val();
       
        if(monto < 0){
            alertify.error("Debe ingrsar el monto de la trasferencia.");
            return false;
        }
       var fecha = $("[name='fecha-into']").val();
        if(fecha == '' || fecha <=0){
            alertify.error("Error en la fecha");
            return false;
        }
        
        var ref = $("[name='ref_into']").val();
        if(ref <= 0){
            alertify.error("Ingree el numero de la referencia");
            return false;
        }
            
    })
    
})
</script>
@endsection