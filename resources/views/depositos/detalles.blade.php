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
                    <i class="fa fa-globe"></i>Transaccion</div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body row">
                <div class="col-md-2" ><b>Estatus: </b>{{ $deposito[0]->estatus }}</div>
                <br>
                <div class="col-md-12">
                    <legend>Deposito realizado por: </legend>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4">{{ $deposito[0]->name }}</div>
                    <div class="col-md-4">{{ $deposito[0]->email }}</div>
                </div>
                <br>
                <div class="col-md-12">
                    <legend>Detalles de deposito: </legend>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4"><b>Fecha:</b> {{ $deposito[0]->fecha_into }} </div>
                    <div class="col-md-4"><b>Moneda</b> depositada: {{ $deposito[0]->mnd_ent_desc }} </div>
                    <div class="col-md-4"><b>Banco:</b> {{ $deposito[0]->b_ent }}</div>
                    <div class="col-md-4"><b>Referencia:</b> {{ $deposito[0]->referencia_into }}</div>
                    <div class="col-md-4"><b>Monto:</b> {{ $deposito[0]->depo_into }}</div>
                    <div class="col-md-4"><b>Tasa de cambio:</b> {{ number_format($deposito[0]->tasa,2,",",".") }}</div>
                    <div class="col-md-4"><b>Monto en {{ $deposito[0]->mnd_sal_desc }}:</b> {{ number_format($deposito[0]->monto_out,2,",",".") }}</div>
                    @if(!empty($deposito[0]->comprobante_into))
                    <div class="col-md-4">Comprobante: {{ $deposito[0]->monto_into }}</div>
                    @else
                        <div class="col-md-4"> </div>
                    @endif
                </div>
                <br>
                <div class="col-md-12">
                    <legend>A quien trasferir: </legend>
                </div>
                <div class="col-md-12">
                   <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"  cellspacing="0">
                       <thead>
                        <tr>
                            <th class="all">Titular</th>
                            <th class="all">Cedula</th>
                            <th class="all">Banco</th>
                            <th class="all">Tipo</th>
                            <th class="none">Cuenta: </th>
                            <th class="none">Transferir:</th>
                            <th class="none">Conversion:</th>
                            <th class="none">Referencia:</th>
                            <th class="none">Comprobante:</th>
                            <th class="none"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deposito as $d)
                        <tr>
                            <td>{{ $d->titular }}</td>
                            <td>{{ $d->cedula }}</td>
                            <td>{{ $d->b_sal }}</td>
                            <td>
                                @if($d->tipo == 0)
                                    Corriente.
                                @else
                                    Ahorro.
                                @endif
                            </td>
                            <td>{{ $d->cuenta }}</td>
                            <td>{{ $d->monto_into }}</td>
                            <td>{{ $d->monto_out }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                   </table>
                </div>
                
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection
@section('scripts')

@endsection