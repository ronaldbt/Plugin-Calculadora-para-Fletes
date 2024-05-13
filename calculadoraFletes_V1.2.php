<?php
/*
Plugin Name: FletesPRO
Plugin URI: https://ronbhack.com
Description: Plugin para el calculo de fletes
Version: 1.2
*/


function Activar(){

}

function Desactivar (){

}
//AIzaSyBzvhrW2_3rNGkK7o3rZpkOGBkM66Zf37U
add_shortcode( "calculadora", function($atts, $content){
    $output = '
    
   
    <style>
    #map {
      width: 70%;
      height: 350px;
      margin-left: auto;
      margin-right: auto;
    }

    form {
      width: 70%;
      max-width: 600px;
      margin: 20px auto;
      padding: 20px;
      background-color: #f4f4f4;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      box-sizing: border-box;
    }

    /* Estilo adicional para los botones de radio y sus etiquetas */
    label.radio {
      display: inline-block;
      margin-right: 20px;
    }

    button {
      background-color: #3498db;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #2980b9;
    }

    #resultado {
      margin-top: 20px;
      padding: 15px;
      background-color: #e0e0e0;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      font-size: 18px;
      max-width: 400px;
      width: 80%;
      margin: 0 auto;
    }
  </style>
  
  <h1 style="text-align:center">Calculadora precio flete</h1>
  <div id="map"></div>
  <form style="text-align:center" id="form">
    <label for="origen">Origen:</label>
    <input type="text" id="origen" name="origen" />
    <br />
    <label for="destino">Destino:</label>
    <input type="text" id="destino" name="destino" />
    <br />
    <label>Tipo de Flete:</label>
    <label class="radio"><input type="radio" name="flete" value="metropolitana" checked>Flete Región Metropolitana</label>
    <label class="radio"><input type="radio" name="flete" value="regiones">Flete a Regiones</label>
    <br /><br />
    <div id="resultado"></div>
    <br />
    <button type="button" onclick="calcularRuta()">Mostrar Precio Flete</button>
  </form>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzvhrW2_3rNGkK7o3rZpkOGBkM66Zf37U&libraries=places"></script>
  <script>
    var chileBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(-56.0, -75.0),
      new google.maps.LatLng(-17.5, -66.0)
    );

    var origemAutocomplete = new google.maps.places.Autocomplete(document.getElementById("origen"), {
      bounds: chileBounds,
      strictBounds: true
    });

    var destinoAutocomplete = new google.maps.places.Autocomplete(document.getElementById("destino"), {
      bounds: chileBounds,
      strictBounds: true
    });

    var origemMarker = null;
    var destinoMarker = null;
    var result = null;

    var map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: -33.45032091136694, lng: -70.6454706835721 },
      zoom: 8,
    });
    
    var directionsRenderer = new google.maps.DirectionsRenderer({
      map: map,
    });

    function calcularRuta() {
      var origen = document.getElementById("origen").value;
      var destino = document.getElementById("destino").value;
      var tipoFlete = document.querySelector("input[name="flete"]:checked").value;

      if (origen == "" || destino == "") {
        alert("Por favor, complete ambos campos.");
      } else {
        var directionsService = new google.maps.DirectionsService();
        var request = {
          origin: origen,
          destination: destino,
          travelMode: "DRIVING",
        };

        directionsService.route(request, function (result, status) {
          if (status == "OK") {
            directionsRenderer.setDirections(result);
            window.result = result;
            mostrarResultado(tipoFlete);
          } else {
            alert("No fue posible calcular la ruta.");
          }
        });
      }
    }

    function mostrarResultado(tipoFlete) {
      if (window.result) {
        var distancia = window.result.routes[0].legs[0].distance.value / 1000;
        var precioFlete = 0;

        if (tipoFlete === "metropolitana") {
          precioFlete = 15000 + distancia * 1300;
        } else if (tipoFlete === "regiones") {
          precioFlete = distancia * 900;
        }

        document.getElementById("resultado").innerHTML = "Distancia: " + distancia.toFixed(2) + " km<br>Precio: $" + precioFlete.toFixed(2) + " CLP";
      } else {
        alert("Primero calcule la ruta antes de mostrar el resultado.");
      }
    }
  </script>
  
    ';
    return $output;
   });


register_activation_hook(__FILE__,'Activar');
register_deactivation_hook(__FILE__,'Desactivar');