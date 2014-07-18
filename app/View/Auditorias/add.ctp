<div class="auditorias form">
<?php echo $this->Form->create('Auditoria'); ?>
	<fieldset>
		<legend><?php echo __('Add Auditoria'); ?></legend>
	<?php
		echo $this->Form->input('aco_id');
		echo $this->Form->input('usuario_id');
		echo $this->Form->input('observacion');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Auditorias'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Acos'), array('controller' => 'acos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Aco'), array('controller' => 'acos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
