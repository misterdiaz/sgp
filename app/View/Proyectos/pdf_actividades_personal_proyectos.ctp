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

$html = "";
//pr($Proyecto);
$vector = array();
$status = array(1=>'Activo', 2=>'Inactivo', 3=>'Culminado', 4=>'Cancelado');
$pdf->SetFont($textfont,'', 11);
$vectorP = array();
$projectoName['Proyecto'] = array();
$contador = $contadorJ=0;
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
	
	$Persona['nombre'] =  $nombre;
	$Persona['actividad'] =  $actividad;
	$Persona['fecha_inicio'] = $fecha_inicio;
	$Persona['fecha_culminacion'] = $fecha_culminacion;
	$Persona['avance'] = $avance;
	$Persona['estado'] = $status[$estado];

	if($ant != $nombre_proyecto){
		$projectoName['Proyecto']['Titulo'] = $ant;
		$projectoName['Proyecto']['Personas'] = $vectorP;
		$vectorP = array();
		array_push($vector, $projectoName);
	}
	$ant = $nombre_proyecto;
	array_push($vectorP, $Persona);
	
}//FIN FOREACH $Proyecto
$projectoName['Proyecto']['Titulo'] = $ant;
$projectoName['Proyecto']['Personas'] = $vectorP;
array_push($vector, $projectoName);
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
foreach ($vector as $vec) {
	$titulo = $vec['Proyecto']['Titulo'];
	$pdf->SetFont($textfont,'B', 14);
	$html .= "<ul><li><h3>$titulo</h3></li></ul>";
	$pdf->SetFont($textfont,'', 12);
	$html .= $html_header;
	foreach ($vec['Proyecto']['Personas'] as $persona) {
		$html .= '<tr>
				<td>'.$persona['nombre'].'</td>
				<td>'.$persona['actividad'].'</td>
				<td>'.$persona['fecha_inicio'].'</td>
				<td>'.$persona['fecha_culminacion'].'</td>
				<td>'.$persona['avance'].'</td>
				<td>'.$persona['estado'].'</td>
			</tr>
		';
	}
	$html .= "</table>";
}
$pdf->writeHTML($html);
//$pdf->MultiCell($w=0, $h=6,$html, $border="TLRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
//echo $html;exit;

//$pdf->MultiCell($w=0, $h=6, $html, $border="LRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
echo $pdf->Output("actividades_proyecto_personal.pdf", 'D');	
?>