@extends('layouts.adm')

@section('content')
<div class="page-content-inner">
                            <div class="row widget-row">
                                <div class="col-md-3">
                                    <!-- BEGIN WIDGET THUMB -->
                                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                        <h4 class="widget-thumb-heading">Precio del dolar</h4>
                                        <div class="widget-thumb-wrap">
                                            <i class="widget-thumb-icon bg-green fa fa-money"></i>
                                            <div class="widget-thumb-body">
                                                <span class="widget-thumb-subtitle">USD</span>
                                                <span class="widget-thumb-body-stat" >{{ $dolar }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END WIDGET THUMB -->
                                </div>
                                <div class="col-md-3">
                                    <!-- BEGIN WIDGET THUMB -->
                                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                        <h4 class="widget-thumb-heading">Precio del sol</h4>
                                        <div class="widget-thumb-wrap">
                                            <i class="widget-thumb-icon bg-red fa fa-money"></i>
                                            <div class="widget-thumb-body">
                                                <span class="widget-thumb-subtitle">PEN</span>
                                                <span class="widget-thumb-body-stat">{{ $sol }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END WIDGET THUMB -->
                                </div>
                                <div class="col-md-3">
                                    <!-- BEGIN WIDGET THUMB -->
                                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                        <h4 class="widget-thumb-heading"><a href="{{ url('misdepositos') }}" >Mis depositos</a></h4>
                                        <div class="widget-thumb-wrap">
                                            <i class="widget-thumb-icon bg-purple icon-screen-desktop"></i>
                                            <a class="widget-thumb-body">
                                                <span class="widget-thumb-subtitle"></span>
                                                <span class="widget-thumb-body-stat">{{ $depositos }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END WIDGET THUMB -->
                                </div>
                                <div class="col-md-3">
                                    <!-- BEGIN WIDGET THUMB -->
                                    <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                                        <h4 class="widget-thumb-heading"><a href="{{ url('misdepositos') }}" >Transacciones completas</a></h4>
                                        <div class="widget-thumb-wrap">
                                            <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                                            <a class="widget-thumb-body">
                                                <span class="widget-thumb-subtitle"></span>
                                                <span class="widget-thumb-body-stat">{{ $procesados }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- END WIDGET THUMB -->
                                </div>
                            </div>
</div>
@if($parametros['BLOQUEO']['status'] == 1)
<div class="alert alert-info">
  <strong>Advertencia!</strong> la carga de pedidos ha sido deshabilitada debido:
    <p>
       &nbsp; &nbsp; &nbsp; {{ $parametros['BLOQUEO']['motivo'] }}
    </p>
</div>
@endif

@endsection