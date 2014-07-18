<div id='actividades'>
<h2>Actividades</h2>
<?php
//pr($actividades);
$this->Paginator->options(array(
	'model'=>'Actividad',
    'update' => '#actividades',
    'evalScripts' => true,
    'url'=>array('controller'=>'Actividades', 'action'=>'listActividades')
));
?>
<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<th><?php echo $this->Paginator->sort('nombre', 'Nombre', array('model'=>'Actividad')); ?></th>
		<th><?php echo $this->Paginator->sort('fecha_inicio', 'Inicio', array('model'=>'Actividad')); ?></th>
		<th><?php echo $this->Paginator->sort('fecha_culminacion', 'Culminación', array('model'=>'Actividad')); ?></th>
		<th><?php echo $this->Paginator->sort('status', 'Status', array('model'=>'Actividad')); ?></th>
		<th><?php echo $this->Paginator->sort('culminado', 'Total % Avance', array('model'=>'Actividad')); ?></th>
		<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	</thead>
<?php
	$statusOpc = array(1=>'Activo', 2=>'Inactivo', 3=>'Culminado', 4=>'Cancelado');
	foreach ($actividades as $actividad) {
		$total_avance = 0;
		foreach ($actividad['Avance'] as $key) {
			$total_avance += $key['porcentaje'];
		}
?>
<tr>
	<td width='40%'><?= $this->Html->link($actividad['Actividad']['nombre'], array('controller'=>'Proyectos', 'action'=>'resumen', $actividad['Actividad']['objetivo_id']), array('class'=>'linkAct')) ?></td>
	<td><?= $actividad['Actividad']['fecha_inicio'] ?></td>
	<td><?= $actividad['Actividad']['fecha_culminacion'] ?></td>
	<td><?= $statusOpc[$actividad['Actividad']['status']] ?></td>
	<td style='text-align:center'><?= $total_avance ?> %</td>
	<td class="actions">
		<?= $this->Html->link($this->Html->image("action_update.png", array("width"=>"24", 'alt'=>'Editar avance')), 
			array('controller'=>'Actividades', 'action'=>'update_avance', $actividad['Actividad']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false, 'class'=>'linkFB')); ?>
	</td>
</tr>
<?php
		
	}
?>
</table>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
));
?>	</p>

<div class="paging">
<?php
	echo $this->Paginator->prev('< ' . __('Ant. '), array('model'=>'Actividad'), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ' ', 'model'=>'Actividad'));
	echo $this->Paginator->next(__(' Sig.') . ' >', array('model'=>'Actividad'), null, array('class' => 'next disabled'));
?>
</div>
</div>
<? echo $this->Js->writeBuffer(); ?>