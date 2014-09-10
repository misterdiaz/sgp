<?php
$this->Html->addCrumb('Control de Acceso', array('controller'=>'Acl', 'action'=>'permisos', 'admin'=>true));
$this->Html->addCrumb('Designar permisos por usuario');
$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
echo $this->Form->create('Acl', array('class'=>'form', 'inputDefaults'=>$defaults, 'action'=>'aro_miembro_add_permiso/'.$aro_id));
$tipo_opc = array(1=>"Permitir", -1=>"Denegar");
$permisos = array('create'=>'Crear', 'read'=>'Leer', 'update'=>'Actualizar', 'delete'=>'Eliminar');
?>
<h2>Asignar permisos especiales a un usuario especifico</h2>

<div class="form-group form-horizontal row">
	<div class="col-sm-2">
		<?= $this->Form->input('usuario_id', array('options'=>$usuarios, 'class'=>'form-control', 'empty'=>'Usuarios', 'required'=>true)) ?>
	</div>
	<div class="col-sm-2">
		<?= $this->Form->input('aco_id', array('options'=>$objetos, 'class'=>'form-control', 'empty'=>'Acciones', 'required'=>true)) ?>
	</div>
	<div class="col-sm-2">
		<?= $this->Form->input('tipo', array('options'=>$tipo_opc, 'class'=>'form-control', 'empty'=>'Tipo de permiso', 'required'=>true)) ?>
	</div>
	<div class="col-sm-2">
		<?= $this->Form->input('permisos', array('options'=>$permisos, 'class'=>'form-control', 'multiple'=>true, 'required'=>true)) ?>
	</div>
	<div class="btn-group">
		<?php echo $this->Form->end(array('label'=>'Asignar permisos', 'div'=>false, "class"=>"btn btn-primary")); ?>
		<a href="<?= $this->Html->url(array('controller'=>'Acl', 'action'=>'permisos', 'admin'=>true)) ?>" class="btn btn-warning">Regresar</a>
		<a href="<?= $this->Html->url(array('controller'=>'Panel', 'action'=>'index', 'admin'=>true)) ?>" class="btn btn-danger">Cancelar</a>
	</div>
</div>
