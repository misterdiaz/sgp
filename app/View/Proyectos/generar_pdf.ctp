<?php
App::uses('Xtcpdf', 'Vendor/');

$pdf = new Xtcpdf();

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
$pdf->SetFont($textfont,'B',9);
$pdf->Cell(60, 6, "Objetivo Especifico", "LRB", 0, 'C');
$pdf->Cell(40, 6, "Actividad", "LRB", 0, 'C');
$pdf->Cell(40, 6, "Producto", "LRB", 0, 'C');
$pdf->Cell(40, 6, "Responsable", "LRB", 1, 'C');

//Comienzo a imprimir los objetivos, actividades, productos
$pdf->SetFont($textfont,'',9);
foreach($proyecto['Objetivo'] as $objetivo){
	
$objEspecifico = $objetivo['descripcion'];

$actividades = $actividades_clean = $productos = $productos_clean = $responsables = $responsables_clean = "";
$i=0;
foreach ($objetivo['Actividad'] as $actividad) {
	$i++;
	$nombreActividad = trim($actividad['nombre']);
	$nombreProducto = trim($actividad['producto']);
	$responsable = trim($actividad['Usuario']['fullname']);
	$actividades .= "<span><b>$i)</b> $nombreActividad. </span>";
	$actividades_clean .= "$i) $nombreActividad. ";
	$productos .= "<span><b>$i)</b> $nombreProducto. </span>";
	$productos_clean .= "$i) $nombreProducto. ";
	$responsables .= "<span><b>$i)</b> $responsable.<br/></span>";
	$responsables_clean .= "$i)</b> $responsable.";
}

$alturas[1] = $pdf->getStringHeight(60, $objEspecifico, $reseth=true, $autopadding=true, $cellpadding='', $border="LRB");
$alturas[2] = $pdf->getStringHeight(40, $actividades_clean, $reseth=true, $autopadding=true, $cellpadding='', $border="LRB");
$alturas[3] = $pdf->getStringHeight(40, $productos_clean, $reseth=true, $autopadding=true, $cellpadding='', $border="LRB");
$alturas[4] = $pdf->getStringHeight(40, $responsables_clean, $reseth=true, $autopadding=true, $cellpadding='', $border="LRB");

$h = round(max($alturas));
//pr($alturas); echo "Max h $h";

$pdf->MultiCell($w=60, $h, $txt=$objEspecifico, $border="LRB", $align='J', $fill=false, $ln=0, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=true);

$pdf->MultiCell($w=40, $h, $txt=$actividades, $border="LRB", $align='L', $fill=false, $ln=0, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=true);

$pdf->MultiCell($w=40, $h, $txt=$productos, $border="LRB", $align='L', $fill=false, $ln=0, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=true);

$pdf->MultiCell($w=40, $h, $txt=$responsables, $border="LRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=true);	
}

}

echo $pdf->Output("informe-proyecto.pdf", 'D');
?>