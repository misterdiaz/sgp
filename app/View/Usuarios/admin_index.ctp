<script>
	$('#mcu').addClass('current');
	$(document).ready(function() {
		$('.view').fancybox();
		$('.edit').fancybox({modal2: true});
	});
</script>
<div class="usuarios">
<h2>Listado de 	Usuarios</h2>

<table class="table table-responsive table-bordered">
<thead>
<tr class='info'>
	<th class='col-sm-1 text-center'><?php echo $this->Paginator->sort('id');?></th>
	<th class='col-sm-1 text-center'><?php echo $this->Paginator->sort('login');?></th>
	<th class='col-sm-1 text-center'><?php echo $this->Paginator->sort('nombre');?></th>
	<th class='col-sm-1 text-center'><?php echo $this->Paginator->sort('apellido');?></th>
	<th class='col-sm-1 text-center'><?php echo $this->Paginator->sort('email');?></th>
	<th class='col-sm-1 text-center'><?php echo $this->Paginator->sort('status');?></th>
	<th class='col-sm-1 text-center'><?php echo $this->Paginator->sort('Grupo', 'rol_id');?></th>
	<th class='col-sm-2 text-center'>Acciones</th>
</tr>
</thead>
<?php
$i = 0;
//pr($usuarios);
$status_usuarios = array(1=>'Activo', 2=>'Suspendido', 3=>'Eliminado');
foreach ($usuarios as $usuario):
?>
	<tr>
		<td class='text-center'> <?= $usuario['Usuario']['id']; ?></td>
		<td> <?= $usuario['Usuario']['login']; ?> </td>
		<td><?= $usuario['Usuario']['nombre']; ?></td>
		<td> <?= $usuario['Usuario']['apellido']; ?> </td>
		<td><?= $usuario['Usuario']['email']; ?></td>
		<td><?= $status_usuarios[$usuario['Usuario']['status']]; ?>	</td>
		<td><?= $usuario['Rol']['nombre']; ?> </td>
		<td class='actions text-center'>
			<?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>', 
			array('action'=>'view', $usuario['Usuario']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false, 
				"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Ver información del usuario"
			)); ?>

			<?= $this->Html->link('<span class="glyphicon glyphicon-edit"></span>',
			array('action'=>'edit', $usuario['Usuario']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false,
				"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Editar usuario"
			)); ?>

			<?= $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',
			array('action'=>'delete', $usuario['Usuario']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false,
				"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Eliminar usuario"
			)); ?>

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
<div>&nbsp;</div>
