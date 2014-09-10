<div class="vacaciones form">
<?php echo $this->Form->create('Vacacion'); ?>
	<fieldset>
		<legend><?php echo __('Add Vacacion'); ?></legend>
	<?php
		echo $this->Form->input('usuario_id');
		echo $this->Form->input('fecha_desde');
		echo $this->Form->input('fecha_hasta');
		echo $this->Form->input('nro_dias');
		echo $this->Form->input('periodo_id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Vacaciones'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Periodos'), array('controller' => 'periodos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Periodo'), array('controller' => 'periodos', 'action' => 'add')); ?> </li>
	</ul>
</div>
