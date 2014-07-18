<script>
	$(document).ready(function(){
		$("#usuarios").tabs();
	});
	function validame(){
		if($("#UsuarioClave").val() == "" || $("#UsuarioClave").val() != $("#UsuarioClave2").val()){
			if($("#UsuarioClave").val() == "") $(".message").html("Debe ingresar una clave de usuario");
		    if($("#UsuarioClave").val() != $("#UsuarioClave2").val()) $(".message").html("Las claves no coinciden");
			$(".message").addClass("visible");
			$("message").click(function(){
					$(".message").slideUp(1500);
					return;
			});
			$(".message").slideDown(1500, function(){
				setTimeout("$('.message').slideUp(1500);", 7000);
			});
			$("#UsuarioClave").focus();
		    return false;
		}else{
			return true;
		}
		
	}
</script>
<div class="message" style="display: none;"></div>
<h2><?php __('Registrar Nuevo Usuario');?></h2>
<div class="usuarios form" id="usuarios">
<?php echo $form->create('Usuario');?> 		
	<ul>
		<li><a href="#datos_personales">Datos Personales</a></li>
		<li><a href="#datos_usuario">Datos del Usuario</a></li>
	</ul>
	<div id="datos_personales" style="height: 200px;">
		<br/>
		<div class="span-24 last">
		<?php
			echo $form->input('nombre', array('class'=>'span-8 last', 'label'=>array('text'=>'Nombre(s):', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 input text')));
			echo $form->input('apellido', array('class'=>'span-8 last', 'label'=>array('text'=>'Apellido(s):', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 last input text')));
		?>
		</div>
		<div class="span-24 last">
		<?
			echo $form->input('cedula', array('class'=>'span-8 last', 'label'=>array('text'=>'Cédula de identidad:', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 input text'), 'onkeypress'=>'return isNumero(event);'));
			echo $form->input('telefono', array('class'=>'span-8 last', 'label'=>array('text'=>'Teléfono:', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 input text')));
		?>
		</div>
		<div class="span-24 last">
		<?
			echo $form->input('email', array('class'=>'span-8 last', 'label'=>array('text'=>'Email:', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 input text')));
			echo $form->input('email_secundario', array('class'=>'span-8 last', 'label'=>array('text'=>'Email secundario:', 'class'=>'span-3 derecha'), 'div'=>array('class'=>'span-11 input text')));
		?>
		</div>
	</div>
	<div id="datos_usuario" style="height: 200px;">
	<br/>
	<?php
		echo "<div class=\"span-24 last\">";
			echo $form->input('usuario', array('label'=>array('text'=>'Nombre de Usuario:', 'class'=>'span-3 derecha'), 'class'=>'span-8 last', 'div'=>array('class'=>'span-11 input text')));
			echo $form->input('aro_id', array('label'=>array('text'=>'Grupo:', 'class'=>'span-3 derecha'), 'empty'=>'Seleccione...', 'class'=>'span-8 last', 'selected'=>'3', 'disabled'=>true, 'div'=>array('class'=>'span-11 input select')));
		echo "</div>";
		echo "<div class=\"span-24 last\">";
			echo $form->input('clave', array('label'=>array('text'=>'Clave:', 'class'=>'span-3 derecha'), 'type'=>'password', 'class'=>'span-8 last', 'div'=>array('class'=>'span-11 input text')));	
			echo $form->input('clave2', array('label'=>array('text'=>'Confirmar clave:', 'class'=>'span-3 derecha'), 'type'=>'password', 'class'=>'span-8 last', 'div'=>array('class'=>'span-11 input text')));
		echo "</div>";
	?>
	</div>
<?= $form->end(array('label'=>'Registrar', 'div'=>array('class'=>'submit span-24 last', 'style'=>'margin-left:20px;'), 'onclick'=>"return validame();")) ?>
</div>
