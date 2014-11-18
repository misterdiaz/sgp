<?php
$this->Html->addCrumb('Permisos', array('controller'=>'Permisos', 'action'=>'index'));
$this->Html->addCrumb('Histórico');
?>
<div class="permisos index">
	<h2>Histórico de Permisos</h2>
	<table class="table table-responsive table-bordered table-hover">
	<thead>
		<tr class="info">
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nro'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_solicitud'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_desde'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_hasta'); ?></th>
			<th><?php echo $this->Paginator->sort('nro_dias'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions">Acciones</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$statusPermiso = array(1=>'Solicitado', 2=>'Aprobado', 3=>'Negado', 4=>'Cancelado');
	foreach ($permisos as $permiso): 
		$status = $permiso['Permiso']['status'];
	?>
	<tr>
		<td><?php echo h($permiso['Permiso']['id']); ?>&nbsp;</td>
		<td><?php echo h($permiso['Permiso']['nro']); ?>&nbsp;</td>
		<td><?php echo h($permiso['Permiso']['fecha_solicitud']); ?>&nbsp;</td>
		<td><?php echo h($permiso['Permiso']['fecha_desde']); ?>&nbsp;</td>
		<td><?php echo h($permiso['Permiso']['fecha_hasta']); ?>&nbsp;</td>
		<td><?php echo h($permiso['Permiso']['nro_dias']); ?>&nbsp;</td>
		<td><?php echo $statusPermiso[$status]; ?>&nbsp;</td>
		<td class='text-center col-sm-2'>
			<div class="btn-group">
		        <button type="button" class="btn btn-default">
		        	<?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>', 
					array('controller'=>'Permisos',  'action'=>'view', $permiso['Permiso']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Ver información completa")); ?>
				</button>
		        <button type="button" class="btn btn-default <? if($status == 2 || $status == 3) echo 'disabled'?>">
		        	<?= $this->Html->link('<span class="glyphicon glyphicon-edit"></span>',
					array('controller'=>'Permisos', 'action'=>'edit', $permiso['Permiso']['id']), 
					array("confirm"=>null, "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top",  "title"=>"Editar solicitud")); ?>
		        </button>
		        <button type="button" class="btn btn-default <? if($status == 1 || $status == 3) echo 'disabled'?>">
		        	<?= $this->Form->postLink('<span class="glyphicon glyphicon-save"></span>',
					array('controller'=>'Permisos', 'action'=>'generarPdf', $permiso['Permiso']['id']),
					array("confirm"=>null, "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top",  "title"=>"Descargar solicitud")); ?>
		        </button>
		        <button type="button" class="btn btn-default <? if($status == 2 || $status == 3) echo 'disabled'?>">
		        	<?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>',
					array('controller'=>'Permisos', 'action'=>'delete', $permiso['Permiso']['id']), 
					array("escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Eliminar solicitud" ), 'Estas seguro de eliminar' ); ?>
		        </button>
	    	</div>

			<?php
			if($status == 1) $solicitada = "disabled"; else $solicitada = "";
			if($status == 2) $aprobada = "disabled"; else $aprobada = "";
			?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous '), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<script>
$(document).ready(function() {
	$("#liPermisos").addClass('active');
	$("#ulPermisos").addClass('in');
	$("#lnk_historico_permisos").addClass('current');  
});
</script>