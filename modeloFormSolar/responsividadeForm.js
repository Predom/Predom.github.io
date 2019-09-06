var energia_input = window.document.getElementById("energia");
var jan_input = window.document.getElementById("Consumo_jan");
var fev_input = window.document.getElementById("Consumo_fev");
var mar_input = window.document.getElementById("Consumo_mar");
var abr_input = window.document.getElementById("Consumo_abr");
var mai_input = window.document.getElementById("Consumo_mai");
var jun_input = window.document.getElementById("Consumo_jun");
var jul_input = window.document.getElementById("Consumo_jul");
var ago_input = window.document.getElementById("Consumo_ago");
var set_input = window.document.getElementById("Consumo_set");
var out_input = window.document.getElementById("Consumo_out");
var nov_input = window.document.getElementById("Consumo_dez");
var dez_input = window.document.getElementById("Consumo_nov");

var energia_input_label = window.document.getElementById("energia_label");
var jan_input_label = window.document.getElementById("Consumo_jan_label");
var fev_input_label = window.document.getElementById("Consumo_fev_label");
var mar_input_label = window.document.getElementById("Consumo_mar_label");
var abr_input_label = window.document.getElementById("Consumo_abr_label");
var mai_input_label = window.document.getElementById("Consumo_mai_label");
var jun_input_label = window.document.getElementById("Consumo_jun_label");
var jul_input_label = window.document.getElementById("Consumo_jul_label");
var ago_input_label = window.document.getElementById("Consumo_ago_label");
var set_input_label = window.document.getElementById("Consumo_set_label");
var out_input_label = window.document.getElementById("Consumo_out_label");
var nov_input_label = window.document.getElementById("Consumo_nov_label");
var dez_input_label = window.document.getElementById("Consumo_dez_label");

function set_media(){
  energia_input.type='number';
  jan_input.type='hidden';
  fev_input.type=`hidden`;
  mar_input.type='hidden';
  abr_input.type='hidden';
  mai_input.type='hidden';
  jun_input.type='hidden';
  jul_input.type='hidden';
  ago_input.type='hidden';
  set_input.type='hidden';
  out_input.type='hidden';
  nov_input.type='hidden';
  dez_input.type='hidden';


  energia_input_label.style.display = "inline";
  jan_input_label.style.display = "none";
  fev_input_label.style.display = "none";
  mar_input_label.style.display = "none";
  abr_input_label.style.display = "none";
  mai_input_label.style.display = "none";
  jun_input_label.style.display = "none";
  jul_input_label.style.display = "none";
  ago_input_label.style.display = "none";
  set_input_label.style.display = "none";
  out_input_label.style.display = "none";
  nov_input_label.style.display = "none";
  dez_input_label.style.display = "none";
}
function set_mesames(){
  //energia_input.value = "30";
  energia_input.type='hidden';
  jan_input.type='number';
  fev_input.type=`number`;
  mar_input.type='number';
  abr_input.type='number';
  mai_input.type='number';
  jun_input.type='number';
  jul_input.type='number';
  ago_input.type='number';
  set_input.type='number';
  out_input.type='number';
  nov_input.type='number';
  dez_input.type='number';




  energia_input_label.style.display = "none";
  jan_input_label.style.display = "inline";
  fev_input_label.style.display = "inline";
  mar_input_label.style.display = "inline";
  abr_input_label.style.display = "inline";
  mai_input_label.style.display = "inline";
  jun_input_label.style.display = "inline";
  jul_input_label.style.display = "inline";
  ago_input_label.style.display = "inline";
  set_input_label.style.display = "inline";
  out_input_label.style.display = "inline";
  nov_input_label.style.display = "inline";
  dez_input_label.style.display = "inline";
}




/*
<input type="number" id="energia" name="energia" step="any" min="1" value="" onchange="copia(this.value)" required/><spam>  kWh<spam/>
<input type="hidden" id="Consumo_jan" name="Cjan" step="any" min="1" />
<input type="hidden" id="Consumo_fev" name="Cfev" step="any" min="1" />
<input type="hidden" id="Consumo_mar" name="Cmar" step="any" min="1" />
<input type="hidden" id="Consumo_abr" name="Cabr" step="any" min="1" />
<input type="hidden" id="Consumo_mai" name="Cmai" step="any" min="1" />
<input type="hidden" id="Consumo_jun" name="Cjun" step="any" min="1" />
<input type="hidden" id="Consumo_jul" name="Cjul" step="any" min="1" />
<input type="hidden" id="Consumo_ago" name="Cago" step="any" min="1"/>
<input type="hidden" id="Consumo_set" name="Cset" step="any" min="1" />
<input type="hidden" id="Consumo_out" name="Cout" step="any" min="1" />
<input type="hidden" id="Consumo_nov" name="Cnov" step="any" min="1" />
<input type="hidden" id="Consumo_dez" name="Cdez" step="any" min="1"/>*/
