@extends('layouts.adm')

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
                    <i class="fa fa-globe"></i>Tasas de cambio</div>
                <div class="tools"></div>
            </div>
            <div class="portlet-body">
                <table class="table datatable table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>De</th>
                            <th>A</th>
                            <th>Minoristas</th>
                            <th>Mayoristas</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    {!! Form::open(['url'=>'','method'=>'POST','class'=>'horizontal-form','id'=>'update-tasas']) !!}
                    @foreach($tasas as $t)
                        @if($t->isoa != $t->isob)
                        <tr>
                            <td>{{ $t->entrada }}</td>
                            <td>{{ $t->salida }}</td>
                            <td>{{ $t->cambio }}</td>
                            <td>{{ $t->mayorista }}</td>
                            <td><b class="btn btn-primary fa fa-pencil" onclick="editar('{{ $t->id }}',this)" ></b></td>
                        </tr>
                        @endif
                    @endforeach
                    {!! Form::close() !!}
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@endsection

@section('scripts')
<script>
function editar(id,e){
    var camb = $(e).parents('tr').children('td:eq(2)').text();
    var mayr = $(e).parents('tr').children('td:eq(3)').text();
    var cambio =      "<input type='number' id='cambio' name='cambio' placeholder='"+camb+"' class='form-control' >";
    var mayoritario = "<input type='number' id='mayori' name='mayori' placeholder='"+mayr+"' class='form-control' >";
    var botones = "<b class='btn btn-danger fa fa-times' onclick=cancelar('"+id+"',this,'"+camb+"','"+mayr+"')></b><b class='btn btn-success fa fa-check' onclick=salvar('"+id+"',this,'"+camb+"','"+mayr+"')></b>";
    $(e).parents('tr').children('td:eq(2)').html(cambio);
    $(e).parents('tr').children('td:eq(3)').html(mayoritario);
    $(e).parents('tr').children('td:eq(4)').html(botones);
}
    
function cancelar(id,e,minor,mayor){
    var boton ='<b class="btn btn-primary fa fa-pencil" onclick=editar("'+id+'",this) ></b>';
    $.get('tasa','id='+id,function(r){
        r = jQuery.parseJSON(r);
        $(e).parents('tr').children('td:eq(2)').html(r.cambio);
        $(e).parents('tr').children('td:eq(3)').html(r.mayorista);
        $(e).parents('tr').children('td:eq(4)').html(boton);
    })
}
function salvar(id,e,minor,mayor){
    var c =$('#cambio').val();
    var m =$('#mayori').val();
    var data = 'camb='+c+'&may='+m+'&id='+id;
    var boton ='<b class="btn btn-primary fa fa-pencil" onclick=editar("'+id+'",this) ></b>';
    $.get('cambiartasas',data,function(r){
        cancelar(id,e,minor,mayor)
    })
}
</script>
@endsection