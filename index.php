<?php require_once 'classVotos.php'; ?>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'content.php'; ?>
<h1>Home</h1>
<div id="chartContainer"></div>

<?php

// inicia o gráfico de comparação com os coeficientes de Benford
$Benford = array( 30.1,17.61,12.49,9.69,7.92,6.69,5.8,5.12,4.58); // Dados estatísticos da Lei de Benford
$i=1;
foreach($Benford as $p){
    $dados['Benford'][] = array("label"=>$i++,"y"=>$p); // prepara os dados pra o gráfico
}

// Capta os dados do arquivo obtido pelo TSE e normaliza por candidato e votos por cidade
$arq = new Votos;
$arq->getVotosCidade();

// Calcula a porcentagem em que os dígitos aparecem na lista e constrói os dados para alimentar o gráfico
foreach($arq->getDigitosLista() as $nome=>$lista){
    $n = array(0,0,0,0,0,0,0,0,0); // 9 digitos = 123456789
    foreach($lista as $v=>$d){
        $n[$d-1] += 1; // Conta quantos digitos tem na lista, o $d-1 é porque os arrays começam com ZERO. Então o digito 1 seria o array zero
    }
    $soma = array_sum($n); // Soma todos os dígitos para tirar a porcentagem
    $i=1;
    foreach($n as $p){
        $dados[$nome][] = array("label"=>$i++,"y"=>$p*100/$soma);
    }

}

// Constrói os dados para alimentar o gráfico
foreach($dados as $nome=>$dado){
    $grafico[] = '{
		type: "column",
		name: "'.utf8_encode($nome).'",
		indexLabel: "{y}",
		yValueFormatString: "#0.##",
        toolTipContent: "{y}%",
		showInLegend: true,
		dataPoints: '.json_encode($dado, JSON_NUMERIC_CHECK).'
	}';
}

 ?>

<script type="text/javascript">

 
window.onload = function () {
 
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		theme: "light2",
		title:{
			text: "Gráfico de Benford"
		},
		legend:{
			cursor: "pointer",
			verticalAlign: "center",
			horizontalAlign: "right",
			itemclick: toggleDataSeries
		},
		data: [<?php echo implode(',',$grafico); ?>]
	});
	chart.render();
	
	function toggleDataSeries(e){
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		}
		else{
			e.dataSeries.visible = true;
		}
		chart.render();
	}
 
}

</script>

<?php include 'footer.php'; ?>