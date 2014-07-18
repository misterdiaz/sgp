<div class="niveles form">
<?php echo $form->create('Nivel');?>
	<fieldset>
 		<legend><?php __('Add Nivel');?></legend>
	<?php
		echo $form->input('nivel');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Niveles', true), array('action'=>'index'));?></li>
	</ul>
</div>
