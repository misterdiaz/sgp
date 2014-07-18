<?php
App::uses('Xtcpdf', 'Vendor/');

$pdf = new Xtcpdf('landscape', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans'

$pdf->SetAuthor("Sistema Administrativo CPDI");
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(false);

    // set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "CAEFII", PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// Now you position and print your page content
// example: 
$meses = array(0=>'Todos', 1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre');
$mes_letra = mes2letras($mes);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont($textfont,'B',12);
$pdf->AddPage();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(0, 8, "Relación Mensual de Actividades participativas del CPDI",'',1,'C');
$pdf->Cell(0, 6, "Mes: $mes_letra ".date('Y'),'',1,'C');
$pdf->Ln();
$pdf->SetFont($textfont,'',11);
$pdf->multiCell(0,8, "Programación de actividades participativas (internas o externas) previstas para el mes en curso, relacionadas con  eventos colectivos tales como: reuniones, presentaciones, asistencia a eventos,  participación y/o publicación de nuestro personal en medios comunicacionales, entre otros.");
$pdf->Ln();
$pdf->Cell(90,8, "NOMBRES",'TLRB',0,'L');
$pdf->Cell(70,8, "ACTIVIDAD PARTICIPATIVA",'TRB',0,'L');
$pdf->Cell(25,8, "FECHA",'TRB',0,'L');
$pdf->Cell(80,8, "DESCRIPCIÓN",'TRB',1,'L');
$pdf->SetFont($textfont,'',11);
$tipo_actividades = array(1=>'Reunión', 2=>'Presentación', 3=>'Asistencia a eventos', 4=>'Publicaciones', 5=>'Otro');
$anterior = "";
$final = count($actividades);
$i = 0;
foreach ($actividades as $actividad) {
	$usuario_id = $actividad['VActividad']['usuario_id'];	
	$nombre = $actividad['VActividad']['nombre'];
	$nombre_actividad = $actividad['VActividad']['actividad'];
	$tipo_actividad = $actividad['VActividad']['tipo'];
	$descripcion = $actividad['VActividad']['descripcion'];
	$fecha = $actividad['VActividad']['fecha'];
	$dia = $actividad['VActividad']['dia'];
	$mes = $actividad['VActividad']['mes'];
	$year = $actividad['VActividad']['year'];
$text_height = $pdf->getStringHeight(80, $nombre_actividad.": ".$descripcion, true, true, '', '');
$i++;
if($usuario_id == $anterior){
	$pdf->Cell(90, $text_height, "",'LR',0,'L');
}else{
	if($i == $final){
		$pdf->Cell(90, $text_height, $nombre,'BTLR',0,'L');
	}else{
		$pdf->Cell(90, $text_height, $nombre,'TLR',0,'L');
	}
	
}

$pdf->Cell(70, $text_height, $tipo_actividades[$tipo_actividad],'RB',0,'L');
$pdf->Cell(25, $text_height, turnFecha($fecha),'RB',0,'C');
$pdf->multiCell(80, $text_height, $nombre_actividad.": ".$descripcion, "RB", "L");
if($usuario_id != $anterior) $anterior = $usuario_id; 

}
//pr($respuestas);
//pr($prestamo);

$pdf->Ln();
$pdf->Ln();
$pdf->SetFont($textfont,'',11);


echo $pdf->Output("actividades_participativas_".$mes_letra."_".$year.".pdf", 'D');
?>
