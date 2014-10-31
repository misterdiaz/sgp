<?php
$this->Html->addCrumb('Usuario', array('controller'=>'Panel', 'action'=>'index'));
$this->Html->addCrumb('Actualizar datos', '');
$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
echo $this->Form->create('Usuario', array('class'=>'form', 'inputDefaults'=>$defaults));
echo $this->Form->input('id', array('type'=>'hidden'));
//pr($this->data);
?>
<h2>Actualizar datos del usuario</h2>
<div>&nbsp;</div>
<div class="row">
	<div class="form-group form-horizontal">
		<label for="UsuarioNombre" class="col-sm-2 control-label">Nombre(s): </label>
		<div class="col-sm-4">
			<?= $this->Form->input('nombre', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
		<label for="UsuarioApellido" class="col-sm-2 control-label">Apellidos(s): </label>
		<div class="col-sm-4">
			<?= $this->Form->input('apellido', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
	</div>
</div>

<div>&nbsp;</div>

<div class="row">
	<div class="form-group form-horizontal">
		<label for="UsuarioEmail" class="col-sm-2 control-label">Correo Institucional: </label>
		<div class="col-sm-4">
			<?= $this->Form->input('email', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
		<label for="UsuarioEmailSecundario" class="col-sm-2 control-label">Correo Personal: </label>
		<div class="col-sm-4">
			<?= $this->Form->input('email_secundario', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
	</div>
</div>

<div>&nbsp;</div>

<div class="row">
	<div class="form-group form-horizontal">
		<label for="UsuarioTelefono" class="col-sm-2 control-label">Teléfono: </label>
		<div class="col-sm-4">
			<?= $this->Form->input('telefono', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
		<label for="UsuarioCelular" class="col-sm-2 control-label">Celular: </label>
		<div class="col-sm-4">
			<?= $this->Form->input('celular', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
	</div>
</div>

<div>&nbsp;</div>

<div class="row">
	<div class="form-group form-horizontal">
		<label for="UsuarioCedula" class="col-sm-2 control-label">Cédula: </label>
		<div class="col-sm-4">
			<?= $this->Form->input('cedula', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
		<label for="UsuarioProfesion" class="col-sm-2 control-label">Profesión: </label>
		<div class="col-sm-4">
			<?= $this->Form->input('profesion', array('required'=>true, 'class'=>'form-control')); ?>
		</div>
	</div>
</div>
<div>&nbsp;</div>
<div class="row">
	<div class="form-group form-horizontal">
		<label for="UsuarioCedula" class="col-sm-2 control-label">Cargo: </label>
		<div class="col-sm-4">
			<?= $this->Form->input('cargo_id', array('required'=>true, 'class'=>'form-control', 'empty'=>'Seleccione...')); ?>
		</div>
	</div>
</div>
<div>&nbsp;</div>
<div class="btn-group">
	<?php echo $this->Form->end(array('label'=>'Guardar', 'div'=>false, "class"=>"btn btn-default")); ?>
	<a href="<?= $this->Html->url(array('controller'=>'Panel', 'action'=>'index')) ?>" class="btn btn-default">Cancelar</a>
</div>