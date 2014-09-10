<div class="permisos form">
<?php echo $this->Form->create('Permiso'); ?>
	<fieldset>
		<legend><?php echo __('Edit Permiso'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nro');
		echo $this->Form->input('usuario_id');
		echo $this->Form->input('fecha_solicitud');
		echo $this->Form->input('centro_id');
		echo $this->Form->input('fecha_desde');
		echo $this->Form->input('fecha_hasta');
		echo $this->Form->input('tipo_permiso');
		echo $this->Form->input('nro_dias');
		echo $this->Form->input('causa');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Permiso.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Permiso.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Permisos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Centros'), array('controller' => 'centros', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Centro'), array('controller' => 'centros', 'action' => 'add')); ?> </li>
	</ul>
</div>
