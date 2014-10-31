<h2>Registrar Nuevo Usuario</h2>

<?php 
$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
echo $this->Form->create('Usuario', array('class'=>'form', 'inputDefaults'=>$defaults));
?> 	
<div class="form-group">
	<label for="UsuarioNombre">Nombre(s): </label>
	<?= $this->Form->input('nombre', array('required'=>true)) ?>
</div>
<div class="form-group">
	<label for="UsuarioApellido">Apellido(s): </label>
	<?= $this->Form->input('apellido', array('required'=>true)) ?>
</div>
<div class="form-group">
	<label for="UsuarioCedula">Cédula de Identidad: </label>
	<?= $this->Form->input('cedula', array('required'=>true)) ?>
</div>
<div class="form-group">
	<label for="UsuarioTelefono">Teléfono: </label>
	<?= $this->Form->input('telefono', array('required'=>true)) ?>
</div>
<div class="form-group">
	<label for="UsuarioEmail">Email Institucional: </label>
	<?= $this->Form->input('email', array('required'=>true)) ?>
</div>
<div class="form-group">
	<label for="UsuarioEmailSecundario">Email secundario: </label>
	<?= $this->Form->input('email_secundario', array('required'=>true)) ?>
</div>

<div class="form-group">
	<label for="UsuarioLogin">Nombre de usuario: </label>
	<?= $this->Form->input('login', array('required'=>true)) ?>
</div>

<div class="form-group">
	<label for="UsuarioClave">Nombre de usuario: </label>
	<?= $this->Form->input('clave', array('required'=>true, 'type'=>'password')) ?>
</div>

<div class="form-group">
	<label for="UsuarioRolId">Rol en el sistema: </label>
	<?= $this->Form->input('rol_id', array('required'=>true, 'empty'=>'Seleccione...')) ?>
</div>

<?php $status_usuarios = array(1=>'Activo', 2=>'Suspendido', 3=>'Eliminado'); ?>
<div class="form-group">
	<label for="UsuarioStatus">Status: </label>
	<?= $this->Form->input('status', array('required'=>true, 'empty'=>'Seleccione...', 'options'=>$status_usuarios)) ?>
</div>
<div class="btn-group">
	<?php echo $this->Form->end(array('label'=>'Guardar', 'div'=>false, "class"=>"btn btn-default")); ?>
	<a href="<?= $this->Html->url(array('controller'=>'Usuarios', 'action'=>'index', 'admin'=>true)) ?>" class="btn btn-default">Cancelar</a>
</div>
<br/>