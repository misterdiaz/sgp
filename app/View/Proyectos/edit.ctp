<h2>Editar Proyecto</h2>
<?php
$this->Html->addCrumb('Proyectos', array('controller'=>'Proyectos', 'action'=>'index'));
$this->Html->addCrumb('Editar', '');

$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
echo $this->Form->create('Proyecto', array('class'=>'form', 'inputDefaults'=>$defaults));

$this->request->data['Proyecto']['fecha_inicio'] = turnFecha($this->request->data['Proyecto']['fecha_inicio'], 2);
$this->request->data['Proyecto']['fecha_culminacion'] = turnFecha($this->request->data['Proyecto']['fecha_culminacion'], 2);
$statusOpc = array(1=>'Activo', 2=>'Inactivo', 3=>'Culminado', 4=>'Cancelado');
$this->request->data['Proyecto']['coordinadorName'] = $this->request->data['Usuario']['fullname'];
$this->request->data['Proyecto']['presupuesto'] = formatoDB($this->data['Proyecto']['presupuesto']);
?>
<div class="form-group">
	<label for="ProyectoName">Nombre del proyecto: </label>
	<?= $this->Form->input('name', array('required'=>true)) ?>
</div>

<div class="form-group">
	<label for="ProyectoObjetivoGeneral">Objetivo general: </label>
	<?= $this->Form->input('objetivoGeneral', array('required'=>true)) ?>
</div>

<div class="form-group">
	<label for="ProyectoCliente">Cliente: </label>
	<?= $this->Form->input('cliente', array('required'=>true)) ?>
</div>

<div class="form-group form-horizontal">
	<label for="ProyectoFechaInicio" class="col-sm-2 control-label">Fecha de inicio:</label>
	<div class="col-sm-1">
		<?= $this->Form->day('fecha_inicio', array('required'=>true, 'class'=>'form-control')); ?>
	</div>
	<div class="col-sm-1">
		<?= $this->Form->month('fecha_inicio', array('required'=>true, 'class'=>'form-control', 'monthNames' => false)); ?>
	</div>
	<div class="col-sm-2">
		<?= $this->Form->year('fecha_inicio', date('Y')-2, date('Y')+2, array('required'=>true, 'class'=>'form-control')); ?>
	</div>

	<label for="ProyectoFechaCulminacion" class="col-sm-2 control-label">Fecha de Culminación:</label>
	<div class="col-sm-1">
		<?= $this->Form->day('fecha_culminacion', array('required'=>true, 'class'=>'form-control')); ?>
	</div>
	<div class="col-sm-1">
		<?= $this->Form->month('fecha_culminacion', array('required'=>true, 'class'=>'form-control', 'monthNames' => false)); ?>
	</div>
	<div class="col-sm-2">
		<?= $this->Form->year('fecha_culminacion', date('Y')-2, date('Y')+2, array('required'=>true, 'class'=>'form-control')); ?>
	</div>

</div>

<div>&nbsp;</div>

<div class="form-group form-horizontal">
	<label for="ProyectoCoordinadorName" class="col-sm-1 control-label">Coordinador:</label>
	<div class="col-sm-10">
	<?php
		echo $this->Form->input('coordinadorName', array('required'=>true, 'readonly'=>true));
		echo $this->Form->input('coordinador_id', array('type'=>'hidden'));
	 ?>
	 </div>
	 <div class="col-sm-1">
	 	<a  href="#personal" class='btn btn-default' data-toggle="modal" data-target="#personal">
	 		Buscar <span class="glyphicon glyphicon-search"></span>
	 	</a>
	 </div>
</div>
<div>&nbsp;</div>
<div class="form-group form-inline">
	<label for="ProyectoCodigo">Código: </label>
	<?= $this->Form->input('codigo', array('required'=>true, 'title'=>'Por favor, ingresa el código del proyecto')) ?>

	<label for="ActividadPeso">Presupuesto: Bs.</label>
	<?= $this->Form->input('presupuesto', array('required'=>true, 'title'=>'Por favor, ingrese el monto del proyecto')) ?>

	<label for="ActividadStatus">Status:</label>
	<?= $this->Form->input('status', array('required'=>true, 'options'=>$statusOpc, 'empty'=>'Seleccione...')) ?>
</div>

<div class="btn-group">
	<?php echo $this->Form->end(array('label'=>'Guardar', 'div'=>false, "class"=>"btn btn-default")); ?>
	<a href="<?= $this->Html->url(array('controller'=>'Proyectos', 'action'=>'index')) ?>" class="btn btn-default">Cancelar</a>
</div>

<div class="modal fade" id="personal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Personal del CPDI</h4>
      </div>
      <div class="modal-body">
      	<div class="list-group">
	        <?php
			foreach ($personal as $row) {
				//pr($row);
				$fullname = $row['Usuario']['fullname'];
				$personal_id = $row['Usuario']['id'];
				echo "<a href='#divCoord'  class='list-group-item' id='$personal_id' valor='$fullname'>$fullname</a>";
			} 
			?>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$(document).ready(function() {
	$("#liProyectos").addClass('active');
	$("#ulProyectos").addClass('in');
	$("#lnk_proyectosAdd").addClass('current');
  	$(".list-group-item").on("click", function() {
		valor = $(this).attr('id');
		nombre = $(this).attr('valor');
		$("#ProyectoCoordinadorId").val(valor);
		$("#ProyectoCoordinadorName").val(nombre);
		$('#personal').modal('hide');
		//$.fancybox.close();
	})
  
});
</script>