<div class="tipoEventos view">
<h2><?php  __('TipoEvento');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tipoEvento['TipoEvento']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tipoEvento['TipoEvento']['title']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit TipoEvento', true), array('action'=>'edit', $tipoEvento['TipoEvento']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete TipoEvento', true), array('action'=>'delete', $tipoEvento['TipoEvento']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tipoEvento['TipoEvento']['id'])); ?> </li>
		<li><?php echo $html->link(__('List TipoEventos', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New TipoEvento', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
