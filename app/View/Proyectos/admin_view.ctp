<div class="proyectos view">
<h2><?php  __('Proyecto');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $proyecto['Proyecto']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $proyecto['Proyecto']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Descripcion'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $proyecto['Proyecto']['descripcion']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Responsable'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $proyecto['Proyecto']['responsable']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Area Estudio'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $proyecto['Proyecto']['area_estudio']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cliente'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $proyecto['Proyecto']['cliente']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Proyecto', true)), array('action' => 'edit', $proyecto['Proyecto']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('Proyecto', true)), array('action' => 'delete', $proyecto['Proyecto']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $proyecto['Proyecto']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Proyectos', true)), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Proyecto', true)), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Proyecto Puntos', true)), array('controller' => 'proyecto_puntos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Proyecto Punto', true)), array('controller' => 'proyecto_puntos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Proyecto Puntos', true));?></h3>
	<?php if (!empty($proyecto['ProyectoPunto'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Proyecto Id'); ?></th>
		<th><?php __('Punto Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($proyecto['ProyectoPunto'] as $proyectoPunto):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $proyectoPunto['proyecto_id'];?></td>
			<td><?php echo $proyectoPunto['punto_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'proyecto_puntos', 'action' => 'view', $proyectoPunto['punto_id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'proyecto_puntos', 'action' => 'edit', $proyectoPunto['punto_id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'proyecto_puntos', 'action' => 'delete', $proyectoPunto['punto_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $proyectoPunto['punto_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Proyecto Punto', true)), array('controller' => 'proyecto_puntos', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
