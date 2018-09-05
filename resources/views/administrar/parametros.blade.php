@extends('layouts.adm')

@section('otroscss')
    <style>
* {box-sizing: border-box}
body {font-family: "Lato", sans-serif;}

/* Style the tab */
.tab {
    float: left;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    width: 30%;
    height: 300px;
}

/* Style the buttons inside the tab */
.tab button {
    display: block;
    background-color: inherit;
    color: black;
    padding: 22px 16px;
    width: 100%;
    border: none;
    outline: none;
    text-align: left;
    cursor: pointer;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    float: left;
    padding: 0px 12px;
    border: 1px solid #ccc;
    width: 70%;
    border-left: none;
    height: 300px;
}
</style>
@endsection
@section('content')

@if(!empty(session('mensaje')))
<div class="alert alert-success">
  <strong>Completado!</strong> {{session('mensaje')}}.
</div>
@endif

<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'modulo')" id="defaultOpen">Bloquear</button>

</div>

<div id="modulo" class="tabcontent">
  <h3>Depositos</h3>
  <div class="form-body"> 
        <div class="col-md-12">
        <div class="form-group">
            <textarea class="form-control" placeholder="Motivo de bloqueo" id="motivo">{{ $parametros['BLOQUEO']['motivo'] }}</textarea>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
            <input class="form-control" @if($parametros['BLOQUEO']['status']==1) checked @endif type="checkbox" id='checkblock'><label>Bloquear carga de depositos</label>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
            <center>
                <button onclick="bloquear()" class="btn btn-primary" >Guardar</button>
            </center>
        </div>
      </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    
   function bloquear(){
        if($('#checkblock').is(':checked')){
            $.get('{{ url("bloqdepositos")}}','check=1'+'&motivo='+$('#motivo').val(),function(){
                alertify.success("Modulos de pedidos activado");
            })
        }else{
             $.get('{{ url("bloqdepositos")}}','check=0'+'&motivo='+$('#motivo').val(),function(){
                alertify.success("Modulos de pedidos desactivado");
            })
        }
    }
    
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
    
    
</script>
@endsection