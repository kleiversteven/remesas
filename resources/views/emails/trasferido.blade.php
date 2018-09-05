
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    <div id="app">
        
        LocalRemesas ha recibido un nuevo deposito gracias a  <b >{{ $mensaje['name'] }}</b>
        con el correo {{ $mensaje['email'] }}
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
        <h4>Distribuido de la siguiente manera</h4>
        <?php $i=0; 
            $tasa_new= $mensaje['salida']/$mensaje['ingreso'];
        ?>
        @foreach($mensaje['data']['frecuente'] as $f)
            <?php 
                $montos[$f] = $mensaje['data']['montofrecuente'][$i];
                $i++;
            ?>
        @endforeach
        <table border="1">
            <tr>
                <th>Titular </th>
                <th>Cedula</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Banco</th>
                <th>Tipo de cuenta</th>
                <th>N° de cuenta</th>
                <th>Monto {{ $mensaje['moneda_into'] }}</th>
                <th>Monto {{ $mensaje['moneda_out'] }}</th>
            </tr>
             <?php for($i=0;$i < count($mensaje['frecuente']);$i++ ){ ?>
                <tr>
                    <td>{{ $mensaje['frecuente'][$i]->titular }}</td>
                    <td>{{ $mensaje['frecuente'][$i]->cedula }}</td>
                    <td>{{ $mensaje['frecuente'][$i]->correo }}</td>
                    <td>
                        {{ $mensaje['frecuente'][$i]->telefono }}
                        @if(!empty($mensaje['frecuente'][$i]->telefono))
                       <a href="api.whatsapp.com/send?phone={{ $mensaje['frecuente'][$i]->telefono }}&text=Bienvenido a localremesas">
                            <img src="{{ asset('images/ico-ws.png')}}" style="width: 20px;height: 20px" />
                       </a>
                        @endif
                    </td>
                    <td>{{ $mensaje['frecuente'][$i]->banco }}</td>
                    <td>
                        @if( $mensaje['frecuente'][$i]->tipo == 0)
                            Corriente
                        @else
                            Ahorro
                        @endif
                    </td>
                    <td>{{ $mensaje['frecuente'][$i]->cuenta }}</td>
            
                    <td>{{ number_format($montos[$mensaje['frecuente'][$i]->codefrec],2,",",".") }}</td>
                    <td>{{ number_format($tasa_new*$montos[$mensaje['frecuente'][$i]->codefrec],2,",",".") }}</td>
                </tr>
            <?php } ?>
        </table>
              
        
    </div>

    
</body>
</html>