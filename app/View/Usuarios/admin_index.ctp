<script>
	$('#mcu').addClass('current');
	$(document).ready(function() {
		$('.view').fancybox();
		$('.edit').fancybox({modal2: true});
	});
</script>
<div class="usuarios">
<h2>Listado de 	Usuarios</h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registro(s) de %count% en total, comenzando con el registro %start% y terminando con el %end%.', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<thead>
<tr>
	<th width="50px"><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('nombre');?></th>
	<th><?php echo $this->Paginator->sort('apellido');?></th>
	<th><?php echo $this->Paginator->sort('login');?></th>
	<th><?php echo $this->Paginator->sort('email');?></th>
	<th><?php echo $this->Paginator->sort('status');?></th>
	<th><?php echo $this->Paginator->sort('Grupo', 'rol_id');?></th>
	<th width="120px"><?php __('Acciones');?></th>
</tr>
</thead>
<?php
$i = 0;
//pr($usuarios);
$status_usuarios = array(1=>'Activo', 2=>'Suspendido', 3=>'Eliminado');
foreach ($usuarios as $usuario):
	$class = null;
	if ($i++ % 2 != 0) {
		$class = ' class="altrow"';
		$class2 = ' class="altrow"';
	}else{
		$class = ' class=""';
		$class2 = ' class=""';
	}
?>
	<tr>
		<td<?php echo $class;?>>
			<?php echo $usuario['Usuario']['id']; ?>
		</td>
		<td<?php echo $class;?>>
			<?php echo $usuario['Usuario']['nombre']; ?>
		</td>
		<td<?php echo $class;?>>
			<?php echo $usuario['Usuario']['apellido']; ?>
		</td>
		<td<?php echo $class;?>>
			<?php echo $usuario['Usuario']['login']; ?>
		</td>
		<td<?php echo $class;?>>
			<?php echo $usuario['Usuario']['email']; ?>
		</td>
		<td<?php echo $class;?>>
			<?php echo $status_usuarios[$usuario['Usuario']['status']]; ?>
		</td>
		<td<?php echo $class;?>>
			<?php echo $usuario['Rol']['nombre']; ?>
		</td>
		<td<?php echo $class2;?>>
			<?php echo $this->Html->link($this->Html->image('action_view.png', array('width'=>'28')), array('action'=>'view', $usuario['Usuario']['id']), array('escape'=>FALSE, 'class'=>'view', 'title'=>'Datos del Usuario')); ?>
			<?php echo $this->Html->link($this->Html->image('action_edit.png', array('width'=>'28')), array('action'=>'edit', $usuario['Usuario']['id']), array('escape'=>FALSE, 'class'=>'edit', 'title'=>'Editar Usuario')); ?>
			<?php echo $this->Html->link($this->Html->image('action_delete.png', array('width'=>'28')), array('action'=>'delete', $usuario['Usuario']['id']), array('escape'=>FALSE), sprintf(__('¿Esta realmente seguro que desea eliminar este usuario?', true), $usuario['Usuario']['id'])); ?>
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
			<?= $this->Html->link($this->Html->image("group-list.png", array("width"=>"48", 'alt'=>'Listado Rol', 'title'=>'Listado Roles')), 
			array( "controller"=>"Roles", "action"=>"index", 'admin'=>true),
			array("confirm"=>null, "indicator"=>null, "escape"=>false, 'alt'=>'Reportes')); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("user-add.png", array("width"=>"48", 'alt'=>'Agregar Usuario', 'title'=>'Agregar Usuario')), 
			array( "controller"=>"Usuarios", "action"=>"add", 'admin'=>true),
			array("confirm"=>null, "indicator"=>null, "escape"=>false, 'alt'=>'Reportes')); ?>
		</li>
		
	</ul>
</div>
