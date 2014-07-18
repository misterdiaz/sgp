<?php
$this->Html->addCrumb('Proyectos', $this->here);
$statusOpc = array(1=>'Activo', 2=>'Inactivo', 3=>'Culminado', 4=>'Cancelado');
$this->Paginator->options(array(
    'update' => '#proyectos',
    'evalScripts' => true,
    'url'=>array('action'=>'index'),
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
));
?>
<div class="page-header">
	<h2>Listado de Proyectos</h2>
</div>
<div class="" id='proyectos'>
	
	<table class="table table-bordered table-hover table-responsive">
	<thead>
		<tr class="info">
			<th width="120px"><?php echo $this->Paginator->sort('codigo', 'cod'); ?></th>
			<th><?php echo $this->Paginator->sort('name', 'Titulo'); ?></th>
			<th><?php echo $this->Paginator->sort('coordinador_id'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_inicio'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_culminacion'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	//pr($proyectos);
	foreach ($proyectos as $proyecto): ?>
	<tr>
		<td><?php echo h($proyecto['Proyecto']['codigo']); ?>&nbsp;</td>
		<td><?php echo h($proyecto['Proyecto']['name']); ?>&nbsp;</td>
		<td><?php echo h($proyecto['Usuario']['fullname']); ?>&nbsp;</td>
		<td><?php if(!empty($proyecto['Proyecto']['fecha_inicio'])) echo $proyecto['Proyecto']['fecha_inicio']; ?>&nbsp;</td>
		<td><?php if(!empty($proyecto['Proyecto']['fecha_culminacion'])) echo $proyecto['Proyecto']['fecha_culminacion']; ?>&nbsp;</td>
		<td><?php if(!empty($proyecto['Proyecto']['status'])) echo $statusOpc[$proyecto['Proyecto']['status']]; ?>&nbsp;</td>
		<td class='actions'>
			<?= $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>', 
			array('action'=>'view', $proyecto['Proyecto']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false, 
				"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Ver información del proyecto"
			)); ?>

			<?= $this->Html->link('<span class="glyphicon glyphicon-edit"></span>',
			array('action'=>'edit', $proyecto['Proyecto']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false,
				"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Editar información básica"
			)); ?>

			<?php
			if($rol_id == 2){
				echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',
			array('action'=>'delete', $proyecto['Proyecto']['id']), array("confirm"=>"Estas seguro de eliminar el Proyecto: ".$proyecto['Proyecto']['name'], "indicator"=>null, "escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Eliminar proyecto"
				));
			}
			?>

			<?= $this->Html->link('<span class="glyphicon glyphicon-save"></span>',
			array('action'=>'resumenPdf', 1, $proyecto['Proyecto']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false,
				"data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Descargar resumen en PDF"
			)); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Página {:page} de {:pages}, mostrando {:current} proyectos de {:count} en total, comenzando con el proyecto {:start} y terminando en el {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Ant. '), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' '));
		echo $this->Paginator->next(__(' Sig.') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

<? echo $this->Js->writeBuffer(); ?>
<script>
$(document).ready(function() {
	$("#liProyectos").addClass('active');
	$("#ulProyectos").addClass('in');
	$("#lnk_proyectos").addClass('current');
	$('.actions a').tooltip();
});
</script>