<?php
	//pr($_SESSION);
?>
<div class="niveles index">
<h2><?php __('Niveles');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('nivel');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($niveles as $nivele):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $nivele['Nivel']['id']; ?>
		</td>
		<td>
			<?php echo $nivele['Nivel']['nivel']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $nivele['Nivel']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $nivele['Nivel']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $nivele['Nivel']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $nivele['Nivel']['id'])); ?>
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
		<li><?php echo $html->link(__('New Nivele', true), array('action'=>'add')); ?></li>
	</ul>
</div>
