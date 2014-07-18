<div class="auditorias view">
<h2><?php  echo __('Auditoria'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($auditoria['Auditoria']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Aco'); ?></dt>
		<dd>
			<?php echo $this->Html->link($auditoria['Aco']['id'], array('controller' => 'acos', 'action' => 'view', $auditoria['Aco']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuario'); ?></dt>
		<dd>
			<?php echo $this->Html->link($auditoria['Usuario']['id'], array('controller' => 'usuarios', 'action' => 'view', $auditoria['Usuario']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Observacion'); ?></dt>
		<dd>
			<?php echo h($auditoria['Auditoria']['observacion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Auditoria'), array('action' => 'edit', $auditoria['Auditoria']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Auditoria'), array('action' => 'delete', $auditoria['Auditoria']['id']), null, __('Are you sure you want to delete # %s?', $auditoria['Auditoria']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Auditorias'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Auditoria'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acos'), array('controller' => 'acos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Aco'), array('controller' => 'acos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
