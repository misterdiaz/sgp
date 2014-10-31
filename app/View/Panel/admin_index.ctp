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
?>
<h2>Panel Administrativo</h2>

<div class="list-group">
<?= $this->Html->link('Usuarios', array( "controller"=>"Usuarios", "action"=>"index", 'admin'=>'true'), 
	array("confirm"=>null, "indicator"=>null, "class"=>"list-group-item")); ?>
	
<?= $this->Html->link("Permisos", array( "controller"=>"Acl", "action"=>"permisos", 'admin'=>'true'), array("confirm"=>null, "indicator"=>null, "class"=>"list-group-item")); ?>

<?= $this->Html->link("Tipos de actividades", array( "controller"=>"TipoActividades", "action"=>"index", 'admin'=>'true'), array("confirm"=>null, "indicator"=>null, "class"=>"list-group-item")); ?>

</div>
