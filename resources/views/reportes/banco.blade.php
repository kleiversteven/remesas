<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte</title>
    <style>
        #header{
            border-bottom: solid;
        }
        #header table th{
            text-align: center;
        }
        #header table{
            width: auto;
        }
        .right{
            text-align: right;
        }
        .center{
            text-align: center;
        }
        table{
            width:  100%;
            border-spacing: initial;
        }
    </style>
</head>

<body>
    <div id="header">
        
        <table>
        <tr>
            <td><img src="{{ asset('images/logo2.png')}}" alt="logo" style="width:100px; margin-top: 7px;"  ></td>
            <th> <h3>Reporte de movimientos</h3></th>         
        </tr>
        </table>
    </div>
    <br>
        <div class="right" >Reporte generado el {{ ucwords(strftime("%A %d de %B del %Y" ))  }} </div>
    <br>
    <fieldset>
        <legend>Informacion General</legend>
        
        <table>
           
            <tr>
                <td colspan="4">
                    @if($resumido== 0)
                        El repote a continuacion muestra las transaciones generadas desde {{ $desde }} hasta {{ $hasta }} 
                    identificadas por banco.
                    @elseif($resumido == 1)
                         El repote a continuacion muestra el total de transaciones generadas desde {{ $desde }} hasta {{ $hasta }} por banco.
                    @endif
                </td>
            </tr>
        </table>
    </fieldset>
    <br>
    
    <?php $i=1; ?>
    <div class="container" >
        <h3>Listado de operaciones</h3>
        <table border="1">
            
            @if($resumido == 0)
                <tr>
                    <th>N°</th>
                    <th>Banco</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                </tr>
                 @foreach($depositos as $d)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td class="center">{{ $d->banco }}</td>
                        <td class="center">{{ $d->fecha_into }}</td>
                        <td class='right'>{{ number_format($d->monto_into,2,",",".") }}</td>
                    </tr>
                 @endforeach
            @elseif($resumido == 1)
                <tr>
                    <th>Operaciones</th>
                    <th>Banco</th>
                    <th>Monto</th>
                </tr>
                 @foreach($depositos as $d)
                    <tr>
                        <td class="center">{{ $d->movimientos }}</td>
                        <td class="center">{{ $d->banco }}</td>
                        <td class='right'>{{ number_format($d->monto,2,",",".") }}</td>
                    </tr>
                 @endforeach
            @endif
        </table>
    </div>
</body>
</html>