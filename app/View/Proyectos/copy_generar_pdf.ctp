<?php
App::uses('Xtcpdf', 'Vendor/');

$pdf = new Xtcpdf('L', 'mm', 'LETTER');

$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans'

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

//pr($Proyecto);
foreach($Proyecto as $proyecto){
$pdf->AddPage();
$pdf->Ln();
$nombre = $proyecto['Proyecto']['name'];
$objetivoGeneral = $proyecto['Proyecto']['objetivoGeneral'];
$pdf->SetFont($textfont,'B',10);
$pdf->Cell(0, 12, "Actividades, Productos y Responsables en el Proyecto ".$nombre, "TLRB", 1, 'C');

$pdf->SetFont($textfont,'', 9);
$pdf->MultiCell($w=0, $h=6, $txt="<b>Objetivo General: </b><br/>".$objetivoGeneral, $border="LRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);

//Header de la tabla de obj especificos, actividades, productos
$pdf->SetFont($textfont,'',9);
//$pdf->Cell(60, 6, "Objetivo Especifico", "LRB", 0, 'C');
//$pdf->Cell(40, 6, "Actividad", "LRB", 0, 'C');
//$pdf->Cell(40, 6, "Producto", "LRB", 0, 'C');
//$pdf->Cell(40, 6, "Responsable", "LRB", 1, 'C');
$html_header = '<table border="0.5px" style="margin:5px;text-align:justify;">
<tr>
	<th style="text-align:center;font-weight:bold;">Objetivo Especifico</th>
	<th style="text-align:center;font-weight:bold;">Actividad</th>
	<th style="text-align:center;font-weight:bold;">Producto</th>
	<th style="text-align:center;font-weight:bold;">Responsable</th>
</tr>';

//$pdf->writeHTML($html_header, true, false, true, false, '');
//Comienzo a imprimir los objetivos, actividades, productos
$pdf->SetFont($textfont,'',9);
$html_body = $html_act = "";
foreach($proyecto['Objetivo'] as $objetivo){
	
$objEspecifico = $objetivo['descripcion'];
	
$i=0;
$row_span=count($objetivo['Actividad']);
$html_obj = '
<tr>
	<td>'.$objEspecifico.'</td>';
$html_act = '
<td>
<table border="0" width="100%">';

$html_pro = '
<td>
<table border="0" width="100%">';

$html_res = '
<td>
<table border="0" width="100%">';

foreach ($objetivo['Actividad'] as $actividad) {
	$i++;
	$nombreActividad = trim($actividad['nombre']);
	$nombreProducto = trim($actividad['producto']);
	$responsable = trim($actividad['Usuario']['fullname']);
$html_act .= '
<tr>
<td><b>'.$i.'</b>&nbsp;'.$nombreActividad.'</td>
</tr>';

$html_pro .= '
<tr>
<td><b>'.$i.'</b>&nbsp;'.$nombreProducto.'</td>
</tr>';

$html_res .= '
<tr>
<td><b>'.$i.'</b>&nbsp;'.$responsable.'</td>
</tr>';


}
$html_act .= '
</table>
</td>';

$html_pro .= '
</table>
</td>';

$html_res .= '
</table>
</td>';

$html_body .= $html_obj.$html_act.$html_pro.$html_res.'</tr>';	
}

}

$html= $html_header.$html_body.'</table>';
$pdf->MultiCell($w=0, $h=6, $html, $border="LRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
//$pdf->writeHTML($html, true, false, true, false, '');
echo $pdf->Output("informe-proyecto.pdf", 'D');
?>