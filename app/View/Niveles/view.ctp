<div class="niveles view">
<h2><?php  __('Nivele');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $nivele['Nivel']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nivel'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $nivele['Nivel']['nivel']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Nivel', true), array('action'=>'edit', $nivele['Nivel']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Nivel', true), array('action'=>'delete', $nivele['Nivel']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $nivele['Nivel']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Niveles', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Nivel', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
