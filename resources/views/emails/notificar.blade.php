
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    <div id="app">
        Buen dia, LocalRemesas le informa que ha realizado una trasferencia el dia {{ date("d-m-Y") }} a la cuenta  {{ $frecuentes->tipo }} 
        del {{ $frecuentes->banco }} al numero de cuenta {{ $frecuentes->cuenta }} por un monto de 
        {{ number_format($frecuentes->monto_out,2,",",".") }} BsS que corresponden  a 
        {{ number_format($frecuentes->monto_into,2,",",".") }} {{ $frecuentes->descripcion }} 
        <p>
        @if($frecuentes->comprobante_out)
            <img src="{{ asset(Storage::url($frecuentes->comprobante_out)) }}" alt="logo" style="width:400px;"  >
        @endif
       </p>
        
        <p><img src="{{ asset('images/logo2.png')}}" alt="logo" style="width:100px;"  >
            LocarRemesas agradece por preferirnos </p>
              
        
    </div>

    
</body>
</html>