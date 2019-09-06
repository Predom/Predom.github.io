var map = L.map('map').setView([-27.5942, -48.5425], 15);

L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
    maxZoom: 18,
}).addTo(map);

var theMarker = {};

map.on('click',function(newMarker){
  var lat = newMarker.latlng.lat;
  var lon = newMarker.latlng.lng;

  document.getElementById("latitude").value = lat;
  document.getElementById("longitude").value = lon;

  //teste para ver se estava conseguindo as coordenadas
  //console.log("Informações do local selecionado:")
  //console.log("LATITUDE: "+ lat);
  //console.log("LONGITUDE: "+lon);
        //Retirar o marcador existente

  if (theMarker != undefined) {
    map.removeLayer(theMarker);
  };

  //Adicionar marcador onde você clicou
  theMarker = L.marker([lat,lon]).addTo(map);
});

function copia(valor){
  var energia1 = document.getElementById("energia").value;
  var resultado = parseFloat(energia1);

  document.getElementById("Consumo_jan").value = resultado;
  document.getElementById("Consumo_fev").value = resultado;
  document.getElementById("Consumo_mar").value = resultado;
  document.getElementById("Consumo_abr").value = resultado;
  document.getElementById("Consumo_mai").value = resultado;
  document.getElementById("Consumo_jun").value = resultado;
  document.getElementById("Consumo_jul").value = resultado;
  document.getElementById("Consumo_ago").value = resultado;
  document.getElementById("Consumo_set").value = resultado;
  document.getElementById("Consumo_out").value = resultado;
  document.getElementById("Consumo_nov").value = resultado;
  document.getElementById("Consumo_dez").value = resultado;
}
