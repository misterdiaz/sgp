<?php
/*******************************************************************************
*    República Bolivariana de Venezuela
*    Ministerio del Poder para Ciencia, Tecnología e Industrias Intermedias
*    Fundación Instituto de Ingenieria
*    Centro de Procesamiento Digital de Imagenes
*    
*     Archivo: torta.ctp
*     Fecha de Creación: 06/09/2010
*     Creado por: Ing. Luis Alfredo Diaz Jaramillo - ldiazj@fii.gob.ve
*     
*******************************************************************************/
	App::import('vendor','pdata');
	App::import('vendor','pchart');
$DataSet = new pData;
$valores= array(1, 2, 5);
$nombres = array('Foro', 'Congreso', 'Curso');
$DataSet->AddPoint($valores,"Serie1");
$DataSet->AddPoint($nombres,"Serie2");  
$DataSet->AddAllSeries();  
$DataSet->SetAbsciseLabelSerie("Serie2");  
  
// Initialise the graph  
$Test = new pChart(400,200);
$Test->drawFilledRoundedRectangle(7,7,373,193,5,240,240,240);
$Test->drawRoundedRectangle(5,5,375,195,5,230,230,230);
   
// Draw the pie chart
$Test->setFontProperties("/Fonts/tahoma.ttf",10);
$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);
$Test->drawPieLegend(310,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);

$Test->Stroke("torta.png");
?>