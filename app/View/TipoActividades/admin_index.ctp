<div class="tipoActividades index">
	<h2><?php echo __('Tipo de Actividades'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('descripcion'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<?php
	foreach ($tipoActividades as $tipoActividad): ?>
	<tr>
		<td><?php echo h($tipoActividad['TipoActividad']['id']); ?>&nbsp;</td>
		<td><?php echo h($tipoActividad['TipoActividad']['name']); ?>&nbsp;</td>
		<td><?php echo h($tipoActividad['TipoActividad']['descripcion']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $tipoActividad['TipoActividad']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tipoActividad['TipoActividad']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tipoActividad['TipoActividad']['id']), null, __('Are you sure you want to delete # %s?', $tipoActividad['TipoActividad']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<ul>
		<li><?= $this->Html->link($this->Html->image("home.png", array("width"=>"48", 'alt'=>'Proyectos')), 
			"/", 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("iEngrenages.png", array("width"=>"48", 'alt'=>'Configuración', 'title'=>'Configuración')), 
			array( "controller"=>"Panel", "action"=>"index", 'admin'=>true), 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("tipo_actividad_add.png", array("width"=>"48")), 
			array( "controller"=>"TipoActividades", "action"=>"add", 'admin'=>true), 
			array("confirm"=>null, "indicator"=>null, "escape"=>false, 'title'=>'Agregar tipo de actividad')); ?>
		</li>
	</ul>
</div>