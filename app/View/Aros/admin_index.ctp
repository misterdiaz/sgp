<div class="aros index">
<h2><?php __('Aros');?></h2>
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
foreach ($aros as $aro):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $aro['Aro']['id']; ?>
		</td>
		<td>
			<?php echo $aro['Aro']['parent_id']; ?>
		</td>
		<td>
			<?php echo $aro['Aro']['model']; ?>
		</td>
		<td>
			<?php echo $aro['Aro']['foreign_key']; ?>
		</td>
		<td>
			<?php echo $aro['Aro']['alias']; ?>
		</td>
		<td>
			<?php echo $aro['Aro']['lft']; ?>
		</td>
		<td>
			<?php echo $aro['Aro']['rght']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $aro['Aro']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $aro['Aro']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $aro['Aro']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $aro['Aro']['id'])); ?>
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
		<li><?php echo $html->link(__('New Aro', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Acos', true), array('controller'=> 'acos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Aco', true), array('controller'=> 'acos', 'action'=>'add')); ?> </li>
	</ul>
</div>
