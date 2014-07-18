<script>
	$(document).ready(function(){
		$("#usuarios").tabs();
		$(".pdf, input:submit, .subtmit").button();
	});
</script>
<h2>Editar usuario</h2>
<div class="usuarios form span-24 last" id="usuarios">
<?php echo $this->Form->create('Usuario');?> 		
	<ul>
		<li><a href="#datos_personales">Datos Personales</a></li>
		<li><a href="#datos_usuario">Datos del Usuario</a></li>
	</ul>
	<div id="datos_personales" style="height: 200px;">
		<br/>
		<div class="span-24 last">
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('nombre', array('class'=>'span-8 last', 'label'=>array('text'=>'Nombre(s):', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 input text')));
			echo $this->Form->input('apellido', array('class'=>'span-8 last', 'label'=>array('text'=>'Apellido(s):', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 last input text')));
		?>
		</div>
		<div class="span-24 last">
		<?
			echo $this->Form->input('cedula', array('class'=>'span-8 last', 'label'=>array('text'=>'Cédula de identidad:', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 input text'), 'onkeypress'=>'return isNumero(event);'));
			echo $this->Form->input('telefono', array('class'=>'span-8 last', 'label'=>array('text'=>'Teléfono:', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 input text')));
		?>
		</div>
		<div class="span-24 last">
		<?
			echo $this->Form->input('email', array('class'=>'span-8 last', 'label'=>array('text'=>'Email:', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 input text')));
			echo $this->Form->input('email_secundario', array('class'=>'span-8 last', 'label'=>array('text'=>'Email secundario:', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 input text')));
		?>
		</div>
	</div>
	<div id="datos_usuario" style="height: 200px;">
	<br/>
	<?php
		echo "<div class=\"span-24 last\">";
			echo $this->Form->input('login', array('label'=>array('text'=>'Nombre de Usuario:', 'class'=>'span-3 derecha'), 'class'=>'span-8 last', 'div'=>array('class'=>'span-11 input text')));
			echo $this->Form->input('clave', array('label'=>array('text'=>'Clave:', 'class'=>'span-3 derecha'), 'type'=>'password', 'class'=>'span-8 last', 'div'=>array('class'=>'span-11 input text')));
		echo "</div>";
		echo "<div class=\"span-24 last\">";
			echo $this->Form->input('rol_id', array('label'=>array('text'=>'Grupo:', 'class'=>'span-3 derecha'), 'empty'=>'Seleccione...', 'class'=>'span-8 last', 'div'=>array('class'=>'span-11 input select')));	
			echo $this->Form->input('status', array('label'=>array('text'=>'Activo', 'class'=>'span-3 derecha'), 'required'=>true, 'options'=>array(1=>'Activo', 2=>'Suspendido', 3=>'Eliminado'), 'div'=>array('class'=>'span-11 input checkbox')));
		echo "</div>";
	?>
	</div>
<?= $this->Form->end(array('label'=>'Actualizar', 'div'=>array('class'=>'submit span-24 last', 'style'=>'margin-left:0px;'))) ?>
</div>
