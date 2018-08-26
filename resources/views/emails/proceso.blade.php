
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    <div id="app">
        Buen dia, LocalRemesas le informa que el deposito cargado el dia {{ $frecuentes[0]->fecha_into }} 
        por un monto {{ $frecuentes[0]->general_into }}{{ $frecuentes[0]->moneda_into }} esta siendo procesado.
        
        
        <h4>Distribuido de la siguiente manera</h4>
        
        <table border="1">
            <tr>
                <th>Titular </th>
                <th>Cedula</th>
                <th>Correo</th>
                <th>Banco</th>
                <th>Tipo de cuenta</th>
                <th>N° de cuenta</th>
                <th>Monto {{ $frecuentes[0]->moneda_into }} </th>
                <th>Monto {{ $frecuentes[0]->moneda_out }} </th>
            </tr>
            @foreach($frecuentes as $f)
                <tr>
                    <td>{{ $f->titular }}</td>
                    <td>{{ $f->cedula }}</td>
                    <td>{{ $f->correo }}</td>
                    <td>{{ $f->banco }}</td>
                    <td>{{ $f->tipo }}</td>
                    <td>{{ $f->cuenta }}</td>
                    <td>{{ number_format($f->monto_into,2,",",".") }}</td>
                    <td>{{ number_format($f->monto_out,2,",",".") }}</td>
                </tr>
            @endforeach
            
        </table>
        
        
        <p><img src="{{ asset('images/logo2.png')}}" alt="logo" style="width:100px;"  >
            LocarRemesas agradece por preferirnos </p>
              
        
    </div>

    
</body>
</html>