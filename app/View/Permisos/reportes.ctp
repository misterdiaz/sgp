<?php
$this->Html->addCrumb('Permisos', array('controller'=>'Permisos', 'action'=>'index'));
$this->Html->addCrumb('Reportes');
?>
<div class="page-header">
	<h2>Reportes de Permisos</h2>
</div>
<div class="list-group col-md-6">
	<?php
		echo $this->Html->link('General', array('controller'=>'Permisos', 'action'=>'reporteGeneral'), array('class'=>'list-group-item'));

		echo $this->Html->link('Individual', array('controller'=>'Permisos', 'action'=>'reporteIndividual'), array('class'=>'list-group-item'));
	?>
</div>
<script>
$(document).ready(function() {
	$("#liPermisos").addClass('active');
	$("#ulPermisos").addClass('in');
	$("#lnk_reporte_permisos").addClass('current');  
});
</script>