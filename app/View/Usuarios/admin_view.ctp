<script>
	$(document).ready(function(){
		$("#usuarios").tabs();
	});
</script>
<h2><?php __('Datos del Usuario');?></h2>
<div class="usuarios form span-24 last" id="usuarios">
<?php echo $form->create('Usuario');?> 		
	<ul>
		<li><a href="#datos_personales">Datos Personales</a></li>
		<li><a href="#datos_usuario">Datos del Usuario</a></li>
	</ul>
	<div id="datos_personales" style="height: 200px;">
		<br/>
		<div class="span-24 last">
		<?php
			echo $form->input('nombre', array('class'=>'span-8 last', 'label'=>array('text'=>'Nombre(s):', 'class'=>'span-3 derecha'), 'readonly'=>TRUE, 'div'=>array('class'=>'span-11 input text')));
			echo $form->input('apellido', array('class'=>'span-8 last', 'label'=>array('text'=>'Apellido(s):', 'class'=>'span-3 derecha'), 'readonly'=>TRUE, 'div'=>array('class'=>'span-11 last input text')));
		?>
		</div>
		<div class="span-24 last">
		<?
			echo $form->input('cedula', array('class'=>'span-8 last', 'label'=>array('text'=>'Cédula de identidad:', 'class'=>'span-3 derecha'), 'readonly'=>TRUE, 'div'=>array('class'=>'span-11 input text'), 'onkeypress'=>'return isNumero(event);'));
			echo $form->input('telefono', array('class'=>'span-8 last', 'label'=>array('text'=>'Teléfono:', 'class'=>'span-3 derecha'), 'readonly'=>TRUE, 'div'=>array('class'=>'span-11 input text')));
		?>
		</div>
		<div class="span-24 last">
		<?
			echo $form->input('email', array('class'=>'span-8 last', 'label'=>array('text'=>'Email:', 'class'=>'span-3 derecha'), 'readonly'=>TRUE, 'div'=>array('class'=>'span-11 input text')));
			echo $form->input('email_secundario', array('class'=>'span-8 last', 'label'=>array('text'=>'Email secundario:', 'class'=>'span-3 derecha'), 'readonly'=>TRUE, 'div'=>array('class'=>'span-11 input text')));
		?>
		</div>
	</div>
	<div id="datos_usuario" style="height: 200px;">
	<br/>
	<?php
		echo "<div class=\"span-24 last\">";
			echo $form->input('usuario', array('label'=>array('text'=>'Nombre de Usuario:', 'class'=>'span-3 derecha'), 'readonly'=>TRUE, 'class'=>'span-8 last', 'div'=>array('class'=>'span-11 input text')));
			echo $form->input('clave', array('label'=>array('text'=>'Clave:', 'class'=>'span-3 derecha'), 'readonly'=>TRUE, 'type'=>'password', 'class'=>'span-8 last', 'div'=>array('class'=>'span-11 input text')));
		echo "</div>";
		echo "<div class=\"span-24 last\">";
			echo $form->input('aro_id', array('label'=>array('text'=>'Grupo:', 'class'=>'span-3 derecha'), 'disabled'=>TRUE, 'empty'=>'Seleccione...', 'class'=>'span-8 last', 'div'=>array('class'=>'span-11 input select')));	
			echo $form->input('status', array('label'=>array('text'=>'Activo', 'class'=>'span-3 derecha'), 'disabled'=>TRUE, 'div'=>array('class'=>'span-11 input checkbox')));
		echo "</div>";
	?>
	</div>
</div>
