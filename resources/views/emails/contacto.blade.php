
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    <div id="app">
        
        Nuevo mensaje de: <font color="#0048B7"><b >{{ $mensaje['name'] }}</b> </font>
        @if(!empty($mensaje['phone']))
            <br>Telefono: {{ $mensaje['phone'] }}
        @endif
            <br>Correo: {{ $mensaje['email'] }}
        <br>
        
        <p>{{ $mensaje['mensaje'] }}</p>
              
        
    </div>

    
</body>
</html>