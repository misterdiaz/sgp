<div class="roles view">
<h2><?php  __('Rol');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rol['Rol']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombre'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rol['Rol']['nombre']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Descripcion'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $rol['Rol']['descripcion']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s', true), __('Rol', true)), array('action' => 'edit', $rol['Rol']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s', true), __('Rol', true)), array('action' => 'delete', $rol['Rol']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $rol['Rol']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Roles', true)), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Rol', true)), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Usuarios', true)), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Usuario', true)), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php printf(__('Related %s', true), __('Usuarios', true));?></h3>
	<?php if (!empty($rol['Usuario'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Usuario'); ?></th>
		<th><?php __('Clave'); ?></th>
		<th><?php __('Nombre'); ?></th>
		<th><?php __('Apellido'); ?></th>
		<th><?php __('Cedula'); ?></th>
		<th><?php __('Telefono'); ?></th>
		<th><?php __('Email'); ?></th>
		<th><?php __('Email Secundario'); ?></th>
		<th><?php __('Cargo Id'); ?></th>
		<th><?php __('Profesion'); ?></th>
		<th><?php __('Rol Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($rol['Usuario'] as $usuario):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $usuario['id'];?></td>
			<td><?php echo $usuario['usuario'];?></td>
			<td><?php echo $usuario['clave'];?></td>
			<td><?php echo $usuario['nombre'];?></td>
			<td><?php echo $usuario['apellido'];?></td>
			<td><?php echo $usuario['cedula'];?></td>
			<td><?php echo $usuario['telefono'];?></td>
			<td><?php echo $usuario['email'];?></td>
			<td><?php echo $usuario['email_secundario'];?></td>
			<td><?php echo $usuario['cargo_id'];?></td>
			<td><?php echo $usuario['profesion'];?></td>
			<td><?php echo $usuario['rol_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'usuarios', 'action' => 'view', $usuario['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'usuarios', 'action' => 'edit', $usuario['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'usuarios', 'action' => 'delete', $usuario['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $usuario['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Usuario', true)), array('controller' => 'usuarios', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
