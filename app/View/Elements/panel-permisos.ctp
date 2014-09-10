<?php
$statusPermiso = array(1=>'Solicitado', 2=>'Aprobado', 3=>'Negado', 4=>'Cancelado');
$user_id = AuthComponent::user('id');
$rol_id = AuthComponent::user('Rol.id');
?>
<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title">Solicitud de Permisos</h3>
  </div>
<?php
	if(!empty($permisos)):
?>
  <table class='table table-responsive table-bordered'>
  	<thead>
	  	<tr>
	  		<th>Fecha Solicitud</th>
	  		<th>Periodo</th>
	  		<th>Status</th>
	  		<th class='col-md-1'>Acciones</th>
  		</tr>
  	</thead>
  	<tbody>
<?php
	foreach( $permisos as $permiso):
		$status = $permiso['Permiso']['status'];
?>
		<tr>
			<td><?= $permiso['Permiso']['fecha_solicitud'] ?></td>
			<td>Desde: <?= $permiso['Permiso']['fecha_desde'] ?> Hasta: <?= $permiso['Permiso']['fecha_hasta'] ?></td>
			<td><?= $statusPermiso[$status] ?></td>
			<td class='actions'>
				<?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>', 
				array('controller'=>'Permisos',  'action'=>'view', $permiso['Permiso']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false, 
					"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Ver información completa"
				)); ?>

				<?php
				if($status == 1){
					echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>',
						array('controller'=>'Permisos', 'action'=>'edit', $permiso['Permiso']['id']), 
						array("confirm"=>null, "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top", 
							"title"=>"Editar solicitud" )); 

					echo $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>',
						array('controller'=>'Permisos', 'action'=>'delete', $permiso['Permiso']['id']), 
						array("confirm"=>"Estas seguro de eliminar esta solicitud? ", "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", 
							"data-placement"=>"top", "title"=>"Eliminar solicitud" ));

				}else if($status == 2){
					echo $this->Html->link('<span class="glyphicon glyphicon-save"></span>',
						array('controller'=>'Permisos', 'action'=>'generarPdf', 1, $permiso['Permiso']['id']),
						array("confirm"=>null, "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top", 
							"title"=>"Descargar solicitud")); 
				}
				?>
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
		<?= $this->Html->link('Solicitar permiso', array('controller'=>'Permisos', 'action'=>'add', $user_id,'admin'=>false), 
		array('class'=>'btn btn-info')) ?>
	</div>
  </div>
</div>
<?php
if($rol_id == 2):
	echo $this->Element('solicitudes_permiso', array('solicitudes'=>$solicitudes));
endif;
?>