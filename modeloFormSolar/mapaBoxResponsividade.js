var mapaExpandivel = map;
var mapTit = window.document.getElementById("mapTit");


function expandir(){
  mapaExpandivel.style.width="100%";
  mapaExpandivel.style.heigth="400px";
  mapaExpandivel.style.borderRadius="0px";
  mapTit.style.textAlign="center";
  map.invalidateSize()
}
function retrair(){
  mapaExpandivel.style.width="200px";
  mapaExpandivel.style.heigth="200px";
  mapTit.style.textAlign="left";
  mapaExpandivel.style.borderRadius="50%";
  mapaExpandivel.style.borderBottomRightRadius="0px";
  map.invalidateSize()
}
