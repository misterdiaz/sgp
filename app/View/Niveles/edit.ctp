<div class="niveles form">
<?php echo $form->create('Nivel');?>
	<fieldset>
 		<legend><?php __('Edit Nivel');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('nivel');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Nivel.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Nivele.id'))); ?></li>
		<li><?php echo $html->link(__('List Niveles', true), array('action'=>'index'));?></li>
	</ul>
</div>
