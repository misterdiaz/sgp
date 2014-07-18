<script type="text/javascript">
$(document).ready(function() {
	$("#EventEventDate").datepicker({
		inline: true,
		changeYear: true,
		changeMonth: true,
		minDate: '-60D'
	});
	$(".pdf, input:submit, .subtmit").button();
	$("#EventAddForm").validate();
});
</script>

<div class="events span-20">
<?php echo $this->Form->create('Event');?>
<h2>Registrar una nueva actividad</h2>
	<?php
		$actividades = array(1=>'Reunión', 2=>'Presentación', 3=>'Asistencia a eventos', 4=>'Publicaciones', 5=>'Otro');
		echo $this->Form->input('tipo', array('label'=>array('text'=>'Tipo de actividad: ', 'class'=>'span-4 derecha'), 'required'=>true, 'empty'=>'Seleccione...', 'title'=>'Seleccione el tipo de actividad a registrar', 'options'=>$actividades, 'class'=>'span-5 last', 'div'=>array('class'=>'span-9')));
		echo $this->Form->input('event_date', array('label'=>array('text'=>'Fecha: ', 'class'=>'span-4 derecha'), 'required'=>true, 'type'=>'text', 'class'=>'span-6 last', 'title'=>'Ingrese una fecha', 'div'=>array('class'=>'span-10 last')));
		echo $this->Form->input('name', array('label'=>array('text'=>'Nombre: ', 'class'=>'span-4 derecha'), 'required'=>true, 'title'=>'Ingrese un nombre para la actividad', 'class'=>'span-14 last', 'div'=>array('class'=>'span-20 last')));
		echo $this->Form->input('notes', array('label'=>array('text'=>'Descripción: ', 'class'=>'span-4 derecha'), 'required'=>true, 'title'=>'Descripción de la actividad', 'class'=>'span-14 last', 'div'=>array('class'=>'span-20 last')));
		
		
	?>
<?php echo $this->Form->end('Guardar');?>
</div>
