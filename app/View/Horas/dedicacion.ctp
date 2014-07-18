<?php
$this->Html->addCrumb('Horas', array('controller'=>'Horas', 'action'=>'index'));
$this->Html->addCrumb('Registro', '');
?>
<div class="horas index">
	<h2>Registro de Horas de dedicación <span class="label label-default">Semana laboral número <?= $semana ?> (desde el <?= $rango['desde'] ?> hasta el <?= $rango['hasta'] ?>)</span></h2>
	
	<br /><br />
	<table cellpadding="0" cellspacing="0">
	<tr>
	<thead>
		<th><?php echo $this->Paginator->sort('tipo_actividad_id'); ?></th>
		<th><?php echo $this->Paginator->sort('semana'); ?></th>
		<th><?php echo $this->Paginator->sort('mes'); ?></th>
		<th><?php echo $this->Paginator->sort('cantidad'); ?></th>
		<th width="150px" class="actions"><?php echo __('Acciones'); ?></th>
	</thead>		
	</tr>
	<?php
	foreach ($horas as $hora): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($hora['TipoActividad']['name'], array('controller' => 'tipo_actividades', 'action' => 'view', $hora['TipoActividad']['id'])); ?>
		</td>
		<td><?= $hora['Hora']['cantidad'] ?> Horas</td>
		<td><?php echo h($hora['Hora']['semana']); ?>&nbsp;</td>
		<td><?php echo h(mes2letras($hora['Hora']['mes'])); ?>&nbsp;</td>
		<td class="actions">
			<?= $this->Html->link($this->Html->image("action_view.png", array("width"=>"24", 'alt'=>'Ver')), 
					array('action'=>'view', $hora['Hora']['id']), array("confirm"=>null, "indicator"=>null, 'class'=>'lnk_view', "escape"=>false)); ?>
			<?= $this->Html->link($this->Html->image("action_edit.png", array("width"=>"24", 'alt'=>'Editar')), 
					array('action'=>'edit', $hora['Hora']['id']), array("confirm"=>null, "indicator"=>null, 'class'=>'lnk_view', "escape"=>false)); ?>
			<?= $this->Html->link($this->Html->image("action_delete.png", array("width"=>"24", 'alt'=>'PDF')), 
					array('action'=>'delete', $hora['Hora']['id']), array("confirm"=>"Estas seguro de eliminar este registro: ", "indicator"=>null, "escape"=>false));?>
		</td>
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
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

<script>
$(document).ready(function() {
	$("#liHoras").addClass('active');
	$("#ulHoras").addClass('in');
	$("#lnk_registro_horas").addClass('current');
	$('.actions a').tooltip();
	//$("#AvanceUpdateAvanceForm").validate();
});
</script>