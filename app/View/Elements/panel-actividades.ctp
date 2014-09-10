<?php //pr($actividades); ?>
<div class="panel panel-danger">
  <div class="panel-heading">
    <h3 class="panel-title">Actividades por finalizar</h3>
  </div>
  <table class='table table-responsive table-bordered'>
  	<thead>
	  	<tr>
	  		<th class='col-md-5'>Nombre</th>
	  		<th class='col-md-4'>Producto</th>
	  		<th class='col-md-2 text-center'>Fecha culminación</th>
	  		<th class='col-md-1'>Acciones</th>
  		</tr>
  	</thead>
  	<tbody>
	<?php
		foreach ($actividades as $actividad):

			$nombre = $actividad['Actividad']['nombre'];
			$producto = $actividad['Actividad']['producto'];
			$fecha_culminacion = $actividad['Actividad']['fecha_culminacion'];
			$actividad_id = $actividad['Actividad']['id'];
	?>
		<tr>
			<td><?= $nombre ?></td>
			<td><?= $producto ?></td>
			<td class='text-center'> <?= $fecha_culminacion ?></td>
			<td class='actions'><?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>', 
				array('controller'=>'Actividades',  'action'=>'view', $actividad_id), array("confirm"=>null, "indicator"=>null, "escape"=>false, 
					"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Ver información completa"
				)); ?></td>
		</tr>
	<?php
		endforeach;	?>
  	</tbody>
  </table>
</div>
