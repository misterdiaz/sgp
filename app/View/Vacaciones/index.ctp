<?php
$this->Html->addCrumb('Vacaciones', array('controller'=>'Vacaciones', 'action'=>'index'));
$this->Html->addCrumb('Histórico');
?>
<div class="vacaciones index">
	<h2>Histórico Solicitud de Vacaciones</h2>
	<table class="table table-responsive table-bordered">
	<thead>
	<tr class="info">
		<th class="text-center">Nro.</th>
		<th class="text-center"><?php echo $this->Paginator->sort('nro_dias'); ?></th>
		<th class="text-center"><?php echo $this->Paginator->sort('fecha_desde'); ?></th>
		<th class="text-center"><?php echo $this->Paginator->sort('fecha_hasta'); ?></th>
		<th class="text-center"><?php echo $this->Paginator->sort('status'); ?></th>
	</tr>
	</thead>
	<?php
	$estatus = array(1=>'Solicitado', 2=>'Aprobado', 3=>'Denegado', 4=>'Cancelado');
	//pr($vacaciones);
	$i=0;
	foreach ($vacaciones as $vacacion): ?>
	<tr>
		<td class="text-center"><?= ++$i; ?></td>
		<td class="text-center"><?= $vacacion['Vacacion']['nro_dias']; ?>&nbsp;</td>
		<td class="text-center"><?= $vacacion['Vacacion']['fecha_desde']; ?>&nbsp;</td>
		<td class="text-center"><?= $vacacion['Vacacion']['fecha_hasta']; ?>&nbsp;</td>
		<td class="text-center"><?= $estatus[$vacacion['Vacacion']['status']]; ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Ant'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('Sig') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

<script>
$(document).ready(function() {
	$("#liVacaciones").addClass('active');
	$("#ulVacaciones").addClass('in');
	$("#lnk_historico_vacaciones").addClass('current');  
});
</script>