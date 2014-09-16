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
			<td class='text-center'><?php if($year==2014) echo "Días acumulados hasta el ".$year;else echo $year; ?></td>
			<td  class='text-right'><?= $disponible ?></td>
		</tr>
	<?php
		endforeach;
	?>
		<tr>
			<td class='text-right' colspan="2"><strong>Total: <?= $total ?></strong></td>
		</tr>
	</tbody>
	</table>
  <div class="panel-footer">
  	<div class="btn-group">
		<?php
		if ($total == 0) $disabled = 'disabled';
		else $disabled = '';
		echo $this->Html->link('Solicitar vacaciones', array('controller'=>'Vacaciones', 'action'=>'solicitarDisponibles','admin'=>false), 
			array('class'=>'btn btn-success '.$disabled));

		if(AuthComponent::user('id')==39){
			echo $this->Html->link('Registrar dias', array('controller'=>'Vacaciones', 'action'=>'registrarDisponibles','admin'=>false), 
			array('class'=>'btn btn-success'));
		}
		?>
	</div>
  </div>
</div>