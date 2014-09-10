<div class="vacaciones index">
	<h2><?php echo __('Vacaciones'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('usuario_id'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_desde'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_hasta'); ?></th>
			<th><?php echo $this->Paginator->sort('nro_dias'); ?></th>
			<th><?php echo $this->Paginator->sort('periodo_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($vacaciones as $vacacion): ?>
	<tr>
		<td><?php echo h($vacacion['Vacacion']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($vacacion['Usuario']['id'], array('controller' => 'usuarios', 'action' => 'view', $vacacion['Usuario']['id'])); ?>
		</td>
		<td><?php echo h($vacacion['Vacacion']['fecha_desde']); ?>&nbsp;</td>
		<td><?php echo h($vacacion['Vacacion']['fecha_hasta']); ?>&nbsp;</td>
		<td><?php echo h($vacacion['Vacacion']['nro_dias']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($vacacion['Periodo']['id'], array('controller' => 'periodos', 'action' => 'view', $vacacion['Periodo']['id'])); ?>
		</td>
		<td><?php echo h($vacacion['Vacacion']['status']); ?>&nbsp;</td>
		<td><?php echo h($vacacion['Vacacion']['created']); ?>&nbsp;</td>
		<td><?php echo h($vacacion['Vacacion']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $vacacion['Vacacion']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $vacacion['Vacacion']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $vacacion['Vacacion']['id']), null, __('Are you sure you want to delete # %s?', $vacacion['Vacacion']['id'])); ?>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Vacacion'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Periodos'), array('controller' => 'periodos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Periodo'), array('controller' => 'periodos', 'action' => 'add')); ?> </li>
	</ul>
</div>
