<div class="acos form">
<?php echo $form->create('Aco');?>
	<fieldset>
 		<legend><?php __('Add Aco');?></legend>
	<?php
		echo $form->input('parent_id');
		echo $form->input('model');
		echo $form->input('foreign_key');
		echo $form->input('alias');
		echo $form->input('lft');
		echo $form->input('rght');
		echo $form->input('Aro');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Acos', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Aros', true), array('controller'=> 'aros', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Aro', true), array('controller'=> 'aros', 'action'=>'add')); ?> </li>
	</ul>
</div>
