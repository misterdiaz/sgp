<?php
$this->Html->addCrumb('Vacaciones', array('controller'=>'Vacaciones', 'action'=>'index'));
$this->Html->addCrumb('Reportes', array('controller'=>'Vacaciones', 'action'=>'reportes'));
$this->Html->addCrumb('Reporte Dias Disponibles');

$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
echo $this->Form->create('Vacacion', array('class'=>'form', 'inputDefaults'=>$defaults));

?>
<h2>Dias Disponibles</h2>
<table class="table table-responsive table-bordered table-hover">
	<thead>
		<tr class="info">
			<th class="text-center">Nro</th>
			<th class="text-center">Trabajador</th>
			<th class="text-center">Dias disponibles</th>
			<th class="text-center">---</th>
		</tr>
	</thead>
	<tbody>
<?php
	$i=0;
	foreach ($dias_disponibles as $dias):
?>
	<tr>
		<td class="text-center"><?= ++$i; ?></td>
		<td><?= $dias['Usuario']['fullname'] ?></td>
		<td class="text-center"><?= $dias['DiasDisponibles']['nro_dias'] ?></td>
		<td></td>
	</tr>
<?php
	endforeach;
?>
	</tbody>
</table>

<script>
$(document).ready(function() {
	$("#liVacaciones").addClass('active');
	$("#ulVacaciones").addClass('in');
	$("#lnk_reporte_vacaciones").addClass('current');
  
});
</script>