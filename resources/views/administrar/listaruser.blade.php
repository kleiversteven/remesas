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
                    <i class="fa fa-users"></i>Usuarios
                </div>
                <div class="actions">
                    <a href="{{ url('adduser') }}" class="btn btn-warning fa fa-plus" >Agregar</a >
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_3">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td> {{ ucfirst($user->rol_name) }}</td>
                                <td>
                                    <input type="checkbox" class="make-switch "   @if($user->estatus == 1 ) checked=checked  @endif;  data-on-color="success"  data-size="small" data-off-color="danger" data-on-text="<i class='fa fa-check' data-id='{{ $user->id  }}' data-estatus='0' onclick='estatus(this)'></i>" data-off-text="<i class='fa fa-power-off' data-id='{{ $user->id  }}' data-estatus='1' onclick='estatus(this)'></i>" >
                                </td>
                               
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
function estatus(e){
    var id = $(e).data('id');
    var estatus = $(e).data('estatus');
    $.get('estatus','id='+id+'&estatus='+estatus,function(response){
        if(response == 1)
            alertify.success('Usuario activado');
        else
            alertify.success('Usuario desactivado');
    })
}
</script>
@endsection