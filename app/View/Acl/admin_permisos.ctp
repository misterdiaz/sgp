<?php 
$this->Html->addCrumb('Control de Acceso');
?>
<h2>Asignación de permisos</h2>
<div>	
	<?
		$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
		echo $this->Form->create('Acl', array('class'=>'form', 'inputDefaults'=>$defaults, 'action'=>'aro_view_miembros'));	
	?>
<div class="row">
	<div class="form-group form-horizontal">
		<label for="AroAro" class="col-sm-2 control-label">Elegir el grupo: </label>
		<div class="col-sm-2">
			<?= $this->Form->input('aro', array('options'=>$aros, 'class'=>'form-control', 'empty'=>'Seleccione...', 'required'=>true)) ?>
		</div>
		<div class="btn-group">
			<?php echo $this->Form->end(array('label'=>'Continuar', 'div'=>false, "class"=>"btn btn-info")); ?>
			<a href="<?= $this->Html->url(array('controller'=>'Panel', 'action'=>'index', 'admin'=>true)) ?>" class="btn btn-danger">Cancelar</a>
		</div>
	</div>
</div>	
</div>

