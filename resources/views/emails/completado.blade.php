
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
        por un monto {{ $frecuentes[0]->general_into }}{{ $frecuentes[0]->moneda_into }} ha sido procesado.
        
        
        <h4>Distribuido de la siguiente manera</h4>
        
        <hr>
            @foreach($frecuentes as $f)
        <br>
        
        <table style="margin: auto">
            <thead>
            <tr>
                <th colspan="2">Beneficiario</th>
                <th colspan="1">Trasferencia</th>
            </tr>
            </thead>
            
            <tbody>
            <tr><th>Titular </th><td>{{ $f->titular }}</td>

            <td>Referencia: {{ $f->referencia_out }}</td>
            
            </tr>
            <tr><th>Cedula</th><td>{{ $f->cedula }}</td>
                
                <td rowspan="7">
                    
                    @if($f->comprobante_out)
                        <img src="{{ asset(Storage::url($f->comprobante_out)) }}" alt="logo" style="width:200px;"  >
                    @endif
                    
                </td>
            
            </tr>
            <tr><th>Correo</th><td>{{ $f->correo }}</td>
            
            </tr>
            <tr><th>Banco</th><td>{{ $f->banco }}</td>
            
            </tr>
            <tr><th>Tipo de cuenta</th><td>{{ $f->tipo }}</td>
            
            </tr>
            <tr><th>N° de cuenta</th><td>{{ $f->cuenta }}</td>
            
            </tr>
            <tr><th>Monto {{ $frecuentes[0]->moneda_into }} </th>
                
                <td>{{ number_format($f->monto_into,2,",",".") }}</td>
            
            </tr>
            <tr><th>Monto {{ $frecuentes[0]->moneda_out }} </th><td>{{ number_format($f->monto_out,2,",",".") }}</td>
            
            </tr>
                </tbody>
        </table> 
            <hr>
            @endforeach
            
        
        
        
        <p><img src="{{ asset('images/logo2.png')}}" alt="logo" style="width:100px;"  >
            LocarRemesas agradece por preferirnos </p>
              
        
    </div>

    
</body>
</html>