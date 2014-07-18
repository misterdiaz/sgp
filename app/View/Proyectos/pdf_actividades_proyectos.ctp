<?php
App::uses('Xtcpdf', 'Vendor/');

$pdf = new Xtcpdf('L', 'mm', 'LETTER');

$textfont = 'arial'; // looks better, finer, and more condensed than 'dejavusans'

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
// example: 
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont($textfont,'B',14);
$pdf->AddPage();

$pdf->MultiCell($w=0, $h=6, "Avance de Actividades por Proyecto", $border="", $align='C', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->MultiCell($w=0, $h=6, $tipo, $border="", $align='C', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->Ln();
$pdf->SetFont($textfont,'B',12);

$html_header = '
<table border="0.5px" style="margin:5px;text-align:justify;">
	<tr>
		<th style="text-align:center;font-weight:bold;" width="280px">Nombre del Proyecto</th>
		<th style="text-align:center;font-weight:bold;" width="150px">Responsable</th>
		<th style="text-align:center;font-weight:bold;" width="80px">Fecha<br/>Inicio</th>
		<th style="text-align:center;font-weight:bold;" width="80px">Fecha<br/>Culminacion</th>
		<th style="text-align:center;font-weight:bold;" width="50px">% Avance</th>
		<th style="text-align:center;font-weight:bold;" width="70px">Estado</th>
	</tr>';
$html_body = "";
$ant_nombre = $Proyecto[0]['VActividad']['proyecto'];
//$vector = $Proyecto[0];
$html = "";
$avance = $avance_ant = 0;
//pr($Proyecto);
$status = array(1=>'Activo', 2=>'Inactivo', 3=>'Culminado', 4=>'Cancelado');
$pdf->SetFont($textfont,'', 11);
$i=0;
$cant = count($Proyecto);
foreach ($Proyecto as $row) {
	$nombre_proyecto = $row['VActividad']['proyecto'];
	$responsable = $row['VActividad']['coordinador'];
	if(!empty($row['VActividad']['inicio_proyecto'])) $fecha_inicio = $row['VActividad']['inicio_proyecto'];
	else $fecha_inicio="N/A"; 
	if(!empty($row['VActividad']['fin_proyecto'])) $fecha_culminacion = $row['VActividad']['fin_proyecto'];
	else $fecha_culminacion="N/A";
	$porcentaje = $row[0]['porcentaje'];
	$peso = $row[0]['peso'];
	$estado = $row['VActividad']['status_proyecto'];
	$avance += ($peso * $porcentaje) / 100;
	$vAvance[$i] = $avance;
	if(($ant_nombre != $nombre_proyecto)){
		$vector[$i]=$Proyecto[$i-1];
		$vector[$i][0]['avance']= $vAvance[$i-1];
		$avance=($peso * $porcentaje) / 100;
		$vAvance[$i] = $avance;
		//echo "ant = $avance - | nombre = ".$vAvance[$i-1]."<br/>";
		$ant_nombre = $nombre_proyecto;
		//echo $html;
	}
	$i++;
	
}//FIN FOREACH $Proyecto
$vector[$i-1] = $Proyecto[$i-1];
$vector[$i-1][0]['avance'] = $avance;
//pr($vAvance);
///pr($vector);
foreach ($vector as $fila) {
	$html_body .= '
	<tr style="vertical-align: inherit;">
		<td>'.$fila['VActividad']['proyecto'].'</td>
		<td>'.$fila['VActividad']['coordinador'].'</td>
		<td style="text-align:center;">'.$fila['VActividad']['inicio_proyecto'].'</td>
		<td style="text-align:center;">'.$fila['VActividad']['fin_proyecto'].'</td>
		<td style="text-align:center;">'.$fila[0]['avance'].'</td>
		<td style="text-align:center;">'.$status[$fila['VActividad']['status_proyecto']].'</td>
	</tr>';	
}

$pdf->SetFont($textfont,'', 12);
$html = $html_header.$html_body.'</table>';
$pdf->writeHTML($html);
//$pdf->MultiCell($w=0, $h=6,$html, $border="TLRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
//echo $html;exit;

//$pdf->MultiCell($w=0, $h=6, $html, $border="LRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
echo $pdf->Output("actividades_proyecto_personal.pdf", 'D');	
?>