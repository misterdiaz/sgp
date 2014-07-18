<script>
	$('#mcp').addClass('current');
	$(document).ready(function(){
		$(".pdf, input:submit, .subtmit").button();
	});
</script>
<h2>Registrar Tipo de Evento</h2>
<br/>
<div class="tipoEventos form span-24 last">
<?php echo $form->create('TipoEvento');?>
	<?php
		echo $form->input('title', array('label'=>array('class'=>'span-5 derecha', 'text'=>'Nombre del tipo de evento:'), 'class'=>'span-8 last', 'div'=>array('class'=>'input text span-13')));
	?>
<?php echo $form->end(array('label'=>'Registrar', 'div'=>array('class'=>'submit span-6')));?>
</div>
