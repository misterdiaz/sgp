<div class="proyectos index">
	<h2><?php __('Proyectos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('descripcion');?></th>
			<th><?php echo $this->Paginator->sort('responsable');?></th>
			<th><?php echo $this->Paginator->sort('area_estudio');?></th>
			<th><?php echo $this->Paginator->sort('cliente');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($proyectos as $proyecto):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $proyecto['Proyecto']['id']; ?>&nbsp;</td>
		<td><?php echo $proyecto['Proyecto']['name']; ?>&nbsp;</td>
		<td><?php echo $proyecto['Proyecto']['descripcion']; ?>&nbsp;</td>
		<td><?php echo $proyecto['Proyecto']['responsable']; ?>&nbsp;</td>
		<td><?php echo $proyecto['Proyecto']['area_estudio']; ?>&nbsp;</td>
		<td><?php echo $proyecto['Proyecto']['cliente']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $proyecto['Proyecto']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $proyecto['Proyecto']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $proyecto['Proyecto']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $proyecto['Proyecto']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Proyecto', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Proyecto Puntos', true)), array('controller' => 'proyecto_puntos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Proyecto Punto', true)), array('controller' => 'proyecto_puntos', 'action' => 'add')); ?> </li>
	</ul>
</div>