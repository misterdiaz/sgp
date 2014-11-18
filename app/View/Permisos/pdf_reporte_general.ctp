<?php
	$statusPermiso = array(1=>'Solicitado', 2=>'Aprobado', 3=>'Negado', 4=>'Cancelado');
?>
<h2>Permisos <?= $titulo ?></h2>
<h3>Status: <?= $statusPermiso[$status] ?></h3>
	<table class="table table-responsive table-bordered table-hover">
	<thead>
		<tr class="info">
			<th class="text-center">Nro</th>
			<th class="text-center">Trabajador</th>
			<th class="text-center">Fecha inicio</th>
			<th class="text-center">Fecha culminación</th>
			<th class="text-center">Cantidad de dias</th>
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
		<td class="text-center">
			<?= $this->Form->postLink('Ver', 
				array('controller'=>'Permisos',  'action'=>'view', $permiso['Permiso']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Ver información completa")); ?>
			-
		    <?= $this->Form->postLink('PDF',
				array('controller'=>'Permisos', 'action'=>'generarPdf', $permiso['Permiso']['id']),
				array("confirm"=>null, "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top",  "title"=>"Descargar solicitud")); ?>
			-
		    <?= $this->Form->postLink('Eliminar',
				array('controller'=>'Permisos', 'action'=>'delete', $permiso['Permiso']['id']), 
				array("escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Eliminar solicitud" ), 'Estas seguro de eliminar' ); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
</div>
<div class="btn-group">
	<a href="<?= $this->Html->url(array('controller'=>'Permisos', 'action'=>'reporteGeneral')) ?>" class="btn btn-default">Regresar</a>
</div>
<script>
$(document).ready(function() {
	$("#liPermisos").addClass('active');
	$("#ulPermisos").addClass('in');
	$("#lnk_reporte_permisos").addClass('current');  
});
</script>