<div class="span-24">
<?php echo $this->Form->create('TipoActividad'); ?>
		<h3>Agregar nuevo Tipo de Actividad</h3>
	<?php
		echo $this->Form->input('name', array('label'=>array('text'=>'Nombre: ', 'class'=>'span-4 derecha'), 'class'=>'span-10', 'div'=>'span-24 last',
			'required'=>true
		));
		echo $this->Form->input('descripcion', array('label'=>array('text'=>'Descripción: ', 'class'=>'span-4 derecha'), 'type'=>'textarea', 'class'=>'span-10', 'div'=>'span-24 last',
			'required'=>true
		));
	?>
<?php echo $this->Form->end('Guardar'); ?>
</div>
<div class="actions">
	<ul>
		<li><?= $this->Html->link($this->Html->image("home.png", array("width"=>"48", 'alt'=>'Proyectos')), 
			"/", 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("iEngrenages.png", array("width"=>"48", 'alt'=>'Configuración', 'title'=>'Configuración')), 
			array( "controller"=>"Panel", "action"=>"index", 'admin'=>true), 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("tipo_actividad.png", array("width"=>"48")), 
			array( "controller"=>"TipoActividades", "action"=>"index", 'admin'=>true), 
			array("confirm"=>null, "indicator"=>null, "escape"=>false, 'title'=>'Listado Tipo de Actividades')); ?>
		</li>
	</ul>
</div>
<script>
$(document).ready(function() {
	$("#TipoActividadAddForm").validate();
});
</script>