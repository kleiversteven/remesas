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
                    <i class="fa fa-globe"></i>Depositos en efectivo</div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Deposito</th>
                            <th class="all">Monto</th>
                            <th class="all">Fecha</th>
                            <th class="all">Estatus</th>
                            <th class="all"> </th>
                            <th class="none">N° de operacion:</th>
                            <th class="none">De:</th>
                            <th class="none">A:</th>
                            <th class="none">Tasa de cambio:</th>
                            <th class="none">Trasferido:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($depositos as $d)
                        <tr>
                            <td>{{ str_pad($d->codeefec,8,0,STR_PAD_LEFT) }}</td>
                            <td>{{ $d->monto_into }}</td>
                            <td>{{ $d->fecha_into }}</td>
                            <td>
                                
                                @if($d->estatus == 1)
                                    <span class="label label-info"> Sin procesar </span>
                                @elseif($d->estatus == 2)
                                    <span class="label label-danger"> Rechazado </span>
                                @elseif($d->estatus == 3)
                                    <span class="label label-primary"> Transferencia en progreso </span>
                                @elseif($d->estatus == 4)
                                    <span class="label label-success"> Transacción completa </span>
                                @endif
                            </td>
                            <td>
                                @if($d->estatus == 4 || $d->estatus == 5)
                                    <a href="{{ url('informacionefectivo/'.$d->codeefec) }}" class="btn btn-primary fa fa-eye" ></a>
                                @endif
                            </td>
                            <td>{{ $d->codeefec }}</td>
                            <td>{{ $d->mnd_ent_desc }}</td>
                            <td>{{ $d->mnd_sal_desc }}</td>
                            <td>{{ number_format($d->tasa,2,",",".") }}</td>
                            <td>{{ number_format($d->monto_out,2,",",".") }}</td>
                            
                            
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

@endsection