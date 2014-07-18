<?php
$statusOpc = array(1=>'Activo', 2=>'Inactivo', 3=>'Culminado', 4=>'Cancelado');
$this->Paginator->options(array(
    'update' => '#proyectos',
    'evalScripts' => true,
    'url'=>array('action'=>'listProyectos'),
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
));
?>
<div class="proyectos index" id='proyectos'>
	<h2><?php echo __('Proyectos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('codigo', 'cod'); ?></th>
			<th><?php echo $this->Paginator->sort('name', 'Titulo'); ?></th>
			<th><?php echo $this->Paginator->sort('coordinador_id'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_inicio'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_culminacion'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	</thead>
	<?php
	//pr($proyectos);
	foreach ($proyectos as $proyecto): ?>
	<tr>
		<td width='30px'><?php echo h($proyecto['Proyecto']['id']); ?>&nbsp;</td>
		<td width='300px'><?php echo h($proyecto['Proyecto']['name']); ?>&nbsp;</td>
		<td width='220px'><?php echo h($proyecto['Usuario']['fullname']); ?>&nbsp;</td>
		<td width='100px'><?php if(!empty($proyecto['Proyecto']['fecha_inicio'])) echo $proyecto['Proyecto']['fecha_inicio']; ?>&nbsp;</td>
		<td width='100px'><?php if(!empty($proyecto['Proyecto']['fecha_culminacion'])) echo $proyecto['Proyecto']['fecha_culminacion']; ?>&nbsp;</td>
		<td width='80px'><?php if(!empty($proyecto['Proyecto']['status'])) echo $statusOpc[$proyecto['Proyecto']['status']]; ?>&nbsp;</td>
		<td class="actions" width='120px'>
			<?= $this->Html->link($this->Html->image("action_view.png", array("width"=>"24", 'alt'=>'Ver')), 
			array('action'=>'view', $proyecto['Proyecto']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
			<?= $this->Html->link($this->Html->image("action_edit.png", array("width"=>"24", 'alt'=>'Editar')), 
			array('action'=>'edit', $proyecto['Proyecto']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
			<?= $this->Html->link($this->Html->image("action_pdf.png", array("width"=>"24", 'alt'=>'PDF')), 
			array('action'=>'resumenPdf', 1, $proyecto['Proyecto']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
			<?= $this->Html->link($this->Html->image("action_delete.png", array("width"=>"24", 'alt'=>'PDF')), 
			array('action'=>'delete', $proyecto['Proyecto']['id']), array("confirm"=>"Estas seguro de eliminar el Proyecto: ".$proyecto['Proyecto']['name'], "indicator"=>null, "escape"=>false)); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
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
	$(".linkFB").fancybox({
        'type' : 'ajax',
        'scrolling': 'no',
        'autoScale': 'true',
        'autoDimensions': 'true'
    });
});
</script>