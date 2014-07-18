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
<ul>
	<li><?php echo $this->Html->link(
		$title = "Administrar AROS",
		$url = array ('controller'=>'acl', 'action'=>'aros', $value = null),
		$options = array ('alt'=>null, 'escape'=>null, 'id'=>null),
		$confirmMessage = false
		);  ?>
	</li>
	<li><?php echo $this->Html->link(
		$title = "Administrar ACOS",
		$url = array ('controller'=>'acl', 'action'=>'acos', $value = null),
		$options = array ('alt'=>null, 'escape'=>null, 'id'=>null),
		$confirmMessage = false
		);  ?>
	</li>
	<li><?php echo $this->Html->link(
		$title = "Asignar Permisos",
		$url = array ('controller'=>'acl', 'action'=>'permisos', $value = null),
		$options = array ('alt'=>null, 'escape'=>null, 'id'=>null),
		$confirmMessage = false
		);  ?>
	</li>
</ul>