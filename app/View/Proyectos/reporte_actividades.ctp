<?php
$this->Html->addCrumb('Proyectos', array('controller'=>'Proyectos', 'action'=>'index'));
$this->Html->addCrumb('Reportes', array('controller'=>'Proyectos', 'action'=>'reportes'));
$this->Html->addCrumb('Actividades', '');
?>
<h2>Reporte de actividades del personal</h2>

<?php
//pr($proyectos);
if(!empty($proyectos)){
	$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
	echo $this->Form->create('Proyecto', array('class'=>'form form-inline', 'inputDefaults'=>$defaults));
	$semestre = array(1=>'1er Semestre (Ene-Jun)', 2=>'2do Semestre (Jul-Dic');
?>
<div class="form-group">
	<label for="ProyectoProyectoId">Proyecto: </label>
	<?= $this->Form->input('proyecto_id', array('required'=>false, 'empty'=>'Todos...')) ?>

	<label for="ProyectoSemestre">Semestre: </label>
	<?= $this->Form->input('semestre', array('empty'=>'Ambos...', 'options'=>$semestre)) ?>

	<?php echo $this->Form->end(array('label'=>'Continuar', 'div'=>false, "class"=>"btn btn-default")); ?>
</div>
<?
}else
	echo "<h3>No hay proyectos asignados para Ud. Posiblemente no sea el jefe del proyecto o el proyecto no esta activo.</h3>";
?>

<?php 
if($this->request->is('post')):
?>
<div class='span-24'>
<?php
$personal = $vector = $act = array();
$i=0;
$ant = "";
$v[] = $v['ReporteActividad']['fullname'] = $v['ReporteActividad']['actividad'] = $v['ReporteActividad']['proyecto'] = $v['ReporteActividad']['fecha_inicio'] = $v['ReporteActividad']['fecha_culminacion'] = array();

array_push($actividades, $v);
foreach ($actividades as $actividad) {
	//pr($actividad);
	$nombre = $actividad['ReporteActividad']['fullname'];
	$titulo = $actividad['ReporteActividad']['actividad'];
	$proyecto = $actividad['ReporteActividad']['proyecto'];
	$fecha_inicio = $actividad['ReporteActividad']['fecha_inicio'];
	$fecha_culminacion = $actividad['ReporteActividad']['fecha_culminacion'];
	$porcentaje = $actividad['ReporteActividad']['avance'];
	$act = array();
	$act['titulo'] = $titulo;
	$act['proyecto'] = $proyecto;
	$act['fecha_inicio'] = $fecha_inicio;
	$act['fecha_culminacion'] = $fecha_culminacion;
	$act['avance'] = $porcentaje;
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
//array_push($vector['Actividades'], $act);
//pr($actividades);
//pr($personal);
?>

<?php
	foreach ($personal as $persona){
		$nombre=$persona['nombre'];
?>
<h3><?= $nombre ?></h3>
<table class='table table-bordered table-striped'>
	<thead>
	<tr class='info'>
		<th class='col-md-1'>Nro</th>
		<th class='col-md-5'>Actividad</th>
		<th class='col-md-3'>Proyecto</th>		
		<th class='col-md-1'>Fecha<br/>inicio</th>
		<th class='col-md-1'>Fecha<br/>culminación</th>
		<th class='col-md-1'>Porcentaje de avance</th>
	</tr>
	</thead>
<?php
	$i=0;
	foreach ($persona['Actividades'] as $row) {
		//pr($row);
		$actividad = $row['titulo'];
		$proyect = $row['proyecto'];
		$avance = $row['avance'];
		$inicio = $row['fecha_inicio'];
		$culminacion = $row['fecha_culminacion'];
		$i++;
		echo"<tr>";
		echo "<td>$i</td>";
		echo "<td>$actividad</td>";
		echo "<td>$proyect</td>";
		echo "<td>$inicio</td>";
		echo "<td>$culminacion</td>";
		echo "<td>$avance %</td>";
		echo"</tr>";
	}
	echo "</table>";		
}
?>
<?= $this->Html->link('Descargar PDF <span class="glyphicon glyphicon-save"></span>', 
	array('action'=>'reporte_actividades_pdf', $this->request->data['Proyecto']['semestre']), array('class'=>'btn btn-default', 'escape'=>false)) ?>
<br/>
<? if($mostrar): ?>
<div class="col-md-6">
<h2>Personal sin actividades asignadas</h2>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Nombre y Apellido</th>
		</tr>
	</thead>
	<?php
		foreach ($personas2 as $p) {
			echo "<tr>";
			echo "<td>".$p['Usuario']['fullname']."</td>";
			echo "</tr>";
		}
	?>
</table>
</div>
<? endif ?>

<?php
 endif;
?>
<script>
$(document).ready(function() {
	$("#liProyectos").addClass('active');
	$("#ulProyectos").addClass('in');
	$("#lnk_reportes").addClass('current');
});
</script>