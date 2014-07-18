<div class="roles form">
<?php echo $this->Form->create('Rol');?>
	<h2>Agregar Rol</h2>
	<?php
		echo $this->Form->input('nombre', array('label'=>array('text'=>'Nombre del Rol: ', 'class'=>'span-4 derecha'), 'class'=>'span-8', 'div'=>array('class'=>'span-24 last')));
		echo $this->Form->input('descripcion', array('label'=>array('text'=>'Descripción: ', 'class'=>'span-4 derecha'), 'class'=>'span-16', 'div'=>array('class'=>'span-24 last')));
	?>
<?php echo $this->Form->end(__('Guardar', true));?>
</div>
<div class="actions">
	<ul>
		<li><?= $this->Html->link($this->Html->image("home.png", array("width"=>"48", 'alt'=>'Inicio', 'title'=>'Inicio')), 
			"/", 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("iEngrenages.png", array("width"=>"48", 'alt'=>'Configuración', 'title'=>'Configuración')), 
			array( "controller"=>"Panel", "action"=>"index", 'admin'=>true), 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("group.png", array("width"=>"48", 'alt'=>'Listado Usuarios', 'title'=>'Listado Usuarios')), 
			array( "controller"=>"Usuarios", "action"=>"index", 'admin'=>true),
			array("confirm"=>null, "indicator"=>null, "escape"=>false, 'alt'=>'Reportes')); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("group-list.png", array("width"=>"48", 'alt'=>'Agregar Rol', 'title'=>'Listado Roles')), 
			array( "controller"=>"Roles", "action"=>"index", 'admin'=>true),
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
	</ul>
</div>