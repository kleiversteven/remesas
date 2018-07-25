@extends('layouts.adm')
@section('otroscss')
    
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
            <i class="fa fa-user"></i>Nuevo usuario </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
            {!! Form::open(['url'=>'saveuser','method'=>'POST','enctype'=>'multipart/form-data','class'=>'horizontal-form','id'=>'save-user']) !!}
            <div class="form-body"> 
                <h3 class="form-section">Datos del usuario</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Nombre:', null, ['class' => 'control-label']) }}
                            {!! Form::text('name',null,['class'=>'form-control  placeholder-no-fix','id'=>'monto','placeholder'=>'Nombre' ]) !!}
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group ">
                             {{ Form::label('Rol de usuario:', null, ['class' => 'control-label']) }}
                                @foreach($roles as $r)
                                        <?php $options[$r->name]=$r->name;  ?>
                                @endforeach
                            {{ Form::select('rol',$options,null,['class' => 'form-control','id'=>'moneda-into','placeholder' => 'Rol de usuario'])}}
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                             {{ Form::label('Correo:', null, ['class' => 'control-label']) }}
                            {!! Form::email('email',null,['class'=>'form-control  placeholder-no-fix','id'=>'correo','placeholder'=>'correo@ejemplo.com' ]) !!}
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Contraseña:', null, ['class' => 'control-label']) }}
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6 ">
                        <div class="form-group">
                            {{ Form::label('Repetir contraseña:', null, ['class' => 'control-label']) }}
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        
                    </div>
                </div>
                
                <!--/row-->
          
             
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

@endsection