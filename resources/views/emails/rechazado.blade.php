
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
        por un monto {{ $frecuentes[0]->general_into }}{{ $frecuentes[0]->moneda_into }} ha sido rechazado. 
        Para mas informacion comuniquese a atencionalcliente@localremesas.com o via whatsapp +51 961 451647 o al +51 915 013559. 
            
        <p><img src="{{ asset('images/logo2.png')}}" alt="logo" style="width:100px;"  >
            LocarRemesas agradece por preferirnos </p>
              
        
    </div>

    
</body>
</html>