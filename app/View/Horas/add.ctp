<?php
$this->Html->addCrumb('Regitro de horas', array('controller'=>'Proyectos', 'action'=>'index'));
$this->Html->addCrumb('Semana '.date('W'), '');
echo $this->Form->create('Hora');
$this->Form->inputDefaults(array('div'=>false, 'label'=>false), $merge = false);

?>
<h2>Registro de Horas de dedicación.</h2>
<? if(!empty($horas)): ?>
	<?= $this->Element('horas_registradas') ?>
<? endif;?>

<div class="row">
	<div class="form-group">
		<label for="HorasTipoActividadId" class="control-label">Tipo de Actividad: </label>
		<?= $this->Form->input('tipo_actividad_id', array('required'=>true, 'empty'=>'Seleccione...', 'class'=>'form-control')); ?>
	</div>
</div>

<div class="row">
	<div class="form-group" id='actividad_div'>
		<label for="HorasActividadId" class="control-label">Actividad: </label>
		<?= $this->Form->input('actividad_id', array('empty'=>'Seleccione...', 'class'=>'form-control')); ?>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<label for="HorasCantidad" class="control-label">Cantidad de horas dedicadas: </label>
		<?= $this->Form->input('cantidad', array('required'=>true, 'class'=>'form-control')); ?>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<label for="HorasObservacion" class="control-label">Descripción /Observaciones: </label>
		<?= $this->Form->input('observacion', array('required'=>true, 'class'=>'form-control')); ?>
	</div>
</div>
<?
	echo $this->Form->input('semana', array('type'=>'hidden', 'value'=>$semana));
	echo $this->Form->input('mes', array('type'=>'hidden', 'value'=>date('n')));
	echo $this->Form->input('year', array('type'=>'hidden', 'value'=>date('Y')));
?>
<div class="btn-group">
	<?php echo $this->Form->end(array('label'=>'Guardar', 'div'=>false, "class"=>"btn btn-default")); ?>
	<a href="<?= $this->Html->url(array('controller'=>'Panel', 'action'=>'index')) ?>" class="btn btn-default">Cancelar</a>
</div>

<script>
$(document).ready(function() {
	$("#actividad_div").hide();
	$("#HoraTipoActividadId").on("click", function(){
		valor = $(this).val();
		if(valor==1){
			$("#actividad_div").show();
			$("#HoraActividadId").attr('required', true);
		}else{
			$("#HoraActividadId").val("");
			$("#actividad_div").hide();
		}
	})
});
</script>