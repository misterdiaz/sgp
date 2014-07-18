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

echo $form->create($model = 'Evento', $options = array('action'=>'graficos_mensual'));
echo "<br/>";
$meses = array(1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre');
echo "<div class='span-24'>";
echo $form->input("year", array('label'=>array("text"=>'Año:',"class"=>'span-1 derecha'),'selected'=>date('Y'), 'options'=>$year, 'empty'=>FALSE, 'class'=>'span-6 last', 'div'=>array('class'=>'input select span-7') ) );
echo $form->input("mes", array('label'=>array("text"=>'Mes:',"class"=>'span-2 derecha'), 'options'=>$meses, 'empty'=>FALSE, 'class'=>'span-6 last', 'div'=>array('class'=>'input select span-8') ) );
echo $form->end(array('div'=>array('class'=>'submit span-4'), 'label'=>'Ver Estadisticas'));
if(!empty($this->data)){
	echo "<div class=''>";
	echo $html->link(
		$title= "Generar PDF", 
		$url = array('controller'=>'Eventos', 'action'=>'generarPdfMensual', $this->data['Evento']['year'], $this->data['Evento']['mes']), 
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
 $DataSet = new pData;
 //pr($datos);
 
 foreach($datos[$this->data['Evento']['year']] as $index=>$value){
 	$DataSet->AddPoint(array($value), mes2letras($index));  
 }
   
 $DataSet->AddAllSeries();  
 $DataSet->SetAbsciseLabelSerie();
 foreach($datos[$this->data['Evento']['year']] as $index=>$value){
 	$DataSet->AddPoint(mes2letras($index), mes2letras($index));  
 }

 $DataSet->SetXAxisName("Meses");
 $DataSet->SetYAxisName("Eventos");  
  
 // Initialise the graph  
 $Test = new pChart(950, 350);
 $Test->loadColorPalette("/Fonts/tones-1.txt");
$Test->drawGraphAreaGradient(132,153,172,50,TARGET_BACKGROUND);   
 $Test->setFixedScale(0,$maximo+2);   
 $Test->setFontProperties("/Fonts/tahoma.ttf",10);
 $Test->setGraphArea(50,40,840, 280);  
$Test->drawGraphArea(213,217,221,FALSE); 
 //$Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);  
 //$Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);  
 //$Test->drawGraphArea(255,255,255,TRUE);  
 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
$Test->drawGraphAreaGradient(162,183,202,50);  
$Test->drawGrid(4,TRUE,230,230,230,20);   
  
 // Draw the 0 line  
 $Test->setFontProperties("/Fonts/tahoma.ttf",10);
 $Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
  
 // Draw the bar graph  
 $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
  
 // Finish the graph  
 $Test->setFontProperties("/Fonts/tahoma.ttf",10);
 $Test->drawLegend(850, 40, $DataSet->GetDataDescription(),236,238,240,52,58,82);  
 $Test->setFontProperties("Fonts/tahoma.ttf",10);  
 $DataSet = new pData;  
 $DataSet->AddPoint(array(7),"Serie1");  
 $DataSet->AddPoint(array(8),"Serie2");  
 $DataSet->AddAllSeries();  
 $DataSet->SetAbsciseLabelSerie();  
 $DataSet->SetSerieName("January","Serie1");  
 $DataSet->SetSerieName("February","Serie2");
 $Test->Render("graficos/graficos_mes_".$this->data['Evento']['mes']."_$year.png");  
echo $html->image("../graficos/graficos_mes_".$this->data['Evento']['mes']."_$year.png");
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

$Test->Render("graficos/graficos_torta_tipo_eventos_mes_".$this->data['Evento']['mes']."_".$year.".png");
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

$Test->Render("graficos/graficos_torta_nacionalidad_mes_".$this->data['Evento']['mes']."_".$year.".png");
?>
<span class="span-11">
<h3>Gráfico de eventos según su tipo:</h3>
<? echo $html->image("../graficos/graficos_torta_tipo_eventos_mes_".$this->data['Evento']['mes']."_".$year.".png"); ?>
</span>
<span class="span-11 last">
<h3>Gráfico de eventos según su nivel:</h3>
<? echo $html->image("../graficos/graficos_torta_nacionalidad_mes_".$this->data['Evento']['mes']."_".$year.".png"); ?>
</span>
<? 
}
?>