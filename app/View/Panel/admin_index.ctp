<?php
 /*********************************************************************************
*  República Bolivariana de Venezuela                     
*  Ministerio del Poder Popular de Ciencia y Tecnologia
*  Fundación Instituto de Ingenieria                                                                                                                              
*  Centro de Procesamiento Digital de Imagenes - (CPDI)                                    
*                                                                                 
*                                                                                                  
*  Creado por: Ing. Luis Diaz - ldiazj@fii.gob.ve    			                                                                      
*	                                                                              
***********************************************************************************/
	
	echo "<br/>";
	echo "<h2>Panel Administrativo</h2>";
	echo "<br/>";
	echo "<br/>";
	
?>
<div class="span-24">
<div class='span-4'>
	&nbsp;
</div>	
<div class='span-4'>
<p class='panel'>
	<?= $this->Html->link($this->Html->image("group.png", array("width"=>"128", 'alt'=>'Usuarios')), array( "controller"=>"Usuarios", "action"=>"index", 'admin'=>'true'), array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
	<br/><b>Usuarios</b>
</p>
</div>

<div class='span-4'>
<p class='panel'>
	<?= $this->Html->link($this->Html->image("members.png", array("width"=>"128", 'alt'=>'Permisos')), array( "controller"=>"Acl", "action"=>"permisos", 'admin'=>'true'), array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
	<br/><b>Permisos</b>
</p>
</div>

<div class='span-4'>
<p class='panel'>
	<?= $this->Html->link($this->Html->image("tipo_actividad.png", array("width"=>"128", 'alt'=>'Permisos')), array( "controller"=>"TipoActividades", "action"=>"index", 'admin'=>'true'), array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
	<br/><b>Tipo Actividades</b>
</p>
</div>

</div>
<div class="actions">
	<ul>
		<li><?= $this->Html->link($this->Html->image("home.png", array("width"=>"48", 'alt'=>'Proyectos')), 
			"/", 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
	</ul>
</div>
