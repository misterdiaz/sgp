<?php
 /*********************************************************************************
*  República Bolivariana de Venezuela                     						  *
*  Ministerio del Poder Popular de Ciencia y Tecnologia							  *
*  Fundación Instituto de Ingenieria                                              *
*  Centro de Procesamiento Digital de Imagenes - (CPDI)                           *
*                                                                                 *
*  Creado por: Ing. Luis Diaz - ldiazj@fii.gob.ve    			                  *
*	                                                                              *
**********************************************************************************/

//pr($this->request);
//pr(AuthComponent::user());
//pr($permisos);
if(AuthComponent::user('id')){
	$user_id = AuthComponent::user('id');

	echo $this->Element('panel-usuario');//Panel con los datos del usuario

	echo $this->Element('panel-actividades', array('actividades'=>$actividades));//Panel con los datos de las actividades por finalizar

	echo $this->Element('panel-permisos'); //Panel con los datos de los permisos

?>



<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Control de Vacaciones</h3>
  </div>
  <table class="table table-responsive table-bordered">
	<thead>
		<tr>
			<th class='col-md-2 text-center'>Período</th>
			<th class='col-md-5 text-center'>Días disponibles</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$total = 0;
		foreach ($periodos as $periodo):
			$year = $periodo['Periodo']['year'];
			$disponible = $periodo['Periodo']['disponible'];
			$total += $disponible;
	?>
		<tr>
			<td class='text-center'><?= $year ?></td>
			<td  class='text-right'><?= $disponible ?></td>
		</tr>
	<?php
		endforeach;
	?>
		<tr>
			<td class='text-right'><strong>Total:</strong></td>
			<td class='text-right'><strong><?= $total ?></strong></td>
		</tr>
	</tbody>
</table>
  <div class="panel-footer">
  	<div class="btn-group">
		<?= $this->Html->link('Solicitar vacaciones', array('controller'=>'Vacaciones', 'action'=>'solicitarDisponibles','admin'=>false), 
		array('class'=>'btn btn-success')) ?>
	</div>
  </div>
</div>

<?php
	}
?>
<script>
$(document).ready(function() {
	$("#liHome").addClass('active');
	$('.actions a').tooltip();
});
</script>
<? echo $this->Js->writeBuffer(); ?>