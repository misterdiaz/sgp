<h2>Avance de actividad: <?= $actividad['Actividad']['nombre'] ?></h2>
<?php
$this->Html->addCrumb('Actividades', array('controller'=>'Actividades', 'action'=>'index'));
$this->Html->addCrumb('Actualizar avance', '');
$statusOpc = array(1=>'Activo', 2=>'Inactivo', 3=>'Culminado', 4=>'Cancelado');
?>
<span class="label label-primary">Fecha de inicio: <?= $actividad['Actividad']['fecha_inicio'] ?></span>
<span class="label label-danger">Fecha de Culminación: <?= $actividad['Actividad']['fecha_culminacion'] ?></span>
<div class="col-md-12">
<table class="table table-bordered table-striped table-responsive">
<thead>
	<tr class='info'>
		<th>Año</th>
		<th>Mes</th>
		<th>Avance</th>
		<th width='78px'>Acciones</th>
	</tr>
</thead>
<tbody>
<?php
$meses = array(1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Obtubre', 11=>'Noviembre', 12=>'Diciembre');
	//pr($actividad);
	$total=0;
	$fecha_inicio = turnFecha($actividad['Actividad']['fecha_inicio'], 2);
	$fecha_culminacion = turnFecha($actividad['Actividad']['fecha_culminacion'], 2);
	$mes_inicio = date("n", strtotime($fecha_inicio));
	$mes_culminacion = date("n", strtotime($fecha_culminacion));
	$year_inicio = date("Y", strtotime($fecha_inicio));
	$year_culminacion = date("Y", strtotime($fecha_culminacion));
	//echo "fecha_inicio: $fecha_inicio | mes_inicio: $mes_inicio | año_culminacion: $year_culminacion | fecha_culminacion: $fecha_culminacion | mes_culminacion: $mes_culminacion | año_inicio: $year_inicio";
	
	$actividad_id = $actividad['Actividad']['id'];
	foreach ($actividad['Avance'] as $avance) {
		$avance_id = $avance['id'];
		$mes = $avance['mes'];
		$year= $avance['year'];
		$porcentaje = $avance['porcentaje'];
		$total += $porcentaje;

?>
	<tr>
		<td><?= $year ?></td>
		<td><?= $meses[$mes] ?></td>
		<td><?= $porcentaje ?> %</td>
		<td class='actions'>
			<?= $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', 
			array('controller'=>'Actividades',  'action'=>'edit_avance', $avance_id), array("confirm"=>null, "indicator"=>null, "escape"=>false, 
				"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Editar avance ".$meses[$mes].' de '.$year
			)); ?>

			<?= $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',
			array('controller'=>'Actividades', 'action'=>'delete_avance', $avance_id), array("confirm"=>null, "indicator"=>null, "escape"=>false,
				"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Eliminar avance ".$meses[$mes].' de '.$year
			)); ?>
		</td>
	</tr>
<?php
	}
	$faltante = 100 - $total;
?>
	<tr>
		<td colspan='2' style='text-align:right;'>
			<strong>Total: </strong>
		</td>
		<td><strong><?= $total ?> %</strong></td>
	</tr>
</tbody>
</table>
</div>
<div>&nbsp;</div>
<?php
	$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
	echo $this->Form->create('Avance', array('class'=>'form-inline', 'inputDefaults'=>$defaults));

	echo $this->Form->input('actividad_id', array('type'=>'hidden', 'value'=>$actividad_id));
	if($year_inicio == $year_culminacion){
		$mensajeY = "El año no puede ser diferente a $year_culminacion";
	}else{
		$mensajeY = "Pro favor ingrese un año entre $year_inicio y $year_culminacion";
	}
	$mInicio = $meses[$mes_inicio];
	$mFin = $meses[$mes_culminacion];
	$mensajeM = "Por favor seleccione un mes entre $mInicio y $mFin";
?>
<div class="form-group">
	<label for="AvanceYear">Año: </label>
	<?= $this->Form->input('year', array('required'=>true, 'value'=>$year_inicio, 'number'=>true, 'range'=>"$year_inicio, $year_culminacion", 'title'=>$mensajeY)) ?>
	<label for="AvanceMes">Mes: </label>
	<?= $this->Form->input('mes', array('required'=>true, 'empty'=>'Seleccione...', 'options'=>$meses, 'selected'=>date('m'), 'range'=>"$mes_inicio, $mes_culminacion", 'title'=>$mensajeM)) ?>	
	<label for="AvancePorcentaje">Porcentaje  de avance: </label>
	<?= $this->Form->input('porcentaje', array('required'=>true, 'title'=>"Debes ingresar un porcentaje máximo de $faltante. (Solo números enteros)", 'number'=>true, 'max'=>$faltante)) ?>
	<div class="btn-group">
		<button class="btn btn-default">
			<span class="glyphicon glyphicon-ok"></span> Guardar
		</button>
		<?= $this->Html->link('Cancelar <span class="glyphicon glyphicon-remove"></span>', 
			array('controller'=>'Actividades', 'action'=>'index'), array('class'=>'btn btn-default', 'escape'=>false)) ?>
	</div>
</div>
<div>&nbsp;</div>
<div class="alert alert-warning" role="alert">
	<p>
		<b>Nota:</b> No podrá ingresar un avance de actividades si se encuentra fuera del rango de la fecha de inicio y de culminación de la actividad. 
		En caso de necesitar modificar una fecha, comuniquese con el coordinador(a) del proyecto.
	</p>
</div>


<script>
$(document).ready(function() {
	$("#liActividades").addClass('active');
	$("#ulActividades").addClass('in');
	$("#lnk_actividades").addClass('current');
	$('.actions a').tooltip();
	//$("#AvanceUpdateAvanceForm").validate();
});
</script>