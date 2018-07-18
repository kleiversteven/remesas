@extends('layouts.adm')

@section('otroscss')
    <link href="{{ asset('plugins/dropzone/dropzone.min.css')}} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/dropzone/basic.min.css')}} " rel="stylesheet" type="text/css" />
@endsection
@section('content')

@if(count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>Nuevo deposito </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
            {!! Form::open(['url'=>'savedeposito','method'=>'POST','enctype'=>'multipart/form-data','class'=>'horizontal-form','id'=>'save-deposito']) !!}
            <div class="form-body"> 
                <h3 class="form-section">Datos del deposito</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Monto:', null, ['class' => 'control-label']) }}
                            {!! Form::number('monto',null,['class'=>'form-control  placeholder-no-fix','id'=>'monto','placeholder'=>'Monto','onkeyup'=>'calmonto()' ]) !!}
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group ">
                            {{ Form::label('Moneda:', null, ['class' => 'control-label']) }}
                                @foreach($monedas as $m)
                                    @if($m->entrada == 1)
                                        <?php $options[$m->iso]=$m->descripcion;  ?>
                                    @endif
                                @endforeach
                            {{ Form::select('moneda-into',$options,null,['class' => 'form-control','id'=>'moneda-into','placeholder' => 'Seleccione moneda depositada','onchange'=>'calmonto()'])}}
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
                            {{ Form::label('Referencia:', null, ['class' => 'control-label']) }}
                            {!! Form::text('ref-into',null,['class'=>'form-control  placeholder-no-fix','placeholder'=>'N° Referencia' ]) !!}</div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Fecha:</label>
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
                
                <!--/row-->
          
                <!--/row-->
                <h3 class="form-section">Datos a transferir:
                <span class="monto-trans"></span>
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Titular:', null, ['class' => 'control-label']) }}
                            {!! Form::text('titular',null,['class'=>'form-control  placeholder-no-fix','placeholder'=>'Titular de la cuenta' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            {{ Form::label('Cedula:', null, ['class' => 'control-label']) }}
                            {!! Form::radio('nacionalidad', 'V', true) !!}
                            {!! Form::radio('nacionalidad', 'J') !!}
                            {!! Form::radio('nacionalidad', 'E') !!}
                            {!! Form::number('cedula',null,['class'=>'form-control','placeholder'=>'Numero de cedula']) !!}
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            {{ Form::label('Tipo de cuenta:', null, ['class' => 'control-label']) }}
                            {{ Form::select('tipo',array('Corriente','Ahorro'),null,['class' => 'form-control','placeholder' => 'Seleccione tipo de cuenta'])}}
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            {{ Form::label('Banco:', null, ['class' => 'control-label']) }}
                                @foreach($bancos as $b)
                                    @if($b->salida ==1)  
                                        <?php $optio[$b->idbank]=$b->banco ;  ?>
                                    @endif
                                @endforeach
                                {{ Form::select('banco-out',$optio,null,['class' => 'form-control','placeholder' => 'Seleccione banco'])}}
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            {{ Form::label('Correo', 'Correo', ['class' => 'control-label']) }}
                            {{ Form::email('email', null, ['class' => 'form-control','placeholder' => 'example@correo.com']) }}                                    
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            {{ Form::label('N° de cuenta',null, ['class' => 'control-label']) }}
                            {!! Form::number('cuenta',null,['class'=>'form-control','placeholder'=>'N de cuenta']) !!}
                        </div>
                    </div> 
                    <div class="col-md-6 ">
                        <div class="form-group">
                            {{ Form::label('Telefono',null, ['class' => 'control-label']) }}
                             <select name="country" id="country_list" class="select2 form-control col-md-4">
                                 <option></option>
                                @foreach($countries as $c)
                                 <option  data-img-src="{{asset('flags/'.strtolower($c->id).'.png') }}" value="{{ $c->codigo }}">{{ $c->country }}</option>
                                @endforeach
                            </select>
                            {!! Form::number('telefono', null, ['class' => 'form-control col-md-8','placeholder' => 'Numero de telefono']) !!}
                                    
                        </div>
                    </div>
                    
                
                <!--/row-->
                
            </div>
            </div>
            <div class="form-actions right">
                {{ Form::button('Cancelar',['class'=>'btn default']) }}
                <button type="submit" class="btn blue">
                    <i class="fa fa-check"></i> Guardar</button>
            </div>
        {!! Form::close() !!}
        <!-- END FORM-->
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/dropzone/dropzone.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/form-dropzone.min.js')}}" type="text/javascript"></script>
<script>
$(function(){
    $("#country_list").select2({
        placeholder: '<i class="fa fa-map-o"></i>&nbsp; Seleccionar codigo del pais',
        templateResult: format,
        templateSelection: format,
        width: 'auto', 
        escapeMarkup: function(m) {
            return m;
        }
    });
    
    $('#save-depositoa').submit(function(){
        
            var formData = new FormData(document.getElementById("save-deposito"));

            $.ajax({
                url: '{{url("/savedeposito")}}',
                type: "POST",
                dataType: "HTML",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).done(function(echo){
                console.log(echo)

            });
            return false;
        })
    })
function format(state) {
        if (!state.id) { return state.text; }
        var flag = $(state.element).data('img-src').toLowerCase();
        var $state = $(
         '<span><img src="' + flag + '" class="img-flag" /> ' + state.text + ' (' + state.element.value + ' )' + '</span>'
        );
        return $state;
    }
function calmonto(){
    var de = $('#moneda-into').val();
    var a = 'VEF';
    var monto = $('#monto').val();
    $('#resultado').val(de/a);
    if(de != '' && monto > 0){
        $.get("calcular","isoa="+de+"&isob="+a+"&monto="+monto,function(e){
            console.log(e);
             $('.monto-trans').html(e);
        })
    }
}
</script>
@endsection