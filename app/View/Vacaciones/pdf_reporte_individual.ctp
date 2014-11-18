<?php
	$estatus = array(1=>'Solicitado', 2=>'Aprobado', 3=>'Denegado', 4=>'Cancelado');
?>
<div class="permisos index">
	<h2>Vacaciones <?= $titulo ?></h2>
	<table class="table table-responsive table-bordered table-hover">
	<thead>
		<tr class="info">
			<th class="text-center">Nro</th>
			<th class="text-center">Trabajador</th>
			<th class="text-center">Cantidad de dias</th>
			<th class="text-center">Fecha inicio</th>
			<th class="text-center">Fecha culminación</th>
			<th class="text-center">Status</th>
			<th class="text-center">---</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	foreach ($Vacaciones as $Vacacion): 
		$status = $Vacacion['Vacacion']['status'];
	$i++;
	?>
	<tr>
		<td class="text-center"><?= $i; ?>&nbsp;</td>
		<td><?php echo $Vacacion['Usuario']['fullname']; ?>&nbsp;</td>
		<td class="text-right"><?php echo $Vacacion['Vacacion']['nro_dias']; ?>&nbsp;</td>
		<td class="text-center"><?php echo $Vacacion['Vacacion']['fecha_desde']; ?>&nbsp;</td>
		<td class="text-center"><?php echo $Vacacion['Vacacion']['fecha_hasta']; ?>&nbsp;</td>
		<td class="text-center"><?php echo $estatus[$Vacacion['Vacacion']['status']]; ?>&nbsp;</td>
		<td class="text-center">
		    <?= $this->Form->postLink('Eliminar',
				array('controller'=>'Vacaciones', 'action'=>'cancelar', $Vacacion['Vacacion']['id']), 
				array("escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Eliminar solicitud" ), 'Estas seguro de eliminar' ); ?>
	    	</div>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
</div>
<div class="btn-group">
	<a href="<?= $this->Html->url(array('controller'=>'Vacaciones', 'action'=>'reporteGeneral')) ?>" class="btn btn-default">Regresar</a>
</div>
<script>
$(document).ready(function() {
	$("#liVacaciones").addClass('active');
	$("#ulVacaciones").addClass('in');
	$("#lnk_reporte_vacaciones").addClass('current');  
});
</script>