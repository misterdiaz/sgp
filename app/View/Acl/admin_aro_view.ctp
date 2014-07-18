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

//pr($aro);
?>
<h3>Datos del grupo: <?php echo $aro['Aro']['alias']; ?></h3>

<?php
echo $this->Form->create();
echo $this->Form->input('alias', array('class'=>'span-8'));
echo "<br/>";
echo $this->Form->input('parent_id', array('value'=>$aro['Aro']['id'], 'type'=>'hidden', 'class'=>'span-8'));
echo $this->Form->input('model', array('value'=>'Usuario', 'type'=>'hidden', 'class'=>'span-8'));
echo $this->Form->input('foreign_key', array('class'=>'span-8', 'options'=>$foreing_key));
echo "<br/>";
echo $this->Form->end('Agregar Usuario al grupo');
?>
<br/>
<p>
Listado de Usuarios:
</p>
<table>
	<tr>
		<th>Usuario</th>
		<th>Id</th>
	</tr>
	
	<?php	
	
		foreach($listado as $user){
	?>
	<tr>
		<td><? echo $user['Aro']['alias'] ?></td>
		<td><? echo $user['Aro']['foreign_key'] ?></td>
	</tr>
	<?php
		}
	?>
	
</table>