<script>
	$('#acl').addClass('current');
	$(document).ready(function() {
		$('.view').fancybox();
		$('.edit').fancybox({modal2: true});
	});
</script>
<div class="aros">
<h2>Grupos - Roles</h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registro(s) de %count% en total, comenzando con el registro %start% y terminando con el %end%.', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<thead>
<tr>
	<th><?php echo $this->Paginator->sort('alias', 'Rol');?></th>
	<th width="12%">Acciones</th>
</tr>
</thead>
<?php
$i = 0;
/*
echo "LUEGO DE AQUI IMPRIMO LOS AROS";
pr($aros);
*/

foreach ($aros as $aro):
		$class = null;
	if ($i++ % 2 != 0) {
		$class = ' class="altrow"';
		$class2 = ' class="altrow actions"';
	}else{
		$class = ' class=""';
		$class2 = ' class="actions"';
	}
?>
	<tr>
		<td<?php echo $class;?>>
			<?php echo $aro['Aro']['alias']; ?>
		</td>
		<td<?php echo $class2;?>>
			<?php //echo $this->Html->link($this->Html->image('action_view.png', array('width'=>'28')), array('controller'=>'Aros', 'action'=>'view', $aro['Aro']['id'], 'admin'=>true), array('escape'=>FALSE, 'class'=>'view', 'title'=>'Datos del Grupo')); ?>
			<?php echo $this->Html->link($this->Html->image('action_edit.png', array('width'=>'28')), array('controller'=>'Aros', 'action'=>'edit', $aro['Aro']['id'], 'admin'=>true), array('escape'=>FALSE, 'class'=>'edit', 'title'=>'Editar Grupo')); ?>
			<?php echo $this->Html->link($this->Html->image('action_delete.png', array('width'=>'28')), array('controller'=>'Aros', 'action'=>'delete', $aro['Aro']['id'], 'admin'=>true), array('escape'=>FALSE), sprintf(__('¿Esta realmente seguro que desea eliminar este grupo?', true), $aro['Aro']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
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
			<?= $this->Html->link($this->Html->image("group-add.png", array("width"=>"48", 'alt'=>'Agregar Rol', 'title'=>'Modificar Rol')), 
			array( "controller"=>"Acl", "action"=>"aro_add", 'admin'=>true),
			array("confirm"=>null, "indicator"=>null, "escape"=>false, 'alt'=>'Reportes')); ?>
		</li>
	</ul>
</div>
