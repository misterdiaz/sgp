<h2>Solicitud de Vacaciones (Días disponibles)</h2>
<hr/>
<?php
$this->Html->addCrumb('Vacaciones', array('controller'=>'Proyectos', 'action'=>'index'));
$this->Html->addCrumb('Días disponibles', '');

$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
echo $this->Form->create('Vacacion', array('class'=>'form', 'inputDefaults'=>$defaults));

$statusOpc = array(1=>'Solicitado', 2=>'Aprobado', 3=>'Negado', 4=>'Cancelado');
$nombre = AuthComponent::user('nombre')." ".AuthComponent::user('apellido');
$usuario_id = AuthComponent::user('id');
$centro_id = AuthComponent::user('centro_id');
$cargo_id =  AuthComponent::user('cargo_id');
$cargo =  AuthComponent::user('Cargo.name');
$dias_disponibles = AuthComponent::user('DiasDisponibles.nro_dias');
$tipos_permiso = array('1'=>'Remunerado', 2=>'No Remunerado');

$cant_dias = array('0'=>'1/2 Dia', '1'=>'01 Dia', '2'=>'02 Días', '3'=>'03 Días');

//pr($periodos);
?>
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
  <strong>Nota!</strong> Posees <?= $dias_disponibles ?> dias disponibles por disfrutar.
</div>
<div class="row">
	<div class="form-group form-horizontal">
		<label for="VacacionUsuarioId" class="col-sm-2 control-label">Trabajador Solicitante: </label>
		<div class="col-sm-3">
			<?= $this->Form->input('usuario', array('type'=>'text', 'class'=>'form-control', 'value'=>$nombre, 'readonly')) ?>
			<?= $this->Form->input('usuario_id', array('type'=>'hidden', 'value'=>$usuario_id)) ?>
		</div>
		<label for="VacacionFechaSolicitud" class="col-sm-1 control-label">Fecha de Solicitud:</label>
		<div class="col-sm-1">
			<?= $this->Form->day('fecha_solicitud', array('required'=>true, 'class'=>'form-control', 'value'=>date('d'), 'disabled')); ?>
		</div>
		<div class="col-sm-1">
			<?= $this->Form->month('fecha_solicitud', array('required'=>true, 'class'=>'form-control', 'value'=>date('m'), 'disabled', 'monthNames' => false)); ?>
		</div>
		<div class="col-sm-2">
			<?= $this->Form->year('fecha_solicitud', date('Y')-2, date('Y')+2, array('required'=>true, 'value'=>date('Y'), 'disabled', 'class'=>'form-control')); ?>
		</div>
	</div>
</div>

<div>&nbsp;</div>

<div class="row">
	<div class="form-group form-horizontal">
		<label for="VacacionFechaDesde" class="col-sm-2 control-label">Desde:</label>
		<div class="col-sm-1">
			<?= $this->Form->day('fecha_desde', array('required'=>true, 'class'=>'form-control', 'value'=>date('d'))); ?>
		</div>
		<div class="col-sm-1">
			<?= $this->Form->month('fecha_desde', array('required'=>true, 'class'=>'form-control', 'monthNames' => false, 'value'=>date('m'))); ?>
		</div>
		<div class="col-sm-2">
			<?= $this->Form->year('fecha_desde', date('Y')-1, date('Y')+1, array('required'=>true, 'class'=>'form-control', 'value'=>date('Y'))); ?>
		</div>
	</div>
</div>

<div>&nbsp;</div>

<table class="table table-responsive table-bordered">
	<thead>
		<tr class='info'>
			<th class='col-md-2 text-center'>Período</th>
			<th class='col-md-5 text-center'>Días disponibles</th>
			<th class='col-md-5 text-center'>Cantidad a disfrutar</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach ($periodos as $periodo):
			$year = $periodo['Periodo']['year'];
			$disponible = $periodo['Periodo']['disponible'];
	?>
		<tr>
			<td class='text-center'><?= ($year - 1 )." - ".$year ?></td>
			<td class='text-center'><?= $disponible ?></td>
			<td class='text-right'>
				<?= $this->Form->input('nro_dias.'.$year, 
					array('class'=>'form-control text-center dias', 'default'=>'0', 'type'=>'number'))?>
			</td>
		</tr>
	<?php
		endforeach;
	?>
		<tr>
			<td colspan="2" class='text-right'><strong>Total:</strong></td>
			<td class='text-right'><div id='total'></div></td>
		</tr>
	</tbody>
</table>

<div>&nbsp;</div>

<div class="btn-group">
	<?php echo $this->Form->end(array('label'=>'Solicitar', 'div'=>false, "class"=>"btn btn-default")); ?>
	<a href="<?= $this->Html->url(array('controller'=>'Panel', 'action'=>'index')) ?>" class="btn btn-default">Cancelar</a>
</div>
<script>
$(document).ready(function() {
	
	function updateSuma(){
		$('.table').each(function(){
		  var totalPoints = 0;
		  $(this).find('input').each(function(){
		    totalPoints += parseFloat($(this).val()); //<==== a catch  in here !! read below
		  });
		  $("#total").html( "<b>"+totalPoints+"</b>" );
		});
	};
	$( ".dias" ).change(function() {
		updateSuma();
	});
	
});
</script>