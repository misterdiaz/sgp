<div class="objetivos view">
<h2><?php  echo __('Objetivo'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($objetivo['Objetivo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Proyecto'); ?></dt>
		<dd>
			<?php echo $this->Html->link($objetivo['Proyecto']['name'], array('controller' => 'proyectos', 'action' => 'view', $objetivo['Proyecto']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($objetivo['Objetivo']['descripcion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Objetivo'), array('action' => 'edit', $objetivo['Objetivo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Objetivo'), array('action' => 'delete', $objetivo['Objetivo']['id']), null, __('Are you sure you want to delete # %s?', $objetivo['Objetivo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Objetivos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Objetivo'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Proyectos'), array('controller' => 'proyectos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Proyecto'), array('controller' => 'proyectos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actividades'), array('controller' => 'actividades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Actividad'), array('controller' => 'actividades', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Actividades'); ?></h3>
	<?php if (!empty($objetivo['Actividad'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Objetivo Id'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Producto'); ?></th>
		<th><?php echo __('Responsable Id'); ?></th>
		<th><?php echo __('Fecha Inicio'); ?></th>
		<th><?php echo __('Fecha Culminacion'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Observaciones'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($objetivo['Actividad'] as $actividad): ?>
		<tr>
			<td><?php echo $actividad['id']; ?></td>
			<td><?php echo $actividad['objetivo_id']; ?></td>
			<td><?php echo $actividad['nombre']; ?></td>
			<td><?php echo $actividad['producto']; ?></td>
			<td><?php echo $actividad['responsable_id']; ?></td>
			<td><?php echo $actividad['fecha_inicio']; ?></td>
			<td><?php echo $actividad['fecha_culminacion']; ?></td>
			<td><?php echo $actividad['status']; ?></td>
			<td><?php echo $actividad['observaciones']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'actividades', 'action' => 'view', $actividad['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'actividades', 'action' => 'edit', $actividad['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'actividades', 'action' => 'delete', $actividad['id']), null, __('Are you sure you want to delete # %s?', $actividad['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Actividad'), array('controller' => 'actividades', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
