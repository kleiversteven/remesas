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
            <th> <h3>Reporte de seguimiento</h3></th>         
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
                    El repote a continuacion muestra el total de transaciones generadas desde {{ $desde }} hasta {{ $hasta }},
                    agrupado por los tipos de usuarios existentes, y tipo de moneda de cambio.
                </td>
            </tr>
        </table>
    </fieldset>
    <?php

$i=1;
    ?>
  
    <br>
    <div class="container" >
        <h3>Listado de operaciones</h3>
        <table border="1">
            <tr>
                <th>N°</th>
                <th>Tipo de usuario</th>
                <th>Nombre</th>
                <th>Moneda</th>
                <th>Entrada</th>
                <th>Salida</th>
            </tr>
             @foreach($depositos as $d)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td class="center">{{ $d->name }}</td>
                    <td class="center">{{ $d->nombre }}</td>
                    <td class="center">{{ $d->descripcion }}</td>
                    <td class='right'>{{ number_format($d->monto_entrada,2,",",".") }}</td>
                    <td class='right'>{{ number_format($d->monto_salida,2,",",".") }}</td>
                    
                </tr>
             @endforeach        
        </table>
    </div>
</body>
</html>