<?php
/*******************************************************************************
*    República Bolivariana de Venezuela
*    Ministerio del Poder para Ciencia, Tecnología e Industrias Intermedias
*    Fundación Instituto de Ingenieria
*    Centro de Procesamiento Digital de Imagenes
*    
*     Archivo: login.ctp
*     Fecha de Creación: 21/09/2010
*     Creado por: Ing. Luis Alfredo Diaz Jaramillo - ldiazj@fii.gob.ve
*     
*******************************************************************************/
?>
<div class="span-7 boxlogin">&nbsp;</div>	
<div class="span-9">
	<h2>Inicio de Sesión</h2>
    <?php
    echo $this->Form->create('Usuario', array('action' =>'login'));
	?>
	<?php
    echo $this->Form->input('login', array('class'=>'span-5', 'required'=>'true', 'title'=>'Debe ingresar un nombre de usuario', 'label'=>array('text'=>'Nombre de usuario: ', 'class'=>'span-4 derecha'), 'div'=>array('class'=>'span-9 last', 'style'=>'margin: 0 0 5px 0; padding:0;')));
    echo $this->Form->input('clave', array('type'=>'password', 'class'=>'span-5', 'minlength'=>4, 'label'=>array('text'=>'Contrase&ntilde;a: ','class'=>'span-4 derecha'), 'div'=>array('class'=>'span-9 last', 'style'=>'margin: 0 0 5px 0; padding:0;'), 'required'=>'required'));
    echo "<div class='submit' style='text-align:center;'>";
	echo "<button id=\"entrar\">Entrar al sistema</button>";
	echo "</div>";
	echo $this->Form->end();
    ?>
	
</div>
<div class="span-7 boxlogin last">&nbsp;</div>
<div class="span-24 last">&nbsp;</div>
<div class="span-7">&nbsp;</div>
<div id="error" class="ui-state-highlight ui-corner-all" style="display: none; width:402px;float: left;">
<br/>
<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
<span><b>Por favor verifique los siguientes datos antes de continuar:</b></span>
	<ol style="display: block;">
		<li>
			<label class="error" for="UsuarioLogin">
				Debe ingresar un nombre de usuario
			</label>
		</li>
		<li>
			<label class="error" for="UsuarioClave">
				Su contraseña debe contener al menos 4 caracteres
			</label>
		</li>
	</ol>
</div>
<div class="span-6 last">&nbsp;</div>
<script>
	$("#entrar").button();
	var container = $("#error");
$("#UsuarioLoginForm").validate({
	errorContainer: container,
	errorLabelContainer: $("ol", container),
	wrapper: 'li',
	meta: "validate"
});
</script>
