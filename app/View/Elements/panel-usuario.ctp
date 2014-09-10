<?php
$user_id = AuthComponent::user('id');
$usuario = AuthComponent::user('login');
$cedula = AuthComponent::user('cedula');
$nombre = AuthComponent::user('nombre');
$apellido = AuthComponent::user('apellido');
$telefono = AuthComponent::user('telefono');
$profesion = AuthComponent::user('profesion');
$email = AuthComponent::user('email');
$email_secundario = AuthComponent::user('email_secundario');
$rol_id = AuthComponent::user('Rol.id');
$rol_name = AuthComponent::user('Rol.nombre');
$rol_des = AuthComponent::user('Rol.descripcion');
?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Datos del usuario</h3>
  </div>
  <div class="panel-body">
	  <div class="col-md-2">
	  	<div class='img-thumbnail thumbnail' id='preview'>
	      <img src="img/profile.png" class='img-responsive'>
	      <a href="#" id="file-select" class="btn btn-default" style="display: none;">Cambiar imagen</a>
	    </div>
	    <?php
          echo $this->Form->create('Proyecto', array('enctype' => 'multipart/form-data', 'action'=>'addFile'));
          echo $this->Form->file('archivo', array('id'=>'file'));
        ?>
	  </div>
	  <div class="col-md-10">
		  <ul class="list-group">
			  <li class="list-group-item">
			  	<strong>Nombre: </strong> <?= $nombre, " ", $apellido ?>
			  </li>
			  <li class="list-group-item">
			  	<strong>Usuario:</strong> <?= $usuario ?> | <strong>Rol en el sistema:</strong> <?= $rol_name, " ( ", $rol_des," )" ?>
			  </li>
			  <li class="list-group-item">
			  	<strong>Cédula: </strong> <?= $cedula ?>
			  </li>
			  <li class="list-group-item">
			  	<strong>Teléfono: </strong> <?= $telefono ?>
			  </li>
			  <li class="list-group-item">
			  	<strong>Email institucional: </strong><?= $email?> | <strong>Email personal:</strong> <?= $email_secundario ?>
			  </li>
			  <li class="list-group-item">
			  	<strong>Profesión:</strong> <?= $profesion ?>
			  </li>
		  </ul>
	  </div>
  </div>

  <div class="panel-footer">
  	<div class="btn-group">
		<?= $this->Html->link('Actualizar datos', array('controller'=>'Usuarios', 'action'=>'update', 'admin'=>false), 
			array('class'=>'btn btn-primary')) ?>
		<?= $this->Html->link('Cambiar clave', array('controller'=>'Usuarios', 'action'=>'change_password','admin'=>false), 
			array('class'=>'btn btn-primary')) ?>

	</div>
  </div>
</div>