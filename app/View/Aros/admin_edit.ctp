<div class="aros form">
<?php echo $this->Form->create('Aro');?>
<h2>Editar Rol</h2>
	<?php
		echo $this->Form->input('id', array('type'=>'hidden'));
		echo $this->Form->input('alias', array('label'=>array('class'=>'span-4 derecha', 'text'=>'Nombre del Rol: '), 'class'=>'span-12'));
	?>
<div class="span-24 last">
	<?php echo $this->Form->end('Guardar');?>
</div>

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
			<?= $this->Html->link($this->Html->image("group-list.png", array("width"=>"48", 'title'=>'Listado Roles')), 
			array( "controller"=>"Acl", "action"=>"aros", 'admin'=>true),
			array("confirm"=>null, "indicator"=>null, "escape"=>false, 'alt'=>'Reportes')); ?>
		</li>
	</ul>
</div>
