<?php
App::uses('Xtcpdf', 'Vendor/');

$pdf = new Xtcpdf('L', 'mm', 'LETTER');

$textfont = 'times'; // looks better, finer, and more condensed than 'dejavusans'

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
$pdf->SetFont($textfont,'B',12);
foreach($Proyecto as $proyecto){
$pdf->AddPage();
$pdf->Ln();
//pr($proyecto);
$nombre = $proyecto['Proyecto']['name'];
$coordinador = $proyecto['Usuario']['fullname'];
$cliente = $proyecto['Proyecto']['cliente'];
$codigo = $proyecto['Proyecto']['codigo'];
$presupuesto = $proyecto['Proyecto']['presupuesto'];
$fecha_inicio = $proyecto['Proyecto']['fecha_inicio'];
$fecha_culminacion = $proyecto['Proyecto']['fecha_culminacion'];
$objetivoGeneral = $proyecto['Proyecto']['objetivoGeneral'];
$pdf->SetFont($textfont,'B',12);
//$pdf->MultiCell($w=0, $h=6, "RESUMEN PROYECTO", $border="TLRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->MultiCell($w=0, $h=6, "Resumen del Proyecto: ".$nombre, $border="", $align='C', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->Ln();
$pdf->SetFont($textfont,'',11);
$pdf->MultiCell($w=100, $h=6, "<b>Coordinador:</b> ".$coordinador, $border="", $align='L', $fill=false, $ln=0, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->MultiCell($w=80, $h=6, "<b>Código FIIIDT:</b> ".$codigo, $border="", $align='L', $fill=false, $ln=0, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->MultiCell($w=100, $h=6, "<b>Fecha de inicio:</b> ".$fecha_inicio, $border="", $align='L', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);

$pdf->MultiCell($w=100, $h=6, "<b>Cliente:</b> ".$cliente, $border="", $align='L', $fill=false, $ln=0, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->MultiCell($w=80, $h=6, "<b>Presupuesto:</b> ".$presupuesto." Bs.", $border="", $align='L', $fill=false, $ln=0, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->MultiCell($w=100, $h=6, "<b>Fecha de culminación:</b> ".$fecha_culminacion, $border="", $align='L', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->Ln();
$pdf->MultiCell($w=0, $h=6, $txt="<b>Objetivo General: </b><br/>".$objetivoGeneral, $border="TLRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);


$html_header = '
<table border="0.5px" style="margin:5px;text-align:justify;">
	<tr>
		<th style="text-align:center;font-weight:bold;">Objetivo Especifico</th>
		<th style="text-align:center;font-weight:bold;">Actividad</th>
		<th style="text-align:center;font-weight:bold;">Producto</th>
		<th style="text-align:center;font-weight:bold;">Responsable</th>
	</tr>';

$html_body = "";
	foreach($proyecto['Objetivo'] as $objetivo){
		
		$objEspecifico = $objetivo['descripcion'];
			
		$i=0;
		$row_span=count($objetivo['Actividad']);
		$html_body .= '
		<tr>
		<td rowspan="'.$row_span.'">'.$objEspecifico.'</td>';
		
		if(!empty($objetivo['Actividad'])){
		
			foreach ($objetivo['Actividad'] as $actividad) {
				$i++;
				$nombreActividad = trim($actividad['nombre']);
				$nombreProducto = trim($actividad['producto']);
				$responsable = trim($actividad['Usuario']['fullname']);
				//echo "i: $i - row_span: $row_span <br/>";
				if($i == 1){
					$html_body .= '
						<td>
							<b>'.$i.'-</b>&nbsp;'.$nombreActividad.'
						</td>
						<td>
							'.$nombreProducto.'
						</td>
						<td>'.$responsable.'</td>
					</tr>';
				}else{
					$html_body .= '
					<tr>
						<td>
							<b>'.$i.'-</b>&nbsp;'.$nombreActividad.'
						</td>
						<td>
							'.$nombreProducto.'
						</td>
						<td>'.$responsable.'</td>
					</tr>';
				}
			    
			}//FIN FOREACH ACTIVIDADES
		
		}else{
			$html_body .= '
						<td>S/I</td>
						<td>S/I</td>
						<td>S/I</td>
					</tr>';
		}
		
	}//FIN FOREACH OBJETIVOS
$html= $html_header.$html_body.'</table>';
//echo $html;
$pdf->writeHTML($html);
}



//$pdf->MultiCell($w=0, $h=6, $html, $border="LRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
switch ($tipo) {
	case 1://Proyectos individuales
		echo $pdf->Output("resumen_proyecto_$nombre.pdf", 'FD');
		break;
	case 2://Todos los proyectos
		echo $pdf->Output("resumen_proyectos.pdf", 'D');
		break;
	case 3://Solo activos
		echo $pdf->Output("resumen_proyectos_activos.pdf", 'D');
		break;
	case 4://Solo culminados
		echo $pdf->Output("resumen_proyectos_culminados.pdf", 'D');
		break;
	
	default:
		echo $pdf->Output("resumen_proyectos.pdf", 'FD');	
		break;
}
?>
