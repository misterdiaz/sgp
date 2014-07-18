<?php
App::import('Vendor','xtcpdf'); 
$pdf = new XTCPDF();
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
$pdf->SetFont($textfont,'B',12);
$pdf->AddPage();
switch ($semestre) {
	case 1:
	$pdf->Cell(0, 4, "Datos estadísticos de eventos durante el año $year - Primer Semestre:", 0, 1, 'C');
	break;
	
	case 2:
	$pdf->Cell(0, 4, "Datos estadísticos de eventos durante el año $year - Segundo Semestre:", 0, 1, 'C');
	break;
}
$pdf->Ln();
$pdf->SetFont($textfont,'',10);
$pdf->Cell(0, 6, "Cuadro Resumen", "TLRB", 1, 'C');
$pdf->SetFont($textfont,'',9);
$pdf->Cell(0, 6, "Cantidad de Eventos: $cant_eventos", "LR", 1, 'L');
$cadena = "";
$cont = count($tipo_eventos);
$i=0;
foreach ($tipo_eventos as $tipo){
	$cadena .= $tipo['VEventosTipo']['title']." - "." ".$tipo['VEventosTipo']['cant'];
	if($i++ != $cont-1){
		$cadena .= ", ";
	}
}
$pdf->Cell(0, 6, "Tipos de Eventos: $cadena", "LR", 1, 'L');
$pdf->Cell(95, 6, "Eventos Nacionales: ".$nacional[0][0]['count'], "L", 0, 'L');
$pdf->Cell(91, 6, "Eventos Internacionales: ".$internacional[0][0]['count'], "R", 1, 'L');
$pdf->Cell(0, 6, "Personal que participo en los eventos: ".$cant_personal[0]['cant_personal'], "LRB", 1, 'L');
$pdf->Ln();
$pdf->SetFont($textfont,'',11);
$pdf->Cell(0, 6, "Gráfico comparativo con respecto al año $year", 0, 1, 'L');
$pdf->Ln();
$y = $pdf->GetY();
$pdf->Image("graficos/graficos_semestre_".$semestre."_".$year.".png", $pdf->getX(), $y, 180);
$pdf->SetY($y+90);
$pdf->Cell(90, 6, "Gráfico de eventos según su tipo:", 0, 0, 'L');
$pdf->Cell(90, 6, "Gráfico de eventos según su nivel:", 0, 1, 'L');
$pdf->Image("graficos/graficos_torta_tipo_eventos_semestre_".$semestre."_".$year.".png", $pdf->getX(), $pdf->GetY()+15, 90);
$pdf->Image("graficos/graficos_torta_nacionalidad_semestre_".$semestre."_".$year.".png", $pdf->getX()+90, $pdf->GetY()+15, 90);
echo $pdf->Output("reporte_por_semestre_".$year."_".$semestre.".pdf", 'D');
?>