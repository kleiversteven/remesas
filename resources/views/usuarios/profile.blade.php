@extends('layouts.adm')

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
@if(count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PROFILE SIDEBAR -->
            <div class="profile-sidebar">
                <!-- PORTLET MAIN -->
                <div class="portlet light profile-sidebar-portlet ">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                        <img src="{{ asset('../storage/') }}/app/{{ $user->avatar }}" class="img-responsive" alt=""> </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name"> {{ Auth::user()->name }} </div>
                        <div class="profile-usertitle-job"> 
                        @role('cliente')
                            Cliente
                        @endrole
                        @role('developers')
                            Desarrollador
                        @endrole
                        @role('super-admin')
                            Administrador
                        @endrole
                        @role('recaudador')
                            Recaudador
                        @endrole
                        @role('Mayorista')
                            Mayorista
                        @endrole
                        </div>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS --
                    <div class="profile-userbuttons">
                        <button type="button" class="btn btn-circle green btn-sm">Follow</button>
                        <button type="button" class="btn btn-circle red btn-sm">Message</button>
                    </div>
                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li  class="active">
                                <a href="javascript:;">
                                    <i class="icon-home"></i> Informacion general </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END MENU -->
                </div>
                <!-- END PORTLET MAIN -->
                <!-- PORTLET MAIN -->
                
                <!-- END PORTLET MAIN -->
            </div>
            <!-- END BEGIN PROFILE SIDEBAR -->
            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">Perfil de la cuenta</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">Informacion personal</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab">Cambiar Avatar</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_3" data-toggle="tab">Cambiar contraseña</a>
                                    </li>
                                    
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="tab_1_1">
                                        {!! Form::open(['url'=>'upateuser','method'=>'POST','enctype'=>'multipart/form-data','class'=>'horizontal-form','id'=>'update-user']) !!}
                                            <div class="form-group">
                                                <label class="control-label">Nombre</label>
                                                <input type="text" name="nombre" placeholder="{{ $user->name }}" class="form-control" /> </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label">Telefono: </label>
                                          <div class="col-md-12 ">
                                            <div class="form-group row">
                                                <div class=" col-md-4 row">
                                                <select name="country" id="country_list" class="select2 form-control col-md-4" style="z-index: 9999;">
                                                     <option></option>
                                                    @foreach($countries as $c)
                                                     <option @if($user->country == $c->codigo) selected @endif  data-img-src="{{asset('flags/'.strtolower($c->id).'.png') }}" value="{{ $c->codigo }}">{{ $c->country }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                                 <div class=" col-md-8 row">
                                                    {!! Form::number('telefono', null, ['class' => 'form-control col-md-4','placeholder' => $user->telefono]) !!}
                                                 </div>
                                            </div>
                                        </div>
                                                
                                            
                                            </div>
                                            <div class="margiv-top-10">
                                                <input type="submit"  class="btn green" value="Guardar">
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <!-- END PERSONAL INFO TAB -->
                                    <!-- CHANGE AVATAR TAB -->
                                    <div class="tab-pane" id="tab_1_2">
                                        
                                        {!! Form::open(['url'=>'updateavatar','method'=>'POST','enctype'=>'multipart/form-data','class'=>'horizontal-form','id'=>'update_avatar']) !!}
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                        <img src="{{ asset('../storage/') }}/app/{{ $user->avatar }}" alt="" /> </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                            <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <input type="file" name="avatar"> </span>
                                                        <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="margin-top-10">
                                                <input type="submit"  class="btn green" value="Guardar">
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <!-- END CHANGE AVATAR TAB -->
                                    <!-- CHANGE PASSWORD TAB -->
                                    <div class="tab-pane" id="tab_1_3">
                                        {!! Form::open(['url'=>'updatepass','method'=>'POST','enctype'=>'multipart/form-data','class'=>'horizontal-form','id'=>'update_passwordr']) !!}
                                            <div class="form-group">
                                                <label class="control-label">Contraseña actual</label>
                                                <input type="password" name="pass" placeholder="******" class="form-control"  value="{{ old('pass') }}" /> </div>
                                            <div class="form-group">
                                                <label class="control-label">Nueva contraseña</label>
                                                <input id="password" type="password" class="form-control" name="password"  value="{{ old('password') }}" required> </div>
                                            <div class="form-group">
                                                <label class="control-label">Repetir contraseña</label>
                                                <input id="password-confirm" type="password" class="form-control"  value="{{ old('password_confirmation') }}" name="password_confirmation" required> </div>
                                            <div class="margin-top-10">
                                                <input type="submit"  class="btn green" value="Guardar">
                                                
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <!-- END CHANGE PASSWORD TAB -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>
</div>


@endsection

@section('scripts')
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
})    
function format(state) {
        if (!state.id) { return state.text; }
        var flag = $(state.element).data('img-src').toLowerCase();
        var $state = $(
         '<span><img src="' + flag + '" class="img-flag" /> ' + state.text + ' (' + state.element.value + ' )' + '</span>'
        );
        return $state;
    }
</script>
@endsection
