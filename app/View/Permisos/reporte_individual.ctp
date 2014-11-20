<?php
$this->Html->addCrumb('Permisos', array('controller'=>'Permisos', 'action'=>'index'));
$this->Html->addCrumb('Reportes', array('controller'=>'Permisos', 'action'=>'reportes'));
$this->Html->addCrumb('Reporte Individual');

$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
echo $this->Form->create('Permiso', array('class'=>'form', 'inputDefaults'=>$defaults));

?>
<div class="row">

<div class="form-group form-horizontal">
	<label for="PermisoYear" class="col-md-1 control-label">Año: </label>
		<div class="col-md-1">
			<?= $this->Form->input('year', array('placeHolder'=>'YYYY', 'default'=>date('Y'), 'type'=>'number', 'required'=>true)) ?>
		</div>
	<label for="ProyectoCoordinadorName" class="col-sm-1 control-label">Trabajador:</label>
	<div class="col-md-4">
	<?php
		echo $this->Form->input('coordinadorName', array('required'=>true, 'readonly'=>true));
		echo $this->Form->input('coordinador_id', array('type'=>'hidden', 'required'=>true));
	 ?>
	 </div>
	 <div class="col-sm-1">
	 	<a  href="#personal" class='btn btn-default' data-toggle="modal" data-target="#personal">
	 		Buscar <span class="glyphicon glyphicon-search"></span>
	 	</a>
	 </div>
</div>
</div>

<div>&nbsp;</div>

<div class="btn-group">
	<?php echo $this->Form->end(array('label'=>'Continuar', 'div'=>false, "class"=>"btn btn-default enviar")); ?>
	<a href="<?= $this->Html->url(array('controller'=>'Permisos', 'action'=>'reportes')) ?>" class="btn btn-default">Cancelar</a>
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

<?php
if ($this->request->is('post') && !empty($Permisos)):
	$estatus = array(1=>'Solicitado', 2=>'Aprobado', 3=>'Denegado', 4=>'Cancelado');
?>
<h2>Permisos Año: <?= $year ?></h2>
	<table class="table table-responsive table-bordered table-hover">
	<thead>
		<tr class="info">
			<th class="text-center">Nro</th>
			<th class="text-center">Trabajador</th>
			<th class="text-center">Fecha inicio</th>
			<th class="text-center">Fecha culminación</th>
			<th class="text-center">Cantidad de dias</th>
			<th class="text-center">Status</th>
			<th class="text-center">---</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	foreach ($Permisos as $permiso): 
		$status = $permiso['Permiso']['status'];
	$i++;
	?>
	<tr>
		<td class="text-center"><?= $i; ?>&nbsp;</td>
		<td><?php echo $permiso['Usuario']['fullname']; ?>&nbsp;</td>
		<td class="text-center"><?php echo $permiso['Permiso']['fecha_desde']; ?>&nbsp;</td>
		<td class="text-center"><?php echo $permiso['Permiso']['fecha_hasta']; ?>&nbsp;</td>
		<td class="text-right"><?php echo $permiso['Permiso']['nro_dias']; ?>&nbsp;</td>
		<td class="text-center"><?php echo $estatus[$permiso['Permiso']['status']]; ?></td>
		<td class="text-center">
			<?= $this->Form->postLink('Ver', 
				array('controller'=>'Permisos',  'action'=>'view', $permiso['Permiso']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Ver información completa")); ?>

		    <? if($permiso['Permiso']['status'] == 2) echo " - ".$this->Form->postLink('PDF',
				array('controller'=>'Permisos', 'action'=>'generarPdf', $permiso['Permiso']['id']),
				array("confirm"=>null, "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top",  "title"=>"Descargar solicitud")); ?>
			
		    <? if($permiso['Permiso']['status'] == 4) echo " - ".$this->Form->postLink('Eliminar',
				array('controller'=>'Permisos', 'action'=>'delete', $permiso['Permiso']['id']), 
				array("escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Eliminar solicitud" ), 'Estas seguro de eliminar' ); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
</div>
<?php
endif;
if ($this->request->is('post') && empty($Permisos)):
?>
<div>&nbsp;</div>
<div class="alert alert-warning" role="alert">La busqueda no arrojo resultados.</div>
<?php
endif;
?>

<script>
$(document).ready(function() {
	$("#liPermisos").addClass('active');
	$("#ulPermisos").addClass('in');
	$(".enviar").addClass('disabled');
	$("#lnk_reporte_permisos").addClass('current');
  	$(".list-group-item").on("click", function() {
		valor = $(this).attr('id');
		nombre = $(this).attr('valor');
		$("#PermisoCoordinadorId").val(valor);
		$(".enviar").removeClass('disabled');
		$("#PermisoCoordinadorName").val(nombre);
		$('#personal').modal('hide');
		//$.fancybox.close();
	})
  
});
</script>