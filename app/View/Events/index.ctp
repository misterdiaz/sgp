<?php
$actividades = array(1=>'Reunión', 2=>'Presentación', 3=>'Asistencia a eventos', 4=>'Publicaciones', 5=>'Otro');
$this->Paginator->options(array(
    'update' => '#eventos',
    'evalScripts' => true,
    'url'=>array('action'=>'listeventos'),
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
));
?>
<div class="eventos index" id='eventos'>
	<h2><?php echo __('Eventos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('tipo'); ?></th>
			<th><?php echo $this->Paginator->sort('event_date'); ?></th>
			<th><?php echo $this->Paginator->sort('name', 'Titulo'); ?></th>
			<th><?php echo $this->Paginator->sort('notes'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	</thead>
	<?php
	//pr($eventos);
	foreach ($eventos as $proyecto): ?>
	<tr>
		<td width='100px'><?php echo $actividades[$proyecto['Event']['tipo']]; ?>&nbsp;</td>
		<td width='100px'><?php echo h(turnFecha($proyecto['Event']['event_date'])); ?>&nbsp;</td>
		<td width='300px'><?php echo h($proyecto['Event']['name']); ?>&nbsp;</td>
		<td width='300px'><?php echo h($proyecto['Event']['notes']); ?>&nbsp;</td>
		<td class="actions" width='120px'>
			<?= $this->Html->link($this->Html->image("action_edit.png", array("width"=>"24", 'alt'=>'Editar')), 
			array('action'=>'edit', $proyecto['Event']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
			<?= $this->Html->link($this->Html->image("action_delete.png", array("width"=>"24", 'alt'=>'Eliminar')), 
			array('action'=>'delete', $proyecto['Event']['id']), array("confirm"=>"¿Estas seguro de eliminar este evento?", "indicator"=>null, "escape"=>false)); ?>
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
<div class="actions">
	<ul>
		<li><?= $this->Html->link($this->Html->image("home.png", array("width"=>"48", 'alt'=>'eventos')), 
			"/", 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("evento_add.png", array("width"=>"48", 'alt'=>'eventos')), 
			array( "controller"=>"eventos", "action"=>"add"), 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("pdf_report.png", array("width"=>"48", 'alt'=>'Reportes')), 
			array( "controller"=>"Events", "action"=>"reportes"),
			array("confirm"=>null, "indicator"=>null, "escape"=>false, 'alt'=>'Reportes')); ?>
		</li>
	</ul>
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