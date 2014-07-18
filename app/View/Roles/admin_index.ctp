<div class="roles index">
	<h2>Roles</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('nombre');?></th>
			<th><?php echo $this->Paginator->sort('descripcion', 'Descripción');?></th>
			<th class="actions">Acciones</th>
	</tr>
	<?php
	$i = 0;
	foreach ($roles as $rol):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $rol['Rol']['nombre']; ?>&nbsp;</td>
		<td><?php echo $rol['Rol']['descripcion']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('action_edit.png', array('width'=>'28')), array('action'=>'edit', $rol['Rol']['id'], 'admin'=>true), array('escape'=>FALSE, 'class'=>'edit', 'title'=>'Editar Grupo')); ?>
			<?php echo $this->Html->link($this->Html->image('action_delete.png', array('width'=>'28')), array('action'=>'delete', $rol['Rol']['id'], 'admin'=>true), array('escape'=>FALSE), sprintf(__('¿Esta realmente seguro que desea eliminar este Rol?', true), $rol['Rol']['id'])); ?>
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
	<ul>
		<li><?= $this->Html->link($this->Html->image("home.png", array("width"=>"48", 'alt'=>'Inicio', 'title'=>'Inicio')), 
			"/", 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("iEngrenages.png", array("width"=>"48", 'alt'=>'Configuración', 'title'=>'Configuración')), 
			array( "controller"=>"Panel", "action"=>"index", 'admin'=>true), 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("group.png", array("width"=>"48", 'alt'=>'Listado Usuarios', 'title'=>'Listado Usuarios')), 
			array( "controller"=>"Usuarios", "action"=>"index", 'admin'=>true),
			array("confirm"=>null, "indicator"=>null, "escape"=>false, 'alt'=>'Reportes')); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("group-add.png", array("width"=>"48", 'alt'=>'Agregar Rol', 'title'=>'Agregar Rol')), 
			array( "controller"=>"Roles", "action"=>"add", 'admin'=>true),
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
	</ul>
</div>