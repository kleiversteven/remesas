@extends('layouts.adm')
@section('otroscss')
    
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Reportar pago en efectivo</div>
                <div class="tools"> <b class="btn btn-success" onclick="reportar()">Reportar pago</b></div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Deposito</th>
                            <th class="all">Monto</th>
                            <th class="all">Moneda</th>
                            <th class="all">Fecha</th>
                            <th class="all small">Seleccionar</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($depositos as $d)
                        <tr class=" {{ $d->mnd_ent_desc }} ">
                            <td>{{ str_pad($d->codeefec,8,0,STR_PAD_LEFT) }}</td>
                            <td>{{ $d->monto_into }}</td>
                            <td>{{ $d->mnd_ent_desc }}</td>
                            <td>{{ $d->fecha_into }}</td>
                            <td><input type="checkbox" onclick="agregar(this)" data-id="{{$d->codeefec}}" data-iso="{{$d->mnd_ent_iso }}" class="form-control checkbox"></td>
                            
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
    var iso='';
    
    function reportar(){
        var lista=[];
        var p=0;
        $( ".checkbox" ).each(function( i ) {
            if($(this).is(':checked')){
                lista[p]=$(this).data('id');
                p++;
            }
          
        });
       
    }
    function agregar(e){
        var isob = $(e).data('iso');
        if(iso == isob)
            iso = $(e).data('iso');
    }
</script>
@endsection