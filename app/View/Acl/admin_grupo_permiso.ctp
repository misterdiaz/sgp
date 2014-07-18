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
$tipo = array(-1=>"Denegado", 0=>"Grupo", 1=>"Permitido");
?>
<h2>Permisos del grupo:</h2>
<table>
<thead>
	<tr>
		<th rowspan="2" width="30%">&nbsp;</th>
		<th rowspan="2" width="30%">Objeto</th>
		<th colspan="4" style="text-align:center;">Permisos</th>
	</tr>
	<tr>
		<th width="10%" style="text-align:center;">Crear</th>
		<th width="10%" style="text-align:center;">Leer</th>
		<th width="10%" style="text-align:center;">Actualizar</th>
		<th width="10%" style="text-align:center;">Eliminar</th>
	</tr>
</thead>
<?php
	$i = 0;
	if(!empty($grupo))
	foreach($grupo[0]['Aco'] as $obj){
		if($i++ % 2 != 0) $class = "class='altrow'";
		else $class = "";
		//pr($obj);
?>
	<tr>
		<td></td>
		<td <? echo $class?>><?= $obj['alias'] ?></td>
		<td <? echo $class?> style="text-align:center;"><?= $tipo[$obj['Permission']['_create']] ?></td>
		<td <? echo $class?> style="text-align:center;"><?= $tipo[$obj['Permission']['_read']] ?></td>
		<td <? echo $class?>style="text-align:center;"><?= $tipo[$obj['Permission']['_update']] ?></td>
		<td <? echo $class?> style="text-align:center;"><?= $tipo[$obj['Permission']['_delete']] ?></td>
	</tr>
<?php
	}
?>
</table>