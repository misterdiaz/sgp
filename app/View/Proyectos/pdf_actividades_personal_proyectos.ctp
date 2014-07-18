<?php
App::uses('Xtcpdf', 'Vendor/');

$pdf = new Xtcpdf('L', 'mm', 'LETTER');

$textfont = 'arial'; 
//echo $textfont;
$pdf->SetAuthor("FUNDACION INSTITUTO DE INGENIERIA - CPDI");
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "FII", PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// Now you position and print your page content
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont($textfont,'B',14);
$pdf->AddPage();

$pdf->MultiCell($w=0, $h=6, "Actividades de Proyecto por Personal", $border="", $align='C', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->MultiCell($w=0, $h=6, $tipo, $border="", $align='C', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->Ln();
$pdf->SetFont($textfont,'B',12);

$html_header = '
<table border="0.5px" style="margin:5px;text-align:justify;">
	<tr>
		<th style="text-align:center;font-weight:bold;" width="150px">Nombre y Apellido</th>
		<th style="text-align:center;font-weight:bold;" width="280px">Actividad</th>
		<th style="text-align:center;font-weight:bold;" width="80px">Fecha<br/>Inicio</th>
		<th style="text-align:center;font-weight:bold;" width="80px">Fecha<br/>Culminacion</th>
		<th style="text-align:center;font-weight:bold;" width="50px">% Avance</th>
		<th style="text-align:center;font-weight:bold;" width="70px">Estado</th>
	</tr>';
$html_body = $ant = "";
$html = "";
//pr($Proyecto);
$status = array(1=>'Activo', 2=>'Inactivo', 3=>'Culminado', 4=>'Cancelado');
$pdf->SetFont($textfont,'', 11);
foreach ($Proyecto as $row) {
	$nombre_proyecto = $row['VActividad']['proyecto'];
	if(empty($ant)) $ant = $nombre_proyecto;
	$nombre = $row['VActividad']['fullname'];
	$proyecto = $row['VActividad']['proyecto'];
	$actividad = $row['VActividad']['actividad'];
	if(!empty($row['VActividad']['fecha_inicio'])) $fecha_inicio = $row['VActividad']['fecha_inicio'];
	else $fecha_inicio="N/A"; 
	if(!empty($row['VActividad']['fecha_culminacion'])) $fecha_culminacion = $row['VActividad']['fecha_culminacion'];
	else $fecha_culminacion="N/A";
	$avance = $row[0]['avance'];
	$estado = $row['VActividad']['status_actividad'];
	
	 $html_body .= '
	<tr style="vertical-align: inherit;">
		<td>'.$nombre.'</td>
		<td>'.$actividad.'</td>
		<td>'.$fecha_inicio.'</td>
		<td>'.$fecha_culminacion.'</td>
		<td style="text-align:rigth;">'.$avance.'</td>
		<td style="text-align:center;">'.$status[$estado].'</td>
	</tr>';
	if($ant != $nombre_proyecto){
		$pdf->SetFont($textfont,'B', 14);
		//$pdf->Ln();
		//$pdf->MultiCell($w=0, $h=6, "Proyecto: ".$ant, $border="", $align='L', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
		$h2 = "<h3> Proyecto: ".$ant."</h3>";
		$html .= $h2.$html_header.$html_body.'</table><br/>';
		$pdf->SetFont($textfont,'', 12);
		$ant = 	$nombre_proyecto;
		//echo $html;
		$html_body = "";
	}
	
}//FIN FOREACH $Proyecto
$pdf->writeHTML($html);
//$pdf->MultiCell($w=0, $h=6,$html, $border="TLRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
//echo $html;exit;

//$pdf->MultiCell($w=0, $h=6, $html, $border="LRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
echo $pdf->Output("actividades_proyecto_personal.pdf", 'D');	
?>