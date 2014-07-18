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
$pdf->AddPage();
$pdf->Ln();
$pdf->SetFont($textfont,'B',12);
//$pdf->MultiCell($w=0, $h=6, "RESUMEN PROYECTO", $border="TLRB", $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->MultiCell($w=0, $h=6, "Reporte de Actividades del Personal", $border="", $align='C', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0, $valign='T', $fitcell=false);
$pdf->Ln();
$pdf->SetFont($textfont,'', 11);
$personal = $vector = $act = array();
$i=0;
$ant = "";
$v[] = $v['ReporteActividad']['fullname'] = $v['ReporteActividad']['actividad'] = $v['ReporteActividad']['proyecto'] = $v['ReporteActividad']['fecha_inicio'] = $v['ReporteActividad']['fecha_culminacion'] = array();
array_push($actividades, $v);
foreach ($actividades as $actividad) {

	$nombre = $actividad['ReporteActividad']['fullname'];
	$titulo = $actividad['ReporteActividad']['actividad'];
	$proyecto = $actividad['ReporteActividad']['proyecto'];
	$fecha_inicio = $actividad['ReporteActividad']['fecha_inicio'];
	$fecha_culminacion = $actividad['ReporteActividad']['fecha_culminacion'];
	$act = array();
	$act['titulo'] = $titulo;
	$act['proyecto'] = $proyecto;
	$act['fecha_inicio'] = $fecha_inicio;
	$act['fecha_culminacion'] = $fecha_culminacion;
	//pr($act);
	//echo "nombre: $nombre | anterior: $ant <br/>";
	if(empty($ant)){
		$vector['nombre'] = $nombre;
		$vector['Actividades'] = array();
		$ant = $nombre;
	}
	if($ant==$nombre){
		array_push($vector['Actividades'], $act);
	}else{
		array_push($personal, $vector);
		$vector = array();
		$ant = $nombre;
		$vector['nombre'] = $nombre;
		$vector['Actividades'] = array();
		array_push($vector['Actividades'], $act);
	}


}//FIN DEL FOREACH PERSONAL
//pr($actividades);
//pr($personal);
$html="<style>.centro{text-align:center;}.titulo{text-align:center;font-weight:bold;}</style>";
foreach ($personal as $persona){
	$nombre=$persona['nombre'];
$html.='<h3>'.$nombre.'</h3>
<table border="1">
	<tr>
		<th class="titulo" width="20px">Nro</th>
		<th class="titulo" width="300">Actividad</th>
		<th class="titulo" width="250">Proyecto</th>
		<th class="titulo" width="65px">Fecha inicio</th>
		<th class="titulo" width="65px">Fecha culminación</th>
	</tr>';
	$i=0;
	foreach ($persona['Actividades'] as $row) {
		//pr($row);
		$actividad = $row['titulo'];
		$proyect = $row['proyecto'];
		$inicio = $row['fecha_inicio'];
		$culminacion = $row['fecha_culminacion'];
		$i++;
		$html.='<tr>
		<td class="centro">'.$i.'</td>
		<td>'.$actividad.'</td>
		<td>'.$proyect.'</td>
		<td class="centro">'.$inicio.'</td>
		<td class="centro">'.$culminacion.'</td>
		</tr>';
	}
	$html.='</table>';		
}

//echo $html;exit;
$pdf->writeHTML($html);

echo $pdf->Output("resumen_actividades_personal.pdf", 'D');
?>