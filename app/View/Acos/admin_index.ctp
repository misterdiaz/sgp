<div class="acos index">
<h2><?php __('Acos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('parent_id');?></th>
	<th><?php echo $paginator->sort('model');?></th>
	<th><?php echo $paginator->sort('foreign_key');?></th>
	<th><?php echo $paginator->sort('alias');?></th>
	<th><?php echo $paginator->sort('lft');?></th>
	<th><?php echo $paginator->sort('rght');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($acos as $aco):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $aco['Aco']['id']; ?>
		</td>
		<td>
			<?php echo $aco['Aco']['parent_id']; ?>
		</td>
		<td>
			<?php echo $aco['Aco']['model']; ?>
		</td>
		<td>
			<?php echo $aco['Aco']['foreign_key']; ?>
		</td>
		<td>
			<?php echo $aco['Aco']['alias']; ?>
		</td>
		<td>
			<?php echo $aco['Aco']['lft']; ?>
		</td>
		<td>
			<?php echo $aco['Aco']['rght']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $aco['Aco']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $aco['Aco']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $aco['Aco']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $aco['Aco']['id'])); ?>
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
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Aco', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Aros', true), array('controller'=> 'aros', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Aro', true), array('controller'=> 'aros', 'action'=>'add')); ?> </li>
	</ul>
</div>
