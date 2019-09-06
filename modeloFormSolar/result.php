<html lang="pt-br">

<head>
<meta charset="UTF-8"/>

<title>REPOSTAS</title>

<link rel="stylesheet" href="lib/leaflet/leaflet.css"/>

<script src="lib/leaflet/leaflet.js"></script>


</head>
<style>
div#map {height:400px;
width:400px;};

div#mapArea{
    border-width:5px;
    border-style:solid;
	color: #F0EA2C;
};

.tabela{

}


</style>

<body>
<?php
	$erro = "";

	$dias = 30;
	$dias1 = 31;
	$dias2 = 28;



	//LAT E LON do mapa
	$lat = $_POST["lat"];
	$lon = $_POST["lon"];
	$Flat = str_replace(',', '.', $lat);
	$Flon =	str_replace(',', '.', $lon);

	//Consumo dos meses
	$Cjan = $_POST["Cjan"];
	$Cfev = $_POST["Cfev"];
	$Cmar = $_POST["Cmar"];
	$Cabr = $_POST["Cabr"];
	$Cmai = $_POST["Cmai"];
	$Cjun = $_POST["Cjun"];
	$Cjul = $_POST["Cjul"];
	$Cago = $_POST["Cago"];
	$Cset = $_POST["Cset"];
	$Cout = $_POST["Cout"];
	$Cnov = $_POST["Cnov"];
	$Cdez = $_POST["Cdez"];

	//Consumo médio
	$ConMed = ($Cjan+$Cfev+$Cmar+$Cabr+$Cmai+$Cjun+$Cjul+$Cago+$Cset+$Cout+$Cnov+$Cdez)/12;


	//Tipo de ligação
	$tLig = $_POST["tLig"];

	if($tLig == 30){
		$TipoDeLig = "Grupo B1 - Monofásico";
		$mono="checked";
		$bi="nulo";
		$tri="nulo";
		$cem="nulo";
	}elseif($tLig == 50){
		$TipoDeLig = "Grupo B1 - Bifásico";
		$mono="nulo";
		$bi="checked";
		$tri="nulo";
		$cem="nulo";
	}elseif($tLig == 100){
		$TipoDeLig = "Grupo B1 - Trifásico";
		$mono="nulo";
		$bi="nulo";
		$tri="checked";
		$cem="nulo";
	}elseif($tLig == 1){
		$TipoDeLig = "Dimensionamento para 100% do consumo";
		$mono="nulo";
		$bi="nulo";
		$tri="nulo";
		$cem="checked";
	}


	//Preço por kWh
	$preco = $_POST["preco"];
	//-----------------------------------------------
	//Valores pré definidos*************************

	//Potencia de pico do módulo
	$pico = $_POST["pico"];

	//eficiência do módulo
	$efic = $_POST["efic"];

	$Fefic = str_replace(',', '.', $efic);

	//Dimensões do módulo
	$comp = $_POST["comp"];
	$larg = $_POST["larg"];

	//Taxa de desempenho do sistema
	$td = $_POST["td"];

	//taxa de eficiencia do inversor
	$inv = $_POST["inv"];




	$con = pg_connect("host=localhost port=5432 dbname=teste password=123456");

	$res = pg_query($con, "select * from(
SELECT "LON", "LAT","ANNUAL","JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC",
(6371 * acos(
 cos( radians(-27.595119) )
 * cos( radians( "LAT" ) )
 * cos( radians( "LON" ) - radians(-48.545989) )
 + sin( radians(-27.595119) )
 * sin( radians( "LAT" ) )
 )) AS dist FROM global_horizontal) al
where dist < 30
ORDER BY dist ASC
LIMIT 1;");

	// Fazer o campo das coordenadas ser obrigatório
	if(empty($lat)){
		$erro = "style='display: none;'";
		echo"Por favor, escolha um ponto do mapa";
		echo"<form>
<input type='button' value='Voltar' onClick='JavaScript: window.history.back();'>
</form>";}
elseif($ConMed < $tLig){
	$erro = "style='display: none;'";
	echo"A instalação de um sistema FV não é recomendada.</br>";
	echo"Seu consumo médio é menor ou igual à taxa de disponibilidade da concessionária de distribuição de energia";
		echo"<form>
<input type='button' value='Voltar' onClick='JavaScript: window.history.back();'>
</form>";}
else{
	if(pg_num_rows($res) == 0){
		$erro = "style='display: none;'";
	echo"Por favor, escolha um ponto dentro do Brasil";
	echo"<form>
<input type='button' value='Voltar' onClick='JavaScript: window.history.back();'>
</form>";
pg_close($con);
	} else{
	while($vreg=pg_fetch_row($res)){
		$vlon=$vreg[0];
		$vlat=$vreg[1];
    $vano=$vreg[2];
		$vjan=$vreg[3];
		$vfev=$vreg[4];
		$vmar=$vreg[5];
		$vabr=$vreg[6];
		$vmai=$vreg[7];
		$vjun=$vreg[8];
		$vjul=$vreg[9];
		$vago=$vreg[10];
		$vset=$vreg[11];
		$vout=$vreg[12];
		$vnov=$vreg[13];
		$vdez=$vreg[14];



	pg_close($con);
	}



	//Orientação do módulo
	if($Flat<0){
		$orientacao = "Norte";
	}elseif($Flat=0){
		$orientacao = "Sul ou Norte";
	}
	else{
		$orientacao = "Sul";
	}


	//inclinação do módulo
	$inclinacao = round(abs($Flat));


	//Consumo total
	$Con = $Cjan+$Cfev+$Cmar+$Cabr+$Cmai+$Cjun+$Cjul+$Cago+$Cset+$Cout+$Cnov+$Cdez;

	if ($tLig > 10){
	$ConTot = $Con - $tLig;
	}else{
	$ConTot = $Con;
	}




	echo"$ConTot";


	//função da potencia do sistema
	function potencia($E,$Irrad,$Taxa){
		return ($E*1)/(($Irrad/1000)*365*($Taxa/100));
	}

	$Pfv = potencia($ConTot,$vano,$td);

	//Número de módulos
	$Nmod = ceil ($Pfv/($pico/1000));

	//Àrea do módulo
	$Fcomp = str_replace(',', '.', $comp);
	$Flarg = str_replace(',', '.', $larg);
	$Fareamod = $Fcomp * $Flarg;

	//ENERGIA GERADA*********************************************************************
	include 'calculo.php';
	}
	}

?>
<div id="respostas" <?php echo"$erro"; ?>>
Sua localização geográfica:<br/>

Latitude: <?php echo"$lat"; ?> <br/>
Longitude: <?php echo"$lon"; ?> <br/><br/>

<div id="localizacaoescolhida">
<div id="map"></div>
<script>
var map = L.map('map').setView([<?php echo"$lat"; ?>, <?php echo"$lon"; ?>], 13);
var popup = L.popup();
L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
    maxZoom: 18,
}).addTo(map);

L.marker([<?php echo"$lat"; ?>, <?php echo"$lon"; ?>]).addTo(map)
		.bindPopup("<b>Ponto Escolhido</b><br />Teste").openPopup();

L.circle([<?php echo"$lat"; ?>, <?php echo"$lon"; ?>], 500, {
		color: 'red',
		fillColor: '#f03',
		fillOpacity: 0.5
	}).addTo(map).bindPopup("I am a circle.");


	map.dragging.disable();
map.touchZoom.disable();
map.doubleClickZoom.disable();
map.scrollWheelZoom.disable();
map.boxZoom.disable();
map.keyboard.disable();
if (map.tap) map.tap.disable();
document.getElementById('map').style.cursor='default';
</script>
</div>


Localização do banco de dados mais próxima ao ponto escolhido:<br/>
Latitude: <?php echo"$vlat"; ?> <br/>
Longitude: <?php echo"$vlon"; ?> <br/>


<table border="1">
<caption>Valores de irradiação do local (W/m²/dia)</caption>
<tr>
	<td>Janeiro</td><td>Fevereiro</td><td>Março</td><td>Abril</td><td>Maio</td><td>Junho</td><td>Julho</td><td>Agosto</td>
	<td>Setembro</td><td>Outubro</td><td>Novembro</td><td>Dezembro</td><td>Anual</td>
</tr>

<tr>
<td><?php echo"$vjan"; ?></td><td><?php echo "$vfev"; ?></td><td><?php echo"$vmar"; ?></td><td><?php echo"$vabr"; ?></td><td><?php echo"$vmai"; ?></td>
<td><?php echo"$vjun"; ?></td><td><?php echo"$vjul"; ?></td><td><?php echo"$vago"; ?></td><td><?php echo"$vset"; ?></td><td><?php echo"$vout"; ?></td>
<td><?php echo"$vnov"; ?></td><td><?php echo"$vdez"; ?></td><td><?php echo"$vano"; ?></td>
</tr><br/>


<h3>Sobre o seu sistema</h3>

Consumo médio por mês:<?php echo"$ConMed"; ?> kWh<br/>
Consumo total em um ano: <?php echo"$Con"; ?> kWh<br/>
Potência do sistema: <?php echo"$Pfv"; ?> kW<br/><br/>

Potência de pico do módulo: <?php echo"$pico"; ?> kW<br/>
Área do módulo: <?php echo"$Fareamod"; ?> kW<br/>
Eficiência do módulo: <?php echo"$efic"; ?> kW<br/>
Taxa de desempenho do sistema: <?php echo"$td"; ?> kW<br/>
Taxa de eficiência do inversor: <?php echo"$inv"; ?> kW<br/>
Número de módulos: <?php echo"$Nmod"; ?> módulos de <?php echo"$pico"; ?> watts.<br/>


<h3>Orientação e inclinação dos módulos</h3>
Orientação recomendada: <?php echo"$orientacao"; ?> <br/>

Inclinação recomendada: <?php echo"$inclinacao"; ?> <br/><br/>


<h3>Energia gerada no primeiro ano:</h3>
<?php echo"$TipoDeLig"; ?><br/><br/>
Janeiro: <?php echo"$Ejan1"; ?> kW<br/>
Fevereiro: <?php echo"$Efev1"; ?> kW<br/>
Março:<?php echo"$Emar1"; ?> kW<br/>
Abril:<?php echo"$Eabr1"; ?> kW<br/>
Maio:<?php echo"$Emai1"; ?> kW<br/>
Junho:<?php echo"$Ejun1"; ?> kW<br/>
Julho:<?php echo"$Ejul1"; ?> kW<br/>
Agosto:<?php echo"$Eago1"; ?> kW<br/>
Setembro:<?php echo"$Eset1"; ?> kW<br/>
Outubro:<?php echo"$Eout1"; ?> kW<br/>
Novembro:<?php echo"$Enov1"; ?> kW<br/>
Dezembro:<?php echo"$Edez1"; ?> kW<br/><br/>

Total de energia gerada pelo sistema:<?php echo"$EnergTotAno1"; ?> kW<br/><br/>

<h4>DADOS DE JANEIRO ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRedejan1"; ?> kWh<br/>
Quantidade de energia paga: <?php echo"$EPagajan1"; ?> kWh<br/>
Conta de luz do mês: R$ <?php echo"$CntLuzjan1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Ecojan1"; ?> kWh<br/>
Dinheiro economizado: R$<?php echo"$DinEcojan1"; ?><br/>

<h4>DADOS DE FEVEREIRO ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRedefev1"; ?> kWh<br/>
Quantidade de energia paga: <?php echo"$EPagafev1"; ?> kWh<br/>
Conta de luz do mês: <?php echo"$CntLuzfev1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Ecofev1"; ?> kWh<br/>
Dinheiro economizado: <?php echo"$DinEcofev1"; ?><br/>

<h4>DADOS DE MARÇO ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRedemar1"; ?> kWh<br/>
Quantidade de energia paga: R$ <?php echo"$EPagamar1"; ?> kWh<br/>
Conta de luz do mês: <?php echo"$CntLuzfev1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Ecomar1"; ?> kWh<br/>
Dinheiro economizado: R$ <?php echo"$DinEcomar1"; ?><br/>

<h4>DADOS DE ABRIL ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRedeabr1"; ?> kWh<br/>
Quantidade de energia paga: R$ <?php echo"$EPagaabr1"; ?> kWh<br/>
Conta de luz do mês: <?php echo"$CntLuzabr1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Ecoabr1"; ?> kWh<br/>
Dinheiro economizado: R$ <?php echo"$DinEcoabr1"; ?><br/>

<h4>DADOS DE MAIO ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRedemai1"; ?> kWh<br/>
Quantidade de energia paga: <?php echo"$EPagamai1"; ?> kWh<br/>
Conta de luz do mês: R$ <?php echo"$CntLuzmai1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Ecomai1"; ?> kWh<br/>
Dinheiro economizado: R$ <?php echo"$DinEcomai1"; ?><br/>

<h4>DADOS DE JUNHO ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRedejun1"; ?> kWh<br/>
Quantidade de energia paga: <?php echo"$EPagajun1"; ?> kWh<br/>
Conta de luz do mês: R$ <?php echo"$CntLuzjun1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Ecojun1"; ?> kWh<br/>
Dinheiro economizado: R$ <?php echo"$DinEcojun1"; ?><br/>

<h4>DADOS DE JULHO ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRedejul1"; ?> kWh<br/>
Quantidade de energia paga: <?php echo"$EPagajul1"; ?> kWh<br/>
Conta de luz do mês: R$ <?php echo"$CntLuzjul1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Ecojul1"; ?> kWh<br/>
Dinheiro economizado: R$ <?php echo"$DinEcojul1"; ?><br/>

<h4>DADOS DE AGOSTO ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRedeago1"; ?> kWh<br/>
Quantidade de energia paga: <?php echo"$EPagaago1"; ?> kWh<br/>
Conta de luz do mês: R$ <?php echo"$CntLuzago1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Ecoago1"; ?> kWh<br/>
Dinheiro economizado: R$ <?php echo"$DinEcoago1"; ?><br/>

<h4>DADOS DE SETEMBRO ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRedeset1"; ?> kWh<br/>
Quantidade de energia paga: <?php echo"$EPagaset1"; ?> kWh<br/>
Conta de luz do mês: R$ <?php echo"$CntLuzset1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Ecoset1"; ?> kWh<br/>
Dinheiro economizado: R$ <?php echo"$DinEcoset1"; ?><br/>

<h4>DADOS DE OUTUBRO ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRedeout1"; ?> kWh<br/>
Quantidade de energia paga: <?php echo"$EPagaout1"; ?> kWh<br/>
Conta de luz do mês: R$ <?php echo"$CntLuzout1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Ecoout1"; ?> kWh<br/>
Dinheiro economizado: R$ <?php echo"$DinEcoout1"; ?><br/>

<h4>DADOS DE NOVEMBRO ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRedenov1"; ?> kWh<br/>
Quantidade de energia paga: <?php echo"$EPaganov1"; ?> kWh<br/>
Conta de luz do mês: R$ <?php echo"$CntLuznov1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Econov1"; ?> kWh<br/>
Dinheiro economizado: R$ <?php echo"$DinEconov1"; ?><br/>

<h4>DADOS DE DEZEMRO ANO 1 </h4>
Energia excedente enviada para a rede: <?php echo"$EnRededez1"; ?> kWh<br/>
Quantidade de energia paga: <?php echo"$EPagadez1"; ?> kWh<br/>
Conta de luz do mês: R$ <?php echo"$CntLuzdez1"; ?><br/>
Quatidade de energia economizada: <?php echo"$Ecodez1"; ?> kWh<br/>
Dinheiro economizado: R$ <?php echo"$DinEcodez1"; ?><br/>


<h2>FAZER NOVO CÁLCULO</h2><br/>
<h3>Selecione o local de instalação do sistema fotovoltaico</h3>




<form action="respostasform.php" method="post">
<fieldset id="local">
<legend>Coordenadas do local escolhido</legend>
 <label for="latitude">Latitude: </label><input type="number" name="lat" id="latitude" value=""   readonly="data-readonly" required/>

 <label for="longitude">Longitude: </label><input type="number" name="lon" id="longitude" value="" readonly="data-readonly" required />
 </fieldset>

 <fieldset id="consumo">
 <legend>Consumo de energia elétrica por mês</legend>

<label for="Cjan">Janeiro </label><input type="text" id="Cjan" name="Cjan" step="any" min="1"  value="<?php echo htmlspecialchars($Cjan);?>"/><br/>
<label for="Cfev">Fevereiro </label><input type="text" id="Cfev" name="Cfev" step="any" min="1" value="<?php echo htmlspecialchars($Cfev);?>"/><br/>
<label for="Cmar">Março </label><input type="text" id="Cmar" name="Cmar" step="any" min="1" value="<?php echo htmlspecialchars($Cmar);?>"/><br/>
<label for="Cabr">Abril </label><input type="text" id="Cabr" name="Cabr" step="any" min="1" value="<?php echo htmlspecialchars($Cabr);?>"/><br/>
<label for="Cmai">Maio </label><input type="text" id="Cmai" name="Cmai" step="any" min="1" value="<?php echo htmlspecialchars($Cmai);?>"/><br/>
<label for="Cjun">Junho </label><input type="text" id="Cjun" name="Cjun" step="any" min="1" value="<?php echo htmlspecialchars($Cjun);?>"/><br/>
<label for="Cjul">Julho </label><input type="text" id="Cjul" name="Cjul" step="any" min="1" value="<?php echo htmlspecialchars($Cjul);?>"/><br/>
<label for="Cago">Agosto </label><input type="text" id="Cago" name="Cago" step="any" min="1" value="<?php echo htmlspecialchars($Cago);?>"/><br/>
<label for="Cset">Setembro </label><input type="text" id="Cset" name="Cset" step="any" min="1" value="<?php echo htmlspecialchars($Cset);?>"/><br/>
<label for="Cout">Outubro </label><input type="text" id="Cout" name="Cout" step="any" min="1" value="<?php echo htmlspecialchars($Cout);?>"/><br/>
<label for="Cnov">Novembro </label><input type="text" id="Cnov" name="Cnov" step="any" min="1" value="<?php echo htmlspecialchars($Cnov);?>"/><br/>
<label for="Cdez">Dezembro </label><input type="text" id="Cdez" name="Cdez" step="any" min="1" value="<?php echo htmlspecialchars($Cdez);?>"/><br/>
</fieldset>

 <fieldset id="ligação">
		<legend>Tipo de consumidor</legend>
		<legend>Grupo B1 (residencial)- Tipo de ligação</legend>
			<input type="radio" name="tLig" id="cMono" value="30" required <?php echo"$mono";?> /> <label for="cMono">Monofásico</label>
			<input type="radio" name="tLig" id="cBi" value="50" <?php echo"$bi";?> /> <label for="cBi">Bifásico</label>
			<input type="radio" name="tLig" id="cTri" value="100" <?php echo"$tri";?> /> <label for="cTri">Trifásico</label>
		<legend>Opção</legend>
			<input type="radio" name="tLig" id="cNull" value="1" <?php echo"$cem";?> /> <label for="cNull">Dimensionamento para 100% do consumo</label>
 </fieldset>

 <fieldset id="custo"><legend>Preço por kWh</legend>
<input type="number" name="preco" step="any" min="0" value="<?php echo htmlspecialchars($preco);?>" required/><spam>  R$/kWh</spam>
</fieldset>

 <fieldset id="preset"><legend>Opções extras</legend>
 <label for="potencia">Potência de pico do módulos:  </label><input type="text" name="pico" value="<?php echo htmlspecialchars($pico);?>" required/><spam>  kWp<spam/><br/>
<label for="eficiencia">Eficiência do módulo (%):</label><input type="text" name="efic" value="<?php echo htmlspecialchars($efic);?>" required/><br/>
<label for="comprimento">Comprimento:  </label><input type="text" name="comp" value="<?php echo htmlspecialchars($comp);?>" required/><spam>  metros<spam/><br/>
<label for="largura">Largura: </label><input type="text" name="larg" value="<?php echo htmlspecialchars($larg);?>" required/><spam>  metros<spam/><br/>
<label for="td">Taxa de desempenho do sistema SFV (%): </label><input type="text" name="td" value="<?php echo htmlspecialchars($td);?>" required/><br/>
<label for="inv">Taxa de eficiência do inversor (%): </label><input type="text" name="inv" value="<?php echo htmlspecialchars($inv);?>" required/><br/>
<fieldset/>

<button class="button" type="submit" name="subm" id="subm">calcular </button>
</form>



</div>


</body>
</html>
