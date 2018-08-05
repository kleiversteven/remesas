
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    <div id="app">
        
        Buen dia: <font color="#0048B7"><b >{{ $mensaje['name'] }}</b> </font>
        <p>
            &nbsp; &nbsp; &nbsp; Su trasferencia ha sido registrada el dia {{ $mensaje['fecha'] }}.
        </p>
        <table style="width: 250px;text-align: center;border: solid;background: #ffe9aa;border-width: 1px;">
                <tr><td> <b> Recibo de trasferencia </b></td></tr>
                <tr><td>{{ str_pad($mensaje['codigo'],8,0,STR_PAD_LEFT) }}</td></tr>
                <tr><td>N° de operacion {{ $mensaje['referencia'] }}</td></tr>
                <tr><td>De:{{ $mensaje['moneda_into'] }}  A:  {{ $mensaje['moneda_out'] }}</td></tr>
                <tr><td>Tasa de cambio: {{ $mensaje['tasa'] }}</td></tr>
                <tr><td>Monto depositado: {{ number_format($mensaje['ingreso'],2,",",".") }}</td></tr>
                <tr><td>Monto convertido: {{ number_format($mensaje['salida'],2,",",".") }}</td></tr>
                <tr><td></td></tr>
        </table>
        
        <p><img src="{{ asset('images/logo2.png')}}" alt="logo" style="width:100px;"  >
            LocarRemesas agradece por preferirnos </p>
              
        
    </div>

    
</body>
</html>