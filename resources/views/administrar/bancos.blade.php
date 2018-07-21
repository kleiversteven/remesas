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
                    <i class="fa fa-globe"></i>Bancos</div>
                <div class="tools"><p onclick="agregar()" class="btn btn-warning"  ><i class="fa fa-plus"></i>Agregar</p> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Banco</th>
                            <th class="all">Cuenta</th>
                            <th class="all">Entrada</th>
                            <th class="all">Salida</th>
                            <th class="all">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="list-bancos">
                        @foreach($bancos as $b)
                        <tr>
                            <td>{{ $b->banco }}</td>
                            <td>{{ $b->idcuenta }}</td>
                            <td>
                                @if($b->entrada == 1)
                                    <span class="label label-info"> Activo </span>
                                @else
                                    <span class="label label-danger"> Desctivado </span>
                                @endif
                            </td>
                            <td>
                                @if($b->salida == 1)
                                    <span class="label label-info"> Activo </span>
                                @else
                                    <span class="label label-danger"> Desctivado </span>
                                @endif
                            </td>
                            <td>
                                <b class="fa fa-pencil" onclick="editar('{{ $b->idbank }}')" ></b>
                                <b class="fa fa-trash" onclick="editar('{{ $b->idbank }}')" ></b>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection
@section('scripts')
<script>
function agregar(){
    
     if($('.list-bancos tr').hasClass( "form-banco" )){
        return false;
    }
    var html= "<tr class='form-banco'> ";
        html += "<th><input class='form-control' type='text' name='descripcion' placeholder='Descripcion'> </th> ";
        html += "<th><input class='form-control' type='number' name='cuenta' placeholder='Cuenta'> </th> ";
        html += "<th><input type='checkbox' name='entrada'> </th> ";
        html += "<th><input type='checkbox' name='salida'> </th> ";
        html += "<th><b class='btn btn-danger' onclick='cancelar()' ><i class='fa fa-times' ></i></b><b class='btn btn-success' onclick='addbank()' ><i class='fa fa-check' ></i></b> </th> ";
        html += "</tr> ";
    $('.list-bancos').prepend(html);
}
function addbank(){
    var ent =0 ;
    var sal =0;
    var htm_ent='<span class="label label-danger"> Desctivado </span>';
    var htm_sal='<span class="label label-danger"> Desctivado </span>';
    if($("[name='entrada']").is(':checked') ){
        ent =1;
        htm_ent='<span class="label label-info"> Activo </span>';
    }
    if($("[name='salida']").is(':checked') ){
        sal =1;
        htm_sal='<span class="label label-info"> Activo </span>';
    }
    var datos = 'desc='+$("[name='descripcion']").val()+'&cuenta='+$("[name='cuenta']").val()+'&salida='+sal+'&entrada='+ent;
    var desc= $("[name='descripcion']").val();
    var cuenta =$("[name='cuenta']").val();
    $.get('savebanco',datos,function(r){
        cancelar();
       var html= "<tr>  ";
        html += "<td>"+desc+"</td>";
        html += "<td>"+cuenta+"</td>";
        html += "<td>"+htm_ent+"</td>";
        html += "<td>"+htm_sal+"</td>";
        html += "<td><b class='fa fa-pencil' onclick=editar('"+r+"') ></b><b class='fa fa-trash' onclick=editar('"+r+"') ></b</td>";
        html += "</tr> ";
        $('.list-bancos').prepend(html);
    })
}
function cancelar(){
    $('.form-banco').remove();
}
</script>
@endsection