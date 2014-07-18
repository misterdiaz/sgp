<?php
$this->Html->addCrumb('Proyectos', array('controller'=>'Proyectos', 'action'=>'index'));
$this->Html->addCrumb('Reportes', array('controller'=>'Proyectos', 'action'=>'view'));
?>
<div class="page-header">
	<h2>Reportes de proyectos</h2>
</div>
<div class="list-group col-md-6">
	<?php
		echo $this->Html->link('Resumen de Proyectos', array('controller'=>'Proyectos', 'action'=>'reporteResumen'), array('class'=>'list-group-item'));
		echo $this->Html->link('Actividades del Personal', array('controller'=>'Proyectos', 'action'=>'reporteActividades'), array('class'=>'list-group-item'));
		echo $this->Html->link('Avance de actividades', array('controller'=>'Proyectos', 'action'=>'reporteActividadesPersonal'), array('class'=>'list-group-item'));
		echo $this->Html->link('Actividades por proyecto', array('controller'=>'Proyectos', 'action'=>'reporteActividadesProyecto'), array('class'=>'list-group-item'));
	?>
</div>
<script>
$(document).ready(function() {
	$("#liProyectos").addClass('active');
	$("#ulProyectos").addClass('in');
	$("#lnk_reportes").addClass('current');
});
</script>
	
