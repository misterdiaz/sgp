<script>
	$('#mcp').addClass('current');
	$(document).ready(function() {
		$('.view').fancybox();
		$('.edit').fancybox({modal2: true});
	});
</script>
<div class="tipoEventos">
<h2><?php __('TipoEventos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registro(s) de %count% en total, comenzando con el registro %start% y terminando con el %end%.', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<thead>
<tr>
	<th width="50px"><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('Tipo de Evento', 'title');?></th>
	<th class="actions" width="10%"><?php __('Acciones');?></th>
</tr>
</thead>
<?php
$i = 0;
foreach ($tipoEventos as $tipoEvento):
		$class = null;
	if ($i++ % 2 != 0) {
		$class = ' class="altrow"';
		$class2 = ' class="altrow actions"';
	}else{
		$class = ' class=""';
		$class2 = ' class="actions"';
	}
?>
	<tr>
		<td<?php echo $class;?>>
			<?php echo $tipoEvento['TipoEvento']['id']; ?>
		</td>
		<td<?php echo $class;?>>
			<?php echo $tipoEvento['TipoEvento']['title']; ?>
		</td>
		<td<?php echo $class2;?>>
			<?php //echo $html->link($html->image('material_info.png', array('width'=>'28')), array('action'=>'view', $paise['Paises']['id']), array('escape'=>FALSE, 'class'=>'view', 'title'=>'Datos del tipo de evento')); ?>
			<?php echo $html->link($html->image('material_edit.png', array('width'=>'28')), array('action'=>'edit', $tipoEvento['TipoEvento']['id']), array('escape'=>FALSE, 'class'=>'edit', 'title'=>'Editar tipo de evento')); ?>
			<?php echo $html->link($html->image('material_delete.png', array('width'=>'28')), array('action'=>'delete', $tipoEvento['TipoEvento']['id']), array('escape'=>FALSE), '¿Esta realmente seguro que desea eliminar este tipo de Evento?'); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
