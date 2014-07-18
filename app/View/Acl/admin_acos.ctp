<script>
	$('#acl').addClass('current');
	$(document).ready(function() {
		$('.view').fancybox();
		$('.edit').fancybox({modal2: true});
	});
</script>
<div class="acos">
<h2><?php __('Objetos - Acos');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registro(s) de %count% en total, comenzando con el registro %start% y terminando con el %end%.', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<thead>
<tr>
	<th width="50px"><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('parent_id');?></th>
	<th><?php echo $this->Paginator->sort('Modelo', 'model');?></th>
	<th><?php echo $this->Paginator->sort('alias');?></th>
	<th width="12%"><?php __('Acciones');?></th>
</tr>
</thead>
<?php
$i = 0;
//pr($acos);
foreach ($acos as $aco):
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
			<?php echo $aco['Aco']['id']; ?>
		</td>
		<td<?php echo $class;?>>
			<?php echo $aco['Aco']['parent_id']; ?>
		</td>
		<td<?php echo $class;?>>
			<?php echo $aco['Aco']['model']; ?>
		</td>
		<td<?php echo $class;?>>
			<?php echo $aco['Aco']['alias']; ?>
		</td>
		<td<?php echo $class2;?>>
			<?php echo $this->Html->link($this->Html->image('material_info.png', array('width'=>'28')), array('action'=>'view', $aco['Aco']['id']), array('escape'=>FALSE, 'class'=>'view', 'title'=>'Datos del Objeto')); ?>
			<?php echo $this->Html->link($this->Html->image('material_edit.png', array('width'=>'28')), array('action'=>'edit', $aco['Aco']['id']), array('escape'=>FALSE, 'class'=>'edit', 'title'=>'Editar Objeto')); ?>
			<?php echo $this->Html->link($this->Html->image('material_delete.png', array('width'=>'28')), array('action'=>'delete', $aco['Aco']['id']), array('escape'=>FALSE), '¿Esta realmente seguro que desea eliminar este objeto?'); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
