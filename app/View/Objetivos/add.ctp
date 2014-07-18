<?php
$this->Html->addCrumb('Proyectos', array('controller'=>'Proyectos', 'action'=>'index'));
$this->Html->addCrumb('Ver', array('controller'=>'Proyectos', 'action'=>'view', $proyecto_id));
$this->Html->addCrumb('Agregar objetivo', '');
?>
<h3>Agregar objetivo especifico</h3>
<?php echo $this->Form->create('Objetivo', array('class'=>'form')); ?>

<div class="form-group">
	<?= $this->Form->input('proyecto_id', array('type'=>'hidden', 'value'=>$proyecto_id)); ?>
	<label for="exampleInputEmail1">Descripción</label>
	<?= $this->Form->input('descripcion', array('label'=>false, 'div'=>false, 'class'=>'form-control', 'required'=>true)) ?>
</div>
<div class="btn-group">
	<?php echo $this->Form->end(array('label'=>'Guardar', 'div'=>false, "class"=>"btn btn-default")); ?>
	<a href="<?= $this->Html->url(array('controller'=>'Proyectos', 'action'=>'view', $proyecto_id)) ?>" class="btn btn-default">Cancelar</a>
</div>

<script>
$(document).ready(function() {
	//$("#ObjetivoAddForm").validate();
	$("#liProyectos").addClass('active');
	$("#ulProyectos").addClass('in');
	
});
</script>
