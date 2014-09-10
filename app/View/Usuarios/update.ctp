<?php
$this->Html->addCrumb('Usuario', array('controller'=>'Panel', 'action'=>'index'));
$this->Html->addCrumb('Actualizar datos', '');
$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
echo $this->Form->create('Vacacion', array('class'=>'form', 'inputDefaults'=>$defaults));
?>
<h2>Actualizar datos del usuario</h2>
<div class="row">
	<div class="form-group form-horizontal">
		<label for="UsuarioNombre" class="col-sm-2 control-label">Nombre(s): </label>
		<div class="col-sm-4">
			<?= $this->Form->input('nombre', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
		<label for="UsuarioNombre" class="col-sm-2 control-label">Apellidos(s): </label>
		<div class="col-sm-4">
			<?= $this->Form->input('apellido', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
	</div>
</div>

<div>&nbsp;</div>

<div class="row">
	<div class="form-group form-horizontal">
		<label for="UsuarioNombre" class="col-sm-2 control-label">Correo Institucional: </label>
		<div class="col-sm-4">
			<?= $this->Form->input('email', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
		<label for="UsuarioNombre" class="col-sm-2 control-label">Correo Personal: </label>
		<div class="col-sm-4">
			<?= $this->Form->input('email_secundario', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
	</div>
</div>

<div>&nbsp;</div>

<div class="row">
	<div class="form-group form-horizontal">
		<label for="UsuarioNombre" class="col-sm-2 control-label">Teléfono: </label>
		<div class="col-sm-4">
			<?= $this->Form->input('telefono', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
		<label for="UsuarioNombre" class="col-sm-2 control-label">Celular: </label>
		<div class="col-sm-4">
			<?= $this->Form->input('celular', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
	</div>
</div>

<div>&nbsp;</div>

<div class="row">
	<div class="form-group">
		<label for="UsuarioApellido" class="control-label">: </label>
			<?= $this->Form->input('', array('required'=>true, 'class'=>'form-control')); ?>
	</div>
</div>