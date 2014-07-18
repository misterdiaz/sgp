<script>
	$('#mcm').addClass('current');
	$(document).ready(function() {
		$('.view').fancybox();
		$('.edit').fancybox();
	});
</script>
<div class="materiales">
<h2><?php __('Materiales');?></h2>
<p>
<table cellpadding="0" cellspacing="0">
<tr>
	<thead>
	<th width="50px">Nro.</th>
	<th width="20%">evento_id</th>
	<th>Titulo</th>
	<th>Tipo de Evento</th>
	<th>fecha</th>
	<th>Actions</th>
	</thead>
</tr>
<?php
$i = 0;
foreach ($materiales=array() as $materiale):
	$class = null;
	$class2 = "class='actions'";
	if ($i++ % 2 != 0) {
		$class = ' class="altrow"';
		$class2 = ' class="actions altrow"';
	}
?>
	<tr>
		<td <?php echo $class;?>>
			<?php echo $materiale['Material']['id']; ?>
		</td>
		<td <?php echo $class;?>>
			<?php echo $materiale['Evento']['name']; ?>
		</td>
		<td <?php echo $class;?>>
			<?php echo $materiale['Material']['title']; ?>
		</td>
		<td <?php echo $class;?>>
			<?php echo $materiale['Material']['type']; ?>
		</td>
		<td <?php echo $class;?>>
			<?php echo turnFecha($materiale['Material']['fecha']); ?>
		</td>
		<td <?php echo $class2;?>>
			<?php echo $html->link(__('View', true), array('action'=>'view', $materiale['Material']['id']), array('class'=>'view')); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit_view', $materiale['Material']['id']), array('class'=>'edit')); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $materiale['Material']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $materiale['Material']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>

<? //echo $this->Js->writeBuffer(); ?>