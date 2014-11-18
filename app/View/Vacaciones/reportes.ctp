<?php
$this->Html->addCrumb('Vacaciones', array('controller'=>'Vacaciones', 'action'=>'index'));
$this->Html->addCrumb('Reportes');
?>
<div class="page-header">
	<h2>Reportes de Vacaciones</h2>
</div>
<div class="list-group col-md-6">
	<?php
		echo $this->Html->link('General', array('controller'=>'Vacaciones', 'action'=>'reporteGeneral'), array('class'=>'list-group-item'));

		echo $this->Html->link('Individual', array('controller'=>'Vacaciones', 'action'=>'reporteIndividual'), array('class'=>'list-group-item'));
	?>
</div>
<script>
$(document).ready(function() {
	$("#liVacaciones").addClass('active');
	$("#ulVacaciones").addClass('in');
	$("#lnk_reporte_vacaciones").addClass('current');  
});
</script>