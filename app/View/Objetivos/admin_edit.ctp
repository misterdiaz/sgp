<div class="objetivos form">
<?php echo $this->Form->create('Objetivo'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Objetivo'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('proyecto_id');
		echo $this->Form->input('descripcion');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Objetivo.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Objetivo.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Objetivos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Proyectos'), array('controller' => 'proyectos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Proyecto'), array('controller' => 'proyectos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actividades'), array('controller' => 'actividades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Actividad'), array('controller' => 'actividades', 'action' => 'add')); ?> </li>
	</ul>
</div>
