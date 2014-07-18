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

echo $form->create($model = 'Evento', $options = array('action'=>'graficos_trimestral'));
echo "<br/>";
echo "<div class='span-24'>";
echo $form->input("year", array('label'=>array("text"=>'Año:',"class"=>'span-1 derecha'),'selected'=>date('Y'), 'options'=>$year, 'empty'=>FALSE, 'class'=>'span-6 last', 'div'=>array('class'=>'input select span-7') ) );
echo $form->input("trimestre", array('label'=>array("text"=>'Trimestre:',"class"=>'span-2 derecha'), 'options'=>array('1'=>'Primer Trimestre', '2'=>'Segundo Trimestre', '3'=>'Tercer Trimestre', '4'=>'Cuarto Trimestre'), 'empty'=>FALSE, 'class'=>'span-6 last', 'div'=>array('class'=>'input select span-8') ) );
echo $form->end(array('div'=>array('class'=>'submit span-4'), 'label'=>'Ver Estadisticas'));
if(!empty($this->data)){
	echo "<div class=''>";
	echo $html->link(
		$title= "Generar PDF", 
		$url = array('controller'=>'Eventos', 'action'=>'generarPdfTrimestral', $this->data['Evento']['year'], $this->data['Evento']['trimestre']), 
		$options = array('alt'=>null, 'escape'=>FALSE, 'class'=>"pdf"), 
		$confirmMessage = false
	);
	echo "</div>";
}
echo "</div>";
if(!empty($this->data)){
	$year = $this->data['Evento']['year'];
	//pr($datos);
?>

<table>
	<tr>
		<td colspan="2" style="text-align:center;font-weight:bold;">Cuadro Resumen</td>
	</tr>
	<tr>
		<td colspan="2">Cantidad de Eventos: <? echo $cant_eventos[0]['cant_eventos']; ?></td>
	</tr>
	<tr>
		<td colspan="2">Tipos de Evento: </td>
	</tr>
	<tr>
		<td>Eventos Nacionales: <? echo $nacional[0][0]['count']; ?></td>
		<td>Eventos Internacionales: <? echo $internacional[0][0]['count']; ?></td>
	</tr>
	<tr>
		<td colspan="2">Personal que participo en los eventos: <?= $cant_personal[0]['cant_personal'] ?></td>
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
switch ($this->data['Evento']['trimestre']) {
	case 1:
		$DataSet->AddPoint(array("Ene", "Feb", "Mar"), 'SerieM');
	break;
	case 2:
		$DataSet->AddPoint(array("Abr", "May", "Jun"), 'SerieM');
	break;
	case 3:
		$DataSet->AddPoint(array("Jul", "Ago", "Sep"), 'SerieM');
	break;
	case 4:
		$DataSet->AddPoint(array("Oct", "Nov", "Dic"), 'SerieM');
	break;
}

$DataSet->AddAllSeries(); 
$DataSet->SetAbsciseLabelSerie("SerieM");
$DataSet->RemoveSerie("SerieM");
foreach($datos as $index=>$dato){
	$DataSet->SetSerieName("Año $index", $index);
} 

$DataSet->SetXAxisName("Meses");
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
$Test->Render("graficos/graficos_trimestre_".$this->data['Evento']['trimestre']."_$year.png");  
echo $html->image("../graficos/graficos_trimestre_".$this->data['Evento']['trimestre']."_$year.png");
?>
<br/><br/>
<? 
$DataSet = new pData;
$valores= array();
$nombres = array();
foreach($data_tipo_eventos as $tipo_evento){
	array_push($valores, $tipo_evento[0]['count']);
	array_push($nombres, $tipo_evento['VEventosTipo']['title']);
}
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

$Test->Render("graficos/graficos_torta_tipo_eventos_trimestre_".$this->data['Evento']['trimestre']."_".$year.".png");
?>
<? 
$DataSet = new pData;
$DataSet->AddPoint(array($nacional[0][0]['count'], $internacional[0][0]['count']),"Serie1");
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

$Test->Render("graficos/graficos_torta_nacionalidad_trimestre_".$this->data['Evento']['trimestre']."_".$year.".png");
?>
<span class="span-11">
<h3>Gráfico de eventos según su tipo:</h3>
<? echo $html->image("../graficos/graficos_torta_tipo_eventos_trimestre_".$this->data['Evento']['trimestre']."_".$year.".png"); ?>
</span>
<span class="span-11 last">
<h3>Gráfico de eventos según su nivel:</h3>
<? echo $html->image("../graficos/graficos_torta_nacionalidad_trimestre_".$this->data['Evento']['trimestre']."_".$year.".png"); ?>
</span>
<? 
}
?>