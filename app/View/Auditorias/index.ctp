<div class="auditorias index">
	<h2><?php echo __('Auditorias'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('aco_id'); ?></th>
			<th><?php echo $this->Paginator->sort('usuario_id'); ?></th>
			<th><?php echo $this->Paginator->sort('observacion'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($auditorias as $auditoria): ?>
	<tr>
		<td><?php echo h($auditoria['Auditoria']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($auditoria['Aco']['id'], array('controller' => 'acos', 'action' => 'view', $auditoria['Aco']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($auditoria['Usuario']['id'], array('controller' => 'usuarios', 'action' => 'view', $auditoria['Usuario']['id'])); ?>
		</td>
		<td><?php echo h($auditoria['Auditoria']['observacion']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $auditoria['Auditoria']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $auditoria['Auditoria']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $auditoria['Auditoria']['id']), null, __('Are you sure you want to delete # %s?', $auditoria['Auditoria']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Auditoria'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Acos'), array('controller' => 'acos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Aco'), array('controller' => 'acos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
