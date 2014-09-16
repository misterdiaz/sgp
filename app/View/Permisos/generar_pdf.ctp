<?php
App::uses('Xtcpdf', 'Vendor/');

$pdf = new Xtcpdf('P', 'mm', 'LETTER');

$textfont = 'times'; // looks better, finer, and more condensed than 'dejavusans'

$pdf->SetAuthor("FUNDACION INSTITUTO DE INGENIERIA - CPDI");
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(false);

    // set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "FII", PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetTextColor(0, 0, 0);

//pr($Permiso);
$nro = $Permiso['Permiso']['nro'];
$trabajador = $Permiso['Usuario']['fullname'];
$fecha_solicitud = $Permiso['Permiso']['fecha_solicitud'];
$unidad = $Permiso['Centro']['name'];
$cargo = $Permiso['Cargo']['siglas'];
$cedula = $Permiso['Usuario']['cedula'];
$fecha_desde = $Permiso['Permiso']['fecha_desde'];
$fecha_hasta = $Permiso['Permiso']['fecha_hasta'];
$lapso = $fecha_desde." - ".$fecha_hasta;
$tipo_permiso = $Permiso['Permiso']['tipo_permiso'];
$remunerado = $no_remunerado = "";
if($tipo_permiso == 1){
	$remunerado = "X";
}else{
	$no_remunerado = "X";
}
$dias = $Permiso['Permiso']['nro_dias'];
if($dias == 0.5) $dias = "1/2";
$causa = $Permiso['Permiso']['causa'];

$pdf->AddPage();
$pdf->SetFont($textfont,'B',14);
$pdf->MultiCell($w=0, $h=6, "Solicitud de Concesión de Licencias o Permisos", $border="", $align='C');
$pdf->MultiCell($w=0, $h=6, "Remunerados o No Remunerados ", $border="", $align='C');
$pdf->SetFont($textfont,'',12);
$pdf->MultiCell($w=0, $h=10, "FORM. GDRR.HH 03/99", $border="", $align='C');

$pdf->SetFont($textfont,'B',11);

$pdf->Cell($w=0, $h=14, "I- DATOS A SER LLENADOS POR EL SOLICITANTE", $border="TBLR", $ln=1, $align='C');

//PRIMERA FILA:
$pdf->SetFont($textfont,'B',11);
$pdf->Cell($w=35, $h=6, "1- N°:", $border="TL", $ln=0, $align='L');
$pdf->Cell($w=95, $h=6, "2- Trabajador Solicitante:", $border="TL", $ln=0, $align='L');
$pdf->Cell($w=56, $h=6, "3- Fecha de Solicitud:", $border="TLR", $ln=1, $align='L');
$pdf->SetFont($textfont,'',11);
$pdf->Cell($w=35, $h=8, $nro, $border="BL", $ln=0, $align='C');
$pdf->Cell($w=95, $h=8, $trabajador, $border="BL", $ln=0, $align='C');
$pdf->Cell($w=56, $h=8, $fecha_solicitud, $border="BLR", $ln=1, $align='C');

//SEGUNDA FILA:
$pdf->SetFont($textfont,'B',11);
$pdf->Cell($w=93, $h=6, "4- Unidad de Adscripción:", $border="TL", $ln=0, $align='L');
$pdf->Cell($w=93, $h=6, "5- Denominación del Cargo:", $border="TLR", $ln=1, $align='L');
$pdf->SetFont($textfont,'',11);
$pdf->Cell($w=93, $h=8, $unidad, $border="BL", $ln=0, $align='C');
$pdf->Cell($w=93, $h=8, $cargo, $border="BLR", $ln=1, $align='C');

//TERCERA FILA
$pdf->SetFont($textfont,'B',11);
$pdf->Cell($w=46, $h=8, "6- Cédula de Identidad N°:", $border="TL", $ln=0, $align='L');
$pdf->Cell($w=44, $h=8, "7- Lapso Solicitado:", $border="TL", $ln=0, $align='L');
$pdf->Cell($w=52, $h=8, "8- Permiso:", $border="TL", $ln=0, $align='C');
$pdf->Cell($w=44, $h=8, "9- N° Días Hábiles", $border="TLR", $ln=1, $align='C');
$pdf->Cell($w=46, $h=6, "", $border="TL", $ln=0, $align='L');
$pdf->Cell($w=44, $h=6, "", $border="TL", $ln=0, $align='L');
$pdf->SetFont($textfont,'',11);
$pdf->Cell($w=24, $h=6, "Remunerado", $border="TL", $ln=0, $align='L');
$pdf->Cell($w=28, $h=6, "No Remunerado", $border="TL", $ln=0, $align='L');
$pdf->SetFont($textfont,'B',11);
$pdf->Cell($w=44, $h=6, "Solicitados:", $border="LR", $ln=1, $align='C');
$pdf->SetFont($textfont,'',11);
$pdf->Cell($w=46, $h=8, $cedula, $border="BL", $ln=0, $align='C');
$pdf->Cell($w=44, $h=8, $lapso, $border="BL", $ln=0, $align='C');
$pdf->Cell($w=24, $h=8, $remunerado, $border="BL", $ln=0, $align='C');
$pdf->Cell($w=28, $h=8, $no_remunerado, $border="BL", $ln=0, $align='C');
$pdf->Cell($w=44, $h=8, $dias, $border="BLR", $ln=1, $align='C');

//CUARTA FILA:
$pdf->SetFont($textfont,'B',11);
$pdf->Cell($w=68, $h=6, "10- Firma del Trabajador Solicitante:", $border="TL", $ln=0, $align='L');
$pdf->Cell($w=44, $h=6, "11- Conformado:", $border="TL", $ln=0, $align='L');
$pdf->Cell($w=74, $h=6, "12- Autorizado Gerente/Jefe de Centro:", $border="TLR", $ln=1, $align='L');
$pdf->SetFont($textfont,'',11);
$pdf->Cell($w=68, $h=10, "", $border="BL", $ln=0, $align='L');
$pdf->Cell($w=44, $h=10, "", $border="BL", $ln=0, $align='L');
$pdf->Cell($w=74, $h=10, "", $border="BLR", $ln=1, $align='L');

//QUINTA FILA:
$pdf->SetFont($textfont,'B',11);
$pdf->Cell($w=0, $h=6, "13- CAUSA DEL PERMISO SOLICITADO:", $border="TLR", $ln=1, $align='L');
$pdf->SetFont($textfont,'',11);
$pdf->MultiCell($w=0, $h=6, $causa, $border="BLR", $align='L');

//TITULO DOS:
$pdf->SetFont($textfont,'B',12);
$pdf->Cell($w=0, $h=12, "II- SOLO PARA USO DE LA GERENCIA DE DESARROLLO DE RECURSOS HUMANOS", $border="TBLR", $ln=1, $align='C');

//SEXTA FILA:
$pdf->SetFont($textfont,'B',11);
$pdf->Cell($w=93, $h=8, "14- N° de Días Hábiles de Permiso:", $border="TL", $ln=0, $align='C');
$pdf->Cell($w=93, $h=8, "15- Lapso Concedido", $border="TLR", $ln=1, $align='C');
$pdf->SetFont($textfont,'',11);
$pdf->Cell($w=46.5, $h=6, "Remunerado", $border="TL", $ln=0, $align='C');
$pdf->Cell($w=46.5, $h=6, "No Remunerado", $border="TL", $ln=0, $align='C');
$pdf->Cell($w=46.5, $h=6, "", $border="L", $ln=0, $align='L');
$pdf->Cell($w=46.5, $h=6, "", $border="R", $ln=1, $align='L');

$pdf->Cell($w=46.5, $h=6, "", $border="BL", $ln=0, $align='C');
$pdf->Cell($w=46.5, $h=6, "", $border="BL", $ln=0, $align='C');
$pdf->SetFont($textfont,'B',11);
$pdf->Cell($w=46.5, $h=6, "Desde:    /    /    ", $border="BL", $ln=0, $align='L');
$pdf->Cell($w=46.5, $h=6, "Hasta:    /    /    ", $border="BR", $ln=1, $align='L');

//OCTAVA FILA:
$pdf->SetFont($textfont,'B',11);
$pdf->Cell($w=0, $h=8, "16- OBSERVACIONES:", $border="LR", $ln=1, $align='L');
$pdf->MultiCell($w=0, $h=8, "", $border="TBLR", $align='L');

//NOVENA FILA:
$pdf->SetFont($textfont,'B',11);
$pdf->Cell($w=60, $h=8, "Conforme Gerencia:", $border="TL", $ln=0, $align='L');
$pdf->Cell($w=126, $h=8, "17- OBSERVACIONES:", $border="TBLR", $ln=1, $align='L');
$pdf->Cell($w=60, $h=8, "", $border="BL", $ln=0, $align='L');
$pdf->Cell($w=126, $h=8, "", $border="BLR", $ln=1, $align='L');

//DECIMA FILA
$pdf->Cell($w=126, $h=6, "", $border="", $ln=0, $align='L');
$pdf->Cell($w=60, $h=6, "Recibido GDRR-HH", $border="LR", $ln=1, $align='C');
$pdf->Cell($w=126, $h=5, "C.C. : TRABAJADOR SOLICITANTE", $border="", $ln=0, $align='L');
$pdf->Cell($w=30, $h=5, "Fecha:", $border="TLR", $ln=0, $align='L');
$pdf->Cell($w=30, $h=5, "Firma:", $border="TLR", $ln=1, $align='L');
$pdf->Cell($w=126, $h=6, "", $border="", $ln=0, $align='L');
$pdf->Cell($w=30, $h=6, "", $border="BLR", $ln=0, $align='L');
$pdf->Cell($w=30, $h=6, "", $border="BLR", $ln=1, $align='L');

$pdf->Ln();
$pdf->SetFont($textfont,'B',9);
$pdf->Cell($w=0, $h=4, "Junta Ejecutiva", $border="", $ln=1, $align='L');
$pdf->Cell($w=0, $h=4, "19/03/2001", $border="", $ln=1, $align='L');
$pdf->SetFont($textfont,'',10);
$pdf->Cell($w=0, $h=4, "/bt", $border="", $ln=1, $align='R');

echo $pdf->Output("permiso_".$trabajador.".pdf", 'FD');	
?>
