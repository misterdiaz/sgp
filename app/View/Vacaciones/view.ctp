<div class="vacaciones view">
<h2><?php  echo __('Vacacion'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($vacacion['Vacacion']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuario'); ?></dt>
		<dd>
			<?php echo $this->Html->link($vacacion['Usuario']['id'], array('controller' => 'usuarios', 'action' => 'view', $vacacion['Usuario']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Desde'); ?></dt>
		<dd>
			<?php echo h($vacacion['Vacacion']['fecha_desde']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Hasta'); ?></dt>
		<dd>
			<?php echo h($vacacion['Vacacion']['fecha_hasta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nro Dias'); ?></dt>
		<dd>
			<?php echo h($vacacion['Vacacion']['nro_dias']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Periodo'); ?></dt>
		<dd>
			<?php echo $this->Html->link($vacacion['Periodo']['id'], array('controller' => 'periodos', 'action' => 'view', $vacacion['Periodo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($vacacion['Vacacion']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($vacacion['Vacacion']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($vacacion['Vacacion']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Vacacion'), array('action' => 'edit', $vacacion['Vacacion']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Vacacion'), array('action' => 'delete', $vacacion['Vacacion']['id']), null, __('Are you sure you want to delete # %s?', $vacacion['Vacacion']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Vacaciones'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vacacion'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Periodos'), array('controller' => 'periodos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Periodo'), array('controller' => 'periodos', 'action' => 'add')); ?> </li>
	</ul>
</div>
