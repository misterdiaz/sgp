<script>
	
</script>
<h3>Pesos de las actividades del proyecto <?= $nombreP['Proyecto']['name']?></h3>
<table>
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Responsable</th>
			<th>Peso</th>
		</tr>
	</thead>
<?php
//pr($actividades);
echo $this->Form->create('Actividad');
$total = 0;
foreach ($actividades as $actividad) {
	$nombre = $actividad['Actividad']['nombre'];
	$actividad_id = $actividad['Actividad']['id'];
	$responsable = $actividad['Usuario']['fullname'];
	$peso = $actividad['Actividad']['peso'];
	$total += $peso;
?>
<tr>
	<td><?= $nombre ?></td>
	<td><?= $responsable ?></td>
	<td><?= $this->form->input("peso.$actividad_id", array('label'=>false, 'id'=>"peso_$actividad_id", 'onkeypress'=>'return isNumero(event);', 'maxlength'=>2, 'class'=>'pesosI', 'size'=>'2', 'value'=>$peso)); ?></td>
</tr>
<?php 
}
?>
<tr>
	<td colspan='2' style="text-align: right"><b>Total:</b></td>
	<td><?= $this->form->input("total", array('label'=>false, 'size'=>'2', 'readonly'=>true, 'value'=>$total)); ?></td>
</tr>
</table>
<?= $this->Form->end(array('label'=>"Guardar", 'id'=>'btSave')) ?>
<script>
$(document).ready(function() {
	$('#btSave').attr('disabled', 'disabled');
	$("input[type='text']").change(function(){
	var suma = 0;
	var tamano = $(".pesosI").size();
	var cero = false;
	$(".pesosI").each(
		function(index, value) {
			var actual = eval($(this).val())
			suma = suma + actual;
			if(actual==0){
				cero = true;
			}
		}
	);
	/*for(var i=0; i < (tamano); i++){
		var valor = Number($("input[id='peso_"+(i+1)+"']").val());
		alert(valor);
		if(valor == 0 || valor==''){
			cero = true;
		}
		suma += valor;
	}*/
	$("#total").val(suma);
	if($("#total").val() == 100 && !cero){
		$('#btSave').removeAttr('disabled');
		$('#btSave').removeAttr("aria-disabled");
		$('#btSave').attr("class", "ui-button ui-widget ui-state-default ui-corner-all");
	}else{
		$('#btSave').attr('disabled', 'disabled');
		alert("La suma total no es igual a 100 ó alguno de los valores es igual a cero");
	}
	});
});
</script>