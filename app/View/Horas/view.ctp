<div class="span-16">
<?php echo $this->Form->create('Hora'); ?>
		<h2>Registro de Horas de dedicación.</h2>
		<h2><?= mes2letras($this->data['Hora']['mes'])?> del <?= $this->data['Hora']['year']?></h2>
		<h2>Semana laboral Nro: <?= $this->data['Hora']['semana']?></h2>
	<?php
		echo $this->Form->input('tipo_actividad_id', array(
			'label'=>array('text'=>'Tipo de Actividad: ', 'class'=>'span-4 derecha'), 'empty'=>'Seleccione...', 'class'=>'span-6 last',
			'div'=>array('class'=>'span-10'), 'disabled'=>true
		));
		echo $this->Form->input('actividad_id', array(
			'label'=>array('text'=>'Actividad: ', 'class'=>'span-4 derecha'), 'empty'=>'Seleccione...', 'class'=>'span-12 last',
			'div'=>array('class'=>'span-16 last', 'id'=>'actividad_div'), 'disabled'=>true
		));
		echo $this->Form->input('observacion', array(
			'label'=>array('text'=>'Descripción /<br/>Observaciones: ', 'class'=>'span-4 derecha'), 'class'=>'span-10',
			'div'=>array('class'=>'span-24 last'), 'disabled'=>true
		));
		
		echo $this->Form->input('cantidad', array(
			'label'=>array('text'=>'Cantidad de horas dedicadas: ', 'class'=>'span-4 derecha'), 'class'=>'span-2',
			'div'=>array('class'=>'span-24 last'), 'required'=>true, 'type'=>'text', 'readonly'=>true
		));
	?>
</div>

<script>
$(document).ready(function() {
	//$("#actividad_div").hide();
	
	$("#HoraTipoActividadId").on("click", function(){
		valor = $(this).val();
		if(valor==1){
			$("#actividad_div").show();
		}else{
			$("#HoraActividadId").val("");
			$("#actividad_div").hide();
		}
	})
	//$(".btn").button();
});
</script>