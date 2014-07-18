<div class="tipoActividades view">
<h2><?php  echo __('Tipo Actividad'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tipoActividad['TipoActividad']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($tipoActividad['TipoActividad']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($tipoActividad['TipoActividad']['descripcion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tipo Actividad'), array('action' => 'edit', $tipoActividad['TipoActividad']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tipo Actividad'), array('action' => 'delete', $tipoActividad['TipoActividad']['id']), null, __('Are you sure you want to delete # %s?', $tipoActividad['TipoActividad']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tipo Actividades'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipo Actividad'), array('action' => 'add')); ?> </li>
	</ul>
</div>
