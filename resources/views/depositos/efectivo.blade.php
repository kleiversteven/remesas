@extends('layouts.adm')

@section('otroscss')
    <link href="{{ asset('plugins/dropzone/dropzone.min.css')}} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/dropzone/basic.min.css')}} " rel="stylesheet" type="text/css" />
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
            {!! Form::open(['url'=>'savedeefectivo','method'=>'GET','class'=>'horizontal-form','id'=>'save-deposito']) !!}
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
                            {{ Form::select('moneda-into',$options,null,['class' => 'form-control','id'=>'moneda-into','placeholder' => 'Seleccione moneda depositada','onchange'=>'calmonto(this)'])}}
                        </div>
                    </div>
                    <!--/span-->
                </div>
          
                <!--/row-->
                <h3 class="form-section">Cuentas a transferir:<span class="monto-trans"></span>
                    <span style="float: right" onclick="addcuenta()" class="btn btn-primary">Agregar</span>
                
                    <br>
                    <br>
                    <div class="list-group lista-frecuentes">
                    </div>
                </h3>
                
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
    
    $('#save-deposito').submit(function(){
        
        var formData = new FormData(document.getElementById("save-deposito"));
        var t = 0;
        var monto = $('#monto').val();
        $('.addmonto').each(function( index ){
            var n =$(this).val();
            if(n >0 ){
                t = parseInt(n)+parseInt(t);
            }                
        });
        if(monto < 50){
            alertify.error("El monto minimo de transferencia son 50.");
            return false;
        }
        if(t != monto){
            alertify.error("Tiene un error en la distribucion de montos");
            return false;
        }
        var ref = $("[name='ref_into']").val();
        if(ref <= 0){
            alertify.error("El monto minimo de transferencia son 50.");
            return false;
        }
            
    })
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
})
function format(state) {
        if (!state.id) { return state.text; }
        var flag = $(state.element).data('img-src').toLowerCase();
        var $state = $(
         '<span><img src="' + flag + '" class="img-flag" /> ' + state.text + ' (' + state.element.value + ' )' + '</span>'
        );
        return $state;
    }
function calmonto(e){
    var de = $('#moneda-into').val();
    var a = 'VEF';
    var monto = $('#monto').val();
    $('.sobrante').text(monto);
    //$('#resultado').val(de/a);
     var sel = $('#moneda-into').children('option:selected').text();
    if(de != ''){
        $('.addmonto').attr({'placeholder':'Monto en '+sel});
        $('.sobrante').text(monto + ' ' +  de);
    }
    
    
    if(de != '' && monto > 0){
        $.get("calcular","isoa="+de+"&isob="+a+"&monto="+monto,function(e){
            $('.monto-trans').html(some_number = number_format(e, 2, ',', '.') +' Bs');
            $('.addmonto').attr({'max':monto});
            
        })
        
    }
    
}
function addcuenta(){
    var t =0;
    $('.lista-frecuentes a').each(function(){
        t++;
    })
    
         $('.form-registrar').fadeIn(300);   
   
} 
function cerrar(){
    $('.form-registrar').fadeOut(300);
}
function savecuenta(){
    var min=0;
    var de = $('#moneda-into').val();
    var sel = $('#moneda-into').children('option:selected').text();
          min = $('#monto').val() + 0;
        if(min == 0)
            min =50;
    
    var c=0;
    $(".active" ).each(function( index ){
       c++; 
    });
    var activo=0;
    activo = $('.in').data('collapse');
    if(activo == 2){
       var titular =$('#titular').val();
       var tipo=$('#tipo').val();
       var banco=$('#banco').val();
       var cuenta=$('#cuenta').val();
       var salvar = 1;
        if(titular == ''){
           alertify.error("Debe ingresar el nombre del titular de la cuenta");
            salvar=0;
        }
        if(tipo <= ''){
            alertify.error("Debe indicar el tipo de cuenta");
            salvar=0;
        }
        if(banco == ''){
            alertify.error("Debe seleccionar el banco");
            salvar=0;
        }
        if(cuenta.length != 20){
            alertify.error("El numero de cuenta debe estar compuesto de 20 digitos");
            salvar=0;
        }
        if(cuenta.length != 20){
            alertify.error("El numero de cuenta debe estar compuesto de 20 digitos");
            salvar=0;
        }
        if(salvar == 1)
        {
            $.post("savecuenta",$('#save-cuenta').serialize(),function(response){
            $('.lista-frecuentes').children('#id-'+response).remove();
            var html = '<a href="javascript:;" class="list-group-item list-group-item-info" id="id-'+response+'" style="font-size: 12px;">';
                html+= '<div class="form-group"><input type="hidden" name="frecuente[]" value="'+response+'" >';
                html+=  titular + ' ' + cuenta;
                html+= '<span style="width: 200px;display: -webkit-inline-box;position: absolute;right: 240px;margin-top: -4px;"></span>';
                html+= '<input style="width: 200px;display: -webkit-inline-box;position: absolute;right: 40px;margin-top: -4px;" placeholder="Monto " type="number" min="1" class="form-control addmonto" name="montofrecuente[]" onkeyup="cambiarmontos(this)"  >';
                html+= '</div>  <i class="fa fa-times" style="position: absolute;right: 10px; margin-top:-20px;" onclick="quitar(this)" ></i> </a>';
            
            $('.in').removeClass('in');
            
            $('.lista-frecuentes').append(html);
             var sel = $('#moneda-into').children('option:selected').text();
            if(de != '')
                $('.addmonto').attr({'placeholder':'Monto en '+sel});
                
            document.getElementById("save-cuenta").reset();
        });
        }
        
    }else if(activo == 1){
        var html='';
        
        $('.active').each(function( index ){
                $('.lista-frecuentes').children('#id-'+$(this).data('id')).remove();
                html+= '<a href="javascript:;" class="list-group-item list-group-item-info" id="id-'+$(this).data('id')+'" style="font-size: 12px;">';
                html+= '<div class="form-group">'+$(this).data('titular') + ' ' + $(this).data('cuenta');
                html+= '<span style="width: 200px;display: -webkit-inline-box;position: absolute;right: 240px;margin-top: -4px;"></span>';
                html+= '<input style="width: 200px;display: -webkit-inline-box;position: absolute;right: 40px;margin-top: -4px;" placeholder="Monto " type="number" min="1" class="form-control addmonto" name="montofrecuente[]" onkeyup="cambiarmontos(this)"  >';
                html+= '</div>';
                html+= '<input type="hidden" name="frecuente[]" value="'+$(this).data('id')+'" >';
                html+= ' <i class="fa fa-times" style="position: absolute;right: 10px; margin-top:-20px;" onclick="quitar(this)" ></i> </a>';
            
        })
                           
       $('.lista-frecuentes').append(html);
        
    }
    if(de != '')
        $('.addmonto').attr({'placeholder':'Monto en '+sel});
        
    if(activo > 0){
        cerrar();
    }
}
    function quitar(e){
        var id = $(e).prev('input').val();
        console.log('class-'+id);
        $('.class-'+id).removeClass('active');
        $(e).parent('a').remove();
    }
    function solonumeros(e){
        var numero = $(e).val();
        if(numero.length > 19)
        {
            $(e).val(numero.substr(0,20));
            if(numero.length > 20)
                $('.error-cuenta').show();
            
            return false;
        }else{
            $('.error-cuenta').hide()
        }
            
        $(e).value = ($(e).value + '').replace(/[^0-9]/g, '');  
        
        $.get('{{ url("validarbanco") }}','cuenta='+$(e).val(),function(r){
            
            if(r==0 && numero.length > 4){
                alertify.error("Error en el numero de cuenta");
                $(e).val(numero.substr(0,4));
            }else{
                r = jQuery.parseJSON(r);
                $('#banco').val(r.banco);
                $('#banco-out').val(r.idbank);
            }
        })
    }
function activar(e){
    var c=0;
    $(".active" ).each(function( index ){
       c++; 
    });
    if($(e).hasClass( "active" )){
        $('.lista-frecuentes').children('#id-'+$(e).data('id')).remove();
    }
    if(c <= 2 || $(e).hasClass( "active" ) ){
        $(e).toggleClass('active');
    }
}
    function cambiarmontos(e){
        var monto = $('#monto').val();
        var montoing = $(e).val();
        var elemento=  e;
        
        if(monto >0 ){
           var mon = $(e).val();
            var t = 0;
            $('.addmonto').each(function( index ){
                var n =$(this).val();
                if(n >0 ){
                    t = parseInt(n)+parseInt(t);
                }                
            });
            
            mont=(parseInt(monto)+parseInt(mon))-parseInt(t);
            
            if(mon > mont){
                var l =mon.length;
                l2 =l*(-1);
                var m = mon.substr(l2,l-1);
                
                $(e).val(m);
                alertify.error("El monto maximo de distribucion es " + monto);
            }else{
                
                if(t > 0){
                    var newmonto = monto-t;
                    var de = $('#moneda-into').val();
                    $('.sobrante').text(newmonto + ' ' );
                    if(de != ''){
                        $('.sobrante').text(newmonto + ' ' +  de);
                    }

                }
                    var moneda = $('#moneda-into').val();
                    $.get("calcular","isoa="+moneda+"&isob=VEF&monto="+montoing,function(tmonto){
                        //console.log(tmonto);
                        $(elemento).prev('span').html(some_number = number_format(tmonto, 2, ',', '.') + ' Bs');
                    })
                }
            
            
        }else{
            alertify.error("Debe ingresar el monto del deposito");
            $(e).val('');
        }
        
    }
    
function validartipo(e){
        if($(e).val() == 1 ){
            $('.aviso-banco').show();
        }else{
            $('.aviso-banco').hide();
        }
    }
    
    
    
    
</script>
<div class="form-registrar" style=" width: 100%;
        height: 100%;
        position: fixed;
        background-color: #0000008c;
        top: 0;
        z-index: 9995;display: none;">
    <div class="fomulario row col-md-12" style="">
        <h2 class="col-md-8 col-md-offset-2" style="    margin-top: 4%;
    background: #3598dc;
    padding: 10px;
    box-sizing: border-box;
    margin-bottom: 1px;
    color: #fff;">&nbsp; &nbsp; Añadir cuenta</h2>
        <div class="content col-md-8 col-md-offset-2" style=" height: 300px; overflow: auto;  background-color: #fff;">
            <br>
            
            
    <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Frecuentes</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse" data-collapse='1'>
            
              <div class="list-group">
                  @foreach($frecuentes as $f)
                    <a href="#" data-id="{{ $f->codefrec }}" data-cuenta="{{ $f->cuenta }}" data-titular="{{ $f->titular }}" class="list-group-item mi-item class-{{ $f->codefrec }}" onclick="activar(this)">
                      <h4 class="list-group-item-heading">{{ $f->titular }}</h4>
                      <p class="list-group-item-text">{{ $f->banco }} - {{ $f->tipo }} - {{ $f->cuenta }}</p>
                    </a>
                  @endforeach                  
              </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Agregar nuevo</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse" data-collapse='2'>
          <br>
        <div class="row">
            {!! Form::open(['url'=>'','method'=>'POST','class'=>'horizontal-form ','id'=>'save-cuenta']) !!}
            <div class="form-body"> 
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Titular:', null, ['class' => 'control-label']) }}
                            {!! Form::text('titular',null,['class'=>'form-control  placeholder-no-fix', 'id'=>'titular','placeholder'=>'Titular de la cuenta' ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            {{ Form::label('Cedula:', null, ['class' => 'control-label']) }}
                            {!! Form::radio('nacionalidad', 'V', true) !!}V
                            {!! Form::radio('nacionalidad', 'J') !!}J
                            {!! Form::radio('nacionalidad', 'E') !!}E
                            {!! Form::number('cedula',null,['class'=>'form-control','placeholder'=>'Numero de cedula']) !!}
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            {{ Form::label('Tipo de cuenta:', null, ['class' => 'control-label']) }}
                            {{ Form::select('tipo',array('Corriente','Ahorro'),null,['class' => 'form-control', 'id'=>'tipo','placeholder' => 'Seleccione tipo de cuenta'])}}
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            {{ Form::label('Banco', 'Banco', ['class' => 'control-label']) }}
                           {{ Form::text('banco',null,['disabled'=>'disabled','class' => 'form-control', 'id'=>'banco','placeholder' => 'Banco'])}}
                            {{ Form::hidden('banco-out',null,['disable'=>'disable', 'id'=>'banco-out','placeholder' => 'Seleccione banco'])}}
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
                            {!! Form::number('cuenta',null,['minlength'=>'20' , 'maxlength' =>'20', 'class'=>'form-control','placeholder'=>'N° de cuenta', 'id'=>'cuenta','onkeyup'=>'solonumeros(this)']) !!}
                        </div>
                    </div> 
                <div class="col-md-6 ">
                        <div class="form-group">
                            {{ Form::label('Telefono',null, ['class' => 'control-label']) }}
                             <select name="country" id="country_list" class="select2 form-control col-md-4" style="z-index: 9999;">
                                 <option></option>
                                @foreach($countries as $c)
                                 <option  data-img-src="{{asset('flags/'.strtolower($c->id).'.png') }}" value="{{ $c->codigo }}">{{ $c->country }}</option>
                                @endforeach
                            </select>
                            {!! Form::number('telefono', null, ['class' => 'form-control col-md-8','placeholder' => 'Numero de telefono']) !!}
                                    
                        </div>
                    </div>
                <br>
            </div>
            {!! Form::close() !!}
      </div>
    </div>
    
  </div> 
            
            
            
        </div>
        
        
    </div>
        <br>
        <br>
    <div class="col-md-12" style="text-align: center;">

        <button class="btn btn-success" onclick="savecuenta()" >Añadir</button>
        <button class="btn btn-danger" onclick="cerrar()">Cancelar</button>
    </div>
    
</div>
@endsection