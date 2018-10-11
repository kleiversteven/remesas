@extends('layouts.adm')

@section('otroscss')
    
@endsection
@section('content')
@if(!empty(session('mensaje')))
<div class="alert alert-success">
  <strong>Completado!</strong> {{session('mensaje')}}.
</div>
@endif
<div class="row" >
    <div class="col-md-12 col-sm-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-users"></i>Lista de registros BCP
                </div>
                <div class="actions">
                    <a href="{{ url('limpiarbcp') }}" class="btn btn-danger fa fa-trash" >&nbsp; Limpiar lista</a >
                    <a href="{{ url('listarbcp') }}" class="btn btn-info fa fa-update" >&nbsp;Actualizar</a >
                    <a href="{{ url('agregarbcp') }}" class="btn btn-warning fa fa-plus" >&nbsp; Agregar</a >
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_3">
                    <thead>
                        <tr>
                            <th>Referencia</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($depositos as $d)
                            <tr>
                                <td>{{ $d->numerefe }}</td>
                                <td>{{ $d->fecha }}</td>
                                <td>{{ $d->montregu }}</td>
                            </tr>
                        @endforeach
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
$(document).ready(function() {
    
    $('.btn_changepermission').on('switchChange.bootstrapSwitch', function (e, state) {
    
        var obj = $(this);
         var id = obj.data('id');
        if(state === false){
           estatus(id,0)
        }else{
           estatus(id,1) 
        }
    }); 
});
function estatus(id,estatus){
    $.get('estatus','id='+id+'&estatus='+estatus,function(response){
        if(response == 1)
            alertify.success('Usuario activado');
        else
            alertify.success('Usuario desactivado');
    })
}
</script>
@endsection