
<?php

//PERDA DE EFICIENCIA COM O PASSAR DOS ANOS
$perda1 = (1-((20/24)/100)) * $Fefic;
$perda2 = ((1-((20/24)/100)) * 2) * $Fefic;
$perda3 = ((1-((20/24)/100)) * 3) * $Fefic;
$perda4 = ((1-((20/24)/100)) * 4) * $Fefic;
$perda5 = ((1-((20/24)/100)) * 5) * $Fefic;
$perda6 = ((1-((20/24)/100)) * 6) * $Fefic;
$perda7 = ((1-((20/24)/100)) * 7) * $Fefic;
$perda8 = ((1-((20/24)/100)) * 8) * $Fefic;
$perda9 = ((1-((20/24)/100)) * 9) * $Fefic;
$perda10 = ((1-((20/24)/100)) * 10) * $Fefic;
$perda11 = ((1-((20/24)/100)) * 11) * $Fefic;
$perda12 = ((1-((20/24)/100)) * 12) * $Fefic;
$perda13 = ((1-((20/24)/100)) * 13) * $Fefic;
$perda14 = ((1-((20/24)/100)) * 14) * $Fefic;
$perda15 = ((1-((20/24)/100)) * 15) * $Fefic;
$perda16 = ((1-((20/24)/100)) * 16) * $Fefic;
$perda17 = ((1-((20/24)/100)) * 17) * $Fefic;
$perda18 = ((1-((20/24)/100)) * 18) * $Fefic;
$perda19 = ((1-((20/24)/100)) * 19) * $Fefic;
$perda20 = ((1-((20/24)/100)) * 20) * $Fefic;
$perda21 = ((1-((20/24)/100)) * 21) * $Fefic;
$perda22 = ((1-((20/24)/100)) * 22) * $Fefic;
$perda23 = ((1-((20/24)/100)) * 23) * $Fefic;
$perda24 = ((1-((20/24)/100)) * 24) * $Fefic;



//Função da energia gerada por mês
	function energia($Irrad, $NumeroMod, $AreaMod, $EfiMod, $Taxa, $diasMes){
		return (($Irrad/1000) * $NumeroMod * $AreaMod * ($EfiMod/100) * ($Taxa/100) * $diasMes);
	}
	


	function contadeluz($EnergiaGerada, $ConsumoDoMes, $taxa, $tarifa){
		if ($taxa > 0){
			if ($EnergiaGerada > $ConsumoDoMes && $ConsumoDoMes > $taxa){
				$EnergiaRede = $EnergiaGerada - $ConsumoDoMes;
				$EnergiaPaga = $taxa;
				$ContaDeLuz = $taxa * $tarifa;
				$EconomiaDoMes = $ConsumoDoMes - $taxa;
				$DinheiroEconomizado = ($ConsumoDoMes - $taxa) * $tarifa;
				
				$retorno = array(
				'EnergiaRede' => $EnergiaRede,
				'EnergiaPaga' => $EnergiaPaga,
				'ContaDeLuz' => $ContaDeLuz,
				'EconomiaDoMes' => $EconomiaDoMes,
				'DinheiroEconomizado' => $DinheiroEconomizado
			);
				return $retorno;
			}elseif($EnergiaGerada < $ConsumoDoMes && $ConsumoDoMes > $taxa){
				$EnergiaRede = 0;
				if(($ConsumoDoMes - $EnergiaGerada) > $taxa){
					$EnergiaPaga = $ConsumoDoMes - $EnergiaGerada;
					$ContaDeLuz = ($ConsumoDoMes - $EnergiaGerada) * $tarifa;
					$EconomiaDoMes = $ConsumoDoMes - ($ConsumoDoMes - $EnergiaGerada);
					$DinheiroEconomizado = ($ConsumoDoMes - ($ConsumoDoMes - $EnergiaGerada)) * $tarifa;
				}else{
				$EnergiaPaga = $taxa;
				$ContaDeLuz = $taxa * $tarifa;
				$EconomiaDoMes = $EnergiaGerada - $taxa;
				$DinheiroEconomizado = ($ConsumoDoMes - $taxa) * $tarifa;}
				
				$retorno = array(
				'EnergiaRede' => $EnergiaRede,
				'EnergiaPaga' => $EnergiaPaga,
				'ContaDeLuz' => $ContaDeLuz,
				'EconomiaDoMes' => $EconomiaDoMes,
				'DinheiroEconomizado' => $DinheiroEconomizado
				);
				return $retorno;
			}elseif ($EnergiaGerada > $ConsumoDoMes && $ConsumoDoMes < $taxa){
				$EnergiaRede = $EnergiaGerada - $ConsumoDoMes;
				$EnergiaPaga = $taxa;
				$ContaDeLuz = $taxa * $tarifa;
				$EconomiaDoMes = 0;
				$DinheiroEconomizado = 0;
				
				$retorno = array(
				'EnergiaRede' => $EnergiaRede,
				'EnergiaPaga' => $EnergiaPaga,
				'ContaDeLuz' => $ContaDeLuz,
				'EconomiaDoMes' => $EconomiaDoMes,
				'DinheiroEconomizado' => $DinheiroEconomizado
			);
				return $retorno;
			}
			elseif ($EnergiaGerada < $ConsumoDoMes && $ConsumoDoMes < $taxa){
				$EnergiaRede = 0;
				$EnergiaPaga = $taxa;
				$ContaDeLuz = $taxa * $tarifa;
				$EconomiaDoMes = 0;
				$DinheiroEconomizado = 0;
				
				$retorno = array(
				'EnergiaRede' => $EnergiaRede,
				'EnergiaPaga' => $EnergiaPaga,
				'ContaDeLuz' => $ContaDeLuz,
				'EconomiaDoMes' => $EconomiaDoMes,
				'DinheiroEconomizado' => $DinheiroEconomizado
			);
			return $retorno;
			}
		}elseif ($taxa = 10) {
			if($EnergiaGerada > $ConsumoDoMes){
				$EnergiaRede = $EnergiaGerada - $ConsumoDoMes;
				$EnergiaPaga = 0;
				$ContaDeLuz = 0;
				$EconomiaDoMes = $ConsumoDoMes;
				$DinheiroEconomizado = $ConsumoDoMes * $tarifa;
				
				$retorno = array(
				'EnergiaRede' => $EnergiaRede,
				'EnergiaPaga' => $EnergiaPaga,
				'ContaDeLuz' => $ContaDeLuz,
				'EconomiaDoMes' => $EconomiaDoMes,
				'DinheiroEconomizado' => $DinheiroEconomizado
				
				);
				return $retorno;
				
			}elseif ($EnergiaGerada < $ConsumoDoMes){
				$EnergiaRede = 0;
				$EnergiaPaga = $ConsumoDoMes - $EnergiaGerada;
				$ContaDeLuz = ($ConsumoDoMes - $EnergiaGerada)* $tarifa;
				$EconomiaDoMes = $ConsumoDoMes - ($ConsumoDoMes - $EnergiaGerada);
				$DinheiroEconomizado = ($ConsumoDoMes - ($ConsumoDoMes - $EnergiaGerada)) * $tarifa;
				
				$retorno = array(
				'EnergiaRede' => $EnergiaRede,
				'EnergiaPaga' => $EnergiaPaga,
				'ContaDeLuz' => $ContaDeLuz,
				'EconomiaDoMes' => $EconomiaDoMes,
				'DinheiroEconomizado' => $DinheiroEconomizado
				);
				return $retorno;
				
			}
		}
	}
	//ENERGIA E ECONOMIA
		//funções de soma
		function TotalEnergiaGeradaAno($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l){
			return ($a+$b+$c+$d+$e+$f+$g+$h+$i+$j+$k+$l);
		}
		
		function TotalEnviadoRedeAno($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l){
			return ($a+$b+$c+$d+$e+$f+$g+$h+$i+$j+$k+$l);
		}
		
		function TotalEnergiaEcoAno($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l){
			return ($a+$b+$c+$d+$e+$f+$g+$h+$i+$j+$k+$l);
		}
		
		function TotalContaLuzAno($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l){
			return ($a+$b+$c+$d+$e+$f+$g+$h+$i+$j+$k+$l);
		}
		
		function TotalDinheiroEcoAno($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l){
			return ($a+$b+$c+$d+$e+$f+$g+$h+$i+$j+$k+$l);
		}
	
	// ENERGIA PRIMEIRO ANO
	$Ejan1 = round(energia($vjan, $Nmod, $Fareamod, $Fefic, $td, $dias1),2);
	$Efev1 = round(energia($vfev, $Nmod, $Fareamod, $Fefic, $td, $dias2),2);
	$Emar1 = round(energia($vmar, $Nmod, $Fareamod, $Fefic, $td, $dias1),2);
	$Eabr1 = round(energia($vabr, $Nmod, $Fareamod, $Fefic, $td, $dias),2);
	$Emai1 = round(energia($vmai, $Nmod, $Fareamod, $Fefic, $td, $dias1),2);
	$Ejun1 = round(energia($vjun, $Nmod, $Fareamod, $Fefic, $td, $dias),2);
	$Ejul1 = round(energia($vjul, $Nmod, $Fareamod, $Fefic, $td, $dias1),2);
	$Eago1 = round(energia($vago, $Nmod, $Fareamod, $Fefic, $td, $dias1),2);
	$Eset1 = round(energia($vset, $Nmod, $Fareamod, $Fefic, $td, $dias),2);
	$Eout1 = round(energia($vout, $Nmod, $Fareamod, $Fefic, $td, $dias1),2);
	$Enov1 = round(energia($vnov, $Nmod, $Fareamod, $Fefic, $td, $dias),2);
	$Edez1 = round(energia($vdez, $Nmod, $Fareamod, $Fefic, $td, $dias1),2);
	
	$EnergTotAno1 = round(TotalEnergiaGeradaAno($Ejan1,$Efev1,$Emar1,$Eabr1,$Emai1,$Ejun1,$Ejul1,$Eago1,$Eset1,$Eout1,$Enov1,$Edez1),2);
	
	///VALORES JANEIRO ano 1
	$ano1jan = contadeluz($Ejan1, $Cjan, $tLig, $preco);
	
    $EnRedejan1 = round($ano1jan['EnergiaRede'],2);
	$EPagajan1 = round($ano1jan['EnergiaPaga'],2);
	$CntLuzjan1 = round($ano1jan['ContaDeLuz'],2);
	$Ecojan1 = round($ano1jan['EconomiaDoMes'],2);
	$DinEcojan1 = round($ano1jan['DinheiroEconomizado'],2);

	//VALORES FEVEREIRO ano 1
	$ano1fev = contadeluz($Efev1, $Cfev, $tLig, $preco);
	
	$EnRedefev1 = round($ano1fev['EnergiaRede'],2);
	$EPagafev1 = round($ano1fev['EnergiaPaga'],2);
	$CntLuzfev1 = round($ano1fev['ContaDeLuz'],2);
	$Ecofev1 = round($ano1fev['EconomiaDoMes'],2);
	$DinEcofev1 = round($ano1fev['DinheiroEconomizado'],2);
	
	//VALORES MARÇO ano 1
	$ano1mar = contadeluz($Emar1, $Cmar, $tLig, $preco);
	
	$EnRedemar1 = round($ano1mar['EnergiaRede'],2);
	$EPagamar1 = round($ano1mar['EnergiaPaga'],2);
	$CntLuzmar1 = round($ano1mar['ContaDeLuz'],2);
	$Ecomar1 = round($ano1mar['EconomiaDoMes'],2);
	$DinEcomar1 = round($ano1mar['DinheiroEconomizado'],2);
	
	//VALORES ABRIL ano 1
	$ano1abr = contadeluz($Eabr1, $Cabr, $tLig, $preco);
	
	$EnRedeabr1 = round($ano1abr['EnergiaRede'],2);
	$EPagaabr1 = round($ano1abr['EnergiaPaga'],2);
	$CntLuzabr1 = round($ano1abr['ContaDeLuz'],2);
	$Ecoabr1 = round($ano1abr['EconomiaDoMes'],2);
	$DinEcoabr1 = round($ano1abr['DinheiroEconomizado'],2);
	
	//VALORES MAIO ano 1
	$ano1mai = contadeluz($Emai1, $Cmai, $tLig, $preco);
	
	$EnRedemai1 = round($ano1mai['EnergiaRede'],2);
	$EPagamai1 = round($ano1mai['EnergiaPaga'],2);
	$CntLuzmai1 = round($ano1mai['ContaDeLuz'],2);
	$Ecomai1 = round($ano1mai['EconomiaDoMes'],2);
	$DinEcomai1 = round($ano1mai['DinheiroEconomizado'],2);
	
	//VALORES JUNHO ano 1
	$ano1jun = contadeluz($Ejun1, $Cjun, $tLig, $preco);
	
	$EnRedejun1 = round($ano1jun['EnergiaRede'],2);
	$EPagajun1 = round($ano1jun['EnergiaPaga'],2);
	$CntLuzjun1 = round($ano1jun['ContaDeLuz'],2);
	$Ecojun1 = round($ano1jun['EconomiaDoMes'],2);
	$DinEcojun1 = round($ano1jun['DinheiroEconomizado'],2);
	
	//VALORES JULHO ano 1
	$ano1jul = contadeluz($Ejul1, $Cjul, $tLig, $preco);
	
	$EnRedejul1 = round($ano1jul['EnergiaRede'],2);
	$EPagajul1 = round($ano1jul['EnergiaPaga'],2);
	$CntLuzjul1 = round($ano1jul['ContaDeLuz'],2);
	$Ecojul1 = round($ano1jul['EconomiaDoMes'],2);
	$DinEcojul1 = round($ano1jul['DinheiroEconomizado'],2);
	
	//VALORES AGOSTO ano 1
	$ano1ago = contadeluz($Eago1, $Cago, $tLig, $preco);
	
	$EnRedeago1 = round($ano1ago['EnergiaRede'],2);
	$EPagaago1 = round($ano1ago['EnergiaPaga'],2);
	$CntLuzago1 = round($ano1ago['ContaDeLuz'],2);
	$Ecoago1 = round($ano1ago['EconomiaDoMes'],2);
	$DinEcoago1 = round($ano1ago['DinheiroEconomizado'],2);
	
	//VALORES SETEMBRO ano 1
	$ano1set = contadeluz($Eset1, $Cset, $tLig, $preco);
	
	$EnRedeset1 = round($ano1set['EnergiaRede'],2);
	$EPagaset1 = round($ano1set['EnergiaPaga'],2);
	$CntLuzset1 = round($ano1set['ContaDeLuz'],2);
	$Ecoset1 = round($ano1set['EconomiaDoMes'],2);
	$DinEcoset1 = round($ano1set['DinheiroEconomizado'],2);
	
	//VALORES OUTRUBRO ano 1
	$ano1out = contadeluz($Eout1, $Cout, $tLig, $preco);
	
	$EnRedeout1 = round($ano1out['EnergiaRede'],2);
	$EPagaout1 = round($ano1out['EnergiaPaga'],2);
	$CntLuzout1 = round($ano1out['ContaDeLuz'],2);
	$Ecoout1 = round($ano1out['EconomiaDoMes'],2);
	$DinEcoout1 = round($ano1out['DinheiroEconomizado'],2);
	
	//VALORES NOVEMBRO ano 1
	$ano1nov = contadeluz($Enov1, $Cnov, $tLig, $preco);
	
	$EnRedenov1 = round($ano1nov['EnergiaRede'],2);
	$EPaganov1 = round($ano1nov['EnergiaPaga'],2);
	$CntLuznov1 = round($ano1nov['ContaDeLuz'],2);
	$Econov1 = round($ano1nov['EconomiaDoMes'],2);
	$DinEconov1 = round($ano1nov['DinheiroEconomizado'],2);
	
	//VALORES DEZEMBRO ano 1
	$ano1dez = contadeluz($Edez1, $Cdez, $tLig, $preco);
	
	$EnRededez1 = round($ano1dez['EnergiaRede'],2);
	$EPagadez1 = round($ano1dez['EnergiaPaga'],2);
	$CntLuzdez1 = round($ano1dez['ContaDeLuz'],2);
	$Ecodez1 = round($ano1dez['EconomiaDoMes'],2);
	$DinEcodez1 = round($ano1dez['DinheiroEconomizado'],2);
	
	//VALORES TOTAIS ANO 1
	
	
 	
?>
