<div class="proyectos form">
<?php echo $this->Form->create('Proyecto');?>
	<fieldset>
 		<legend><?php printf(__('Admin Add %s', true), __('Proyecto', true)); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('descripcion');
		echo $this->Form->input('responsable');
		echo $this->Form->input('area_estudio');
		echo $this->Form->input('cliente');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Proyectos', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Proyecto Puntos', true)), array('controller' => 'proyecto_puntos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Proyecto Punto', true)), array('controller' => 'proyecto_puntos', 'action' => 'add')); ?> </li>
	</ul>
</div>