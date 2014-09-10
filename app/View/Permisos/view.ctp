<div class="permisos view">
<h2><?php  echo __('Permiso'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($permiso['Permiso']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nro'); ?></dt>
		<dd>
			<?php echo h($permiso['Permiso']['nro']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuario'); ?></dt>
		<dd>
			<?php echo $this->Html->link($permiso['Usuario']['id'], array('controller' => 'usuarios', 'action' => 'view', $permiso['Usuario']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Solicitud'); ?></dt>
		<dd>
			<?php echo h($permiso['Permiso']['fecha_solicitud']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Centro'); ?></dt>
		<dd>
			<?php echo $this->Html->link($permiso['Centro']['name'], array('controller' => 'centros', 'action' => 'view', $permiso['Centro']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Desde'); ?></dt>
		<dd>
			<?php echo h($permiso['Permiso']['fecha_desde']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Hasta'); ?></dt>
		<dd>
			<?php echo h($permiso['Permiso']['fecha_hasta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tipo Permiso'); ?></dt>
		<dd>
			<?php echo h($permiso['Permiso']['tipo_permiso']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nro Dias'); ?></dt>
		<dd>
			<?php echo h($permiso['Permiso']['nro_dias']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Causa'); ?></dt>
		<dd>
			<?php echo h($permiso['Permiso']['causa']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($permiso['Permiso']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($permiso['Permiso']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Permiso'), array('action' => 'edit', $permiso['Permiso']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Permiso'), array('action' => 'delete', $permiso['Permiso']['id']), null, __('Are you sure you want to delete # %s?', $permiso['Permiso']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Permisos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Permiso'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Centros'), array('controller' => 'centros', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Centro'), array('controller' => 'centros', 'action' => 'add')); ?> </li>
	</ul>
</div>
