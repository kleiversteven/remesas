<!DOCTYPE html>
<html lang="{{ app()->getLocale('es') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    <div id="app">
        
        <font color="#0048B7"><b >{{ $name }}</b>, ¡Bienvenid@ a</font> <a href="www.LocalRemesas.com" target="_blank">www.LocalRemesas.com</a>
        <br>
        LocalRemesas le ofrece la oportunidad de procesar de manera segura las transferencias de remesas a sus amigos y familiares en Venezuela.
        
        <b>Seguridad confianza y puntualidad en tus envios de dinero.</b>
        
        Con su nueva cuenta, podra:
        <ul>
            <li>Realizar depositos a sus familiares y amigos en venezuela.</li>
            <li>Consultar estatus de sus transferencias.</li>
        </ul>        
        <h3>Para validar su cuenta de correo has click <a href="{{url('/activacion/'.$code) }}">Aqui</a></h3>
    </div>

    
</body>
</html>