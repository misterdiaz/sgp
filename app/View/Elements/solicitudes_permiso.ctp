<?php
$statusPermiso = array(1=>'Solicitado', 2=>'Aprobado', 3=>'Negado', 4=>'Cancelado');
?>
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Control de Permisos</h3>
  </div>
<?php
	if(!empty($solicitudes)):
?>
  <table class='table table-responsive'>
  	<thead>
	  	<tr>
	  		<th>Trabajador</th>
	  		<th>Fecha Solicitud</th>
	  		<th>Periodo</th>
	  		<th>Status</th>
	  		<th class='col-md-2 text-center'>Acciones</th>
  		</tr>
  	</thead>
  	<tbody>
<?php
	foreach( $solicitudes as $solicitud):
		$status = $solicitud['Permiso']['status'];
		$trabajador = $solicitud['Usuario']['fullname'];
?>
		<tr>
			<td><?= $trabajador ?></td>
			<td><?= $solicitud['Permiso']['fecha_solicitud'] ?></td>
			<td>Desde: <?= $solicitud['Permiso']['fecha_desde'] ?> Hasta: <?= $solicitud['Permiso']['fecha_hasta'] ?></td>
			<td><?= $statusPermiso[$status] ?></td>
			<td class='actions col-md-2 text-center'>
				<?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>', 
				array('controller'=>'Permisos',  'action'=>'view', $solicitud['Permiso']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false, 
					"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Ver información completa"
				)); ?>

				<?= $this->Form->postLink('<span class="glyphicon glyphicon-ok"></span>',
						array('controller'=>'Permisos', 'action'=>'aprobar', $solicitud['Permiso']['id']), 
						array("confirm"=>"Estas seguro de aprobar esta solicitud? ", "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", 
							"data-placement"=>"top", "title"=>"Aprobar solicitud" )); ?>

				<?= $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>',
						array('controller'=>'Permisos', 'action'=>'denegar', $solicitud['Permiso']['id']), 
						array("confirm"=>"Estas seguro de denegar esta solicitud? ", "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", 
							"data-placement"=>"top", "title"=>"Denegar solicitud" )); ?>
				</td>
		</tr>
<?php
	endforeach;
?>
  	</tbody>
  </table>
<?php
endif;
?>
  <div class="panel-footer">
  	<div class="btn-group">

	</div>
  </div>
</div>