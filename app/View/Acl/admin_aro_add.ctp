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

echo $this->Form->create();
echo $this->Form->input('alias', array('label'=>array('class'=>'span-4 derecha', 'text'=>'Nombre del Rol: '), 'class'=>'span-12'));
echo "<div class='span-24 last'>";
echo $this->Form->end('Crear');
echo "</div>";
?>