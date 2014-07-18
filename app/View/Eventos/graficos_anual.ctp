<script>
	$('#mcg').addClass('current');
</script>
<?php
/*******************************************************************************
*    República Bolivariana de Venezuela
*    Ministerio del Poder para Ciencia, Tecnología e Industrias Intermedias
*    Fundación Instituto de Ingenieria
*    Centro de Procesamiento Digital de Imagenes
*    
*     Archivo: graficos_eventos.ctp
*     Fecha de Creación: 06/09/2010
*     Creado por: Ing. Luis Alfredo Diaz Jaramillo - ldiazj@fii.gob.ve
*     
*******************************************************************************/

echo $form->create($model = 'Evento', $options = array('action'=>'graficos_anual'));
echo "<br/>";
echo "<div class='span-24'>";
echo $form->input("year", array('label'=>array("text"=>'Año:',"class"=>'span-2 derecha'),'selected'=>date('Y'), 'options'=>$year, 'empty'=>FALSE, 'class'=>'span-6 last', 'div'=>array('class'=>'input select span-8') ) );
echo $form->end(array('div'=>array('class'=>'submit span-4'), 'label'=>'Ver Estadisticas'));
if(!empty($this->data)){
	echo "<div class='span-4'>";
	echo $html->link(
		$title= "Generar PDF", 
		$url = array('controller'=>'Eventos', 'action'=>'generarPdfAnual', $value=$this->data['Evento']['year']), 
		$options = array('alt'=>null, 'escape'=>FALSE, 'class'=>"pdf"), 
		$confirmMessage = false
	);
	echo "</div>";
}
echo "</div>";
if(!empty($this->data)){
	$year = $this->data['Evento']['year'];
	//pr($datos);
$valores= array();
$nombres = array();
$cadena = "";
$i=0;
foreach($data_tipo_eventos as $tipo_evento){
	array_push($valores, $tipo_evento[0]['cant']);
	array_push($nombres, $tipo_evento['VEventosTipo']['title']);
	$cadena .=  $tipo_evento['VEventosTipo']['title'].": ".$tipo_evento[0]['cant'];
	if($i++ != (count($data_tipo_eventos) - 1)) $cadena .= ", ";
}
?>
<br/>
<span class="span-24 last">
</span>
<table>
	<tr>
		<td colspan="2" style="text-align:center;font-weight:bold;font-size:140%">Cuadro Resumen</td>
	</tr>
	<tr>
		<td colspan="2"><b>Cantidad de Eventos:</b> <? echo $resumen[0]['cant_eventos'] ?></td>
	</tr>
	<tr>
		<td colspan="2"><b>Tipos de Evento:</b></td>
	</tr>
	<tr>
		<td colspan="2"><? echo $cadena ?></td>
	</tr>
	<tr>
		<td><b>Eventos Nacionales:</b> <? echo $resumen[0]['nacional']; ?></td>
		<td><b>Eventos Internacionales:</b> <? echo $resumen[0]['internacional']; ?></td>
	</tr>
	<tr>
		<td colspan="2"><b>Personal que participo en los eventos:</b> <? echo $resumen[0]['cant_personal']; ?></td>
	</tr>
</table>
<span class="span-24 last">
<div class="break"></div>
</span>
<h3>Gráfico comparativo con respecto al año <? echo $this->data['Evento']['year']; ?>:</h3>
<?
	App::import('vendor','pdata');
	App::import('vendor','pchart');
	 
// Dataset definition   
$DataSet = new pData;  
$cant = count($datos);
foreach($datos as $index=>$dato){
	$DataSet->AddPoint($dato, $index);
}
//$DataSet->AddPoint(array(1,4,3,2,3,3,2,1,0,7,4,3), 'Serie1');  
//$DataSet->AddSerie();
$DataSet->AddPoint(array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"), 'SerieM');
$DataSet->AddAllSeries(); 
$DataSet->SetAbsciseLabelSerie("SerieM");
$DataSet->RemoveSerie("SerieM");
foreach($datos as $index=>$dato){
	$DataSet->SetSerieName("Año $index", $index);
} 

$DataSet->SetXAxisName("Meses del Año");
 $DataSet->SetYAxisName("Eventos");    
   
// Initialise the graph  
$Test = new pChart(950,350);
$Test->loadColorPalette("/Fonts/tones-1.txt");
$Test->drawGraphAreaGradient(132,153,172,50,TARGET_BACKGROUND);   
$Test->setFontProperties("/Fonts/tahoma.ttf",10);  
$Test->setGraphArea(50,40,840, 280);  
$Test->drawGraphArea(213,217,221,FALSE); 
$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,213,217,221,TRUE,0,2); 
//$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2); 
$Test->drawGraphAreaGradient(162,183,202,50);  
$Test->drawGrid(4,TRUE,230,230,230,20);  
  
// Draw the line graph  
$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());  
$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);  
// Finish the graph  
$Test->setFontProperties("/Fonts/tahoma.ttf",10);  
$Test->drawLegend(850, 40, $DataSet->GetDataDescription(),236,238,240,52,58,82);  
$Test->setFontProperties("/Fonts/tahoma.ttf",10);  
$Test->Render("graficos/graficos_anual_$year.png");  
echo $html->image("../graficos/graficos_anual_$year.png");
?>
<br/><br/>
<? 
$DataSet = new pData;
$DataSet->AddPoint($valores,"Serie1");
$DataSet->AddPoint($nombres,"Serie2");  
$DataSet->AddAllSeries();  
$DataSet->SetAbsciseLabelSerie("Serie2");  
  
// Initialise the graph  
$Test = new pChart(450,200);
$Test->loadColorPalette("/Fonts/tones-3.txt");
$Test->drawFilledRoundedRectangle(7,7,373,193,5,240,240,240);
$Test->drawRoundedRectangle(5,5,375,195,5,230,230,230);
   
// Draw the pie chart
$Test->setFontProperties("/Fonts/tahoma.ttf",10);
$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);
$Test->drawPieLegend(310,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

$Test->Render("graficos/graficos_torta_tipo_eventos_$year.png");
?>
<? 
$DataSet = new pData;
$DataSet->AddPoint(array($resumen[0]['nacional'], $resumen[0]['internacional']),"Serie1");
$DataSet->AddPoint(array("Nacional", "Internacional"),"Serie2");  
$DataSet->AddAllSeries();  
$DataSet->SetAbsciseLabelSerie("Serie2");  
  
// Initialise the graph  
$Test = new pChart(450,200);
$Test->loadColorPalette("/Fonts/tones-6.txt");
$Test->drawFilledRoundedRectangle(7,7,373,193,5,240,240,240);
$Test->drawRoundedRectangle(5,5,375,195,5,230,230,230);
   
// Draw the pie chart
$Test->setFontProperties("/Fonts/tahoma.ttf", 10);
$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),160,90,110,PIE_PERCENTAGE,TRUE,50,20,5);
$Test->drawPieLegend(310,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

$Test->Render("graficos/graficos_torta_nacionalidad_$year.png");
?>
<span class="span-24 last">
<span class="span-12">
<h3>Gráfico de eventos según su tipo:</h3>
<? echo $html->image("../graficos/graficos_torta_tipo_eventos_$year.png"); ?>
</span>
<span class="span-12 last">
<h3>Gráfico de eventos según su nivel:</h3>
<? echo $html->image("../graficos/graficos_torta_nacionalidad_$year.png"); ?>
</span>
</span>
<? 
}
?>