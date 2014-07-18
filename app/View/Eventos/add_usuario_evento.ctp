<? 
	if(isset($msg_flash)){
		show_mensaje($msg_flash);
	}
?>
<?php
/*******************************************************************************
*    República Bolivariana de Venezuela
*    Ministerio del Poder para Ciencia, Tecnología e Industrias Intermedias
*    Fundación Instituto de Ingenieria
*    Centro de Procesamiento Digital de Imagenes
*    
*     Archivo: add_usuario_evento.ctp
*     Fecha de Creación: 27/09/2010
*     Creado por: Ing. Luis Alfredo Diaz Jaramillo - ldiazj@fii.gob.ve
*     
*******************************************************************************/


?>
	<div id="personal">
	<?php
		echo $form->create('EventosUsuario', array('controller'=>'Eventos','action'=>'add_usuario_evento'));
		echo "<br/>";
		echo $form->input('evento_id', array('value'=>$id, 'type'=>'hidden'));
		echo "<div class='span-24 last'>";
			echo $form->input('usuario_id', array('options'=>$personal, 'selected'=>$session->read('Auth.Usuario.id'), 'label'=>array('text'=>'Nombre del personal:', 'class'=>'span-4 derecha'), 'class'=>'span-6 last', 'empty'=>'Seleccione...', 'div'=>array('class'=>'input select span-10')));
			echo "<label class='span-4 derecha'>Asistio al evento como: </label>";
			echo "<div class='span-3'>";
				echo $form->input('participante', array('checked'=>TRUE, 'between'=>' '));
			echo "</div>";
			echo "<div class='span-3'>";
				echo $form->input('ponente', array('between'=>' '));
			echo "</div>";
			echo $ajax->submit('Agregar', array(
			    'url'=> array('controller'=>'Eventos', 'action'=>'add_usuario_evento', $value=null), 
			    'update' => array('personal'),
			    'condition' => null, // '$("#campo1").val() == $("#campo2").val()'
			    'confirm' => null,
			    'indicator' => null,
			    'before' => null // '$("#post2").html("Wait a moment")'
			    ));
			//echo $form->end(array('div'=>array('class'=>'submit span-2 last'), 'label'=>'Agregar'));
		echo "</div>";
		//echo "<div class='span-24 last' style='height:132px'>&nbsp;</div>";
	?>
		<div id="add_personal">
		<table>
			<thead>
				<tr>
					<th>Nombre</th><th>Participante</th><th>Ponente</th><th>Acciones</th>
				</tr>
			</thead>
			<? 
				foreach($eventos_usuarios as $eventos_usuario){
			?>
				<tr>
					<td><? echo $eventos_usuario['Usuario']['name'] ?></td>
					<td><? echo $eventos_usuario['EventosUsuario']['participante'] ?></td>
					<td><? echo $eventos_usuario['EventosUsuario']['ponente'] ?></td>
					<td>
					<? 
						/*echo $html->link(
						$title = $html->image('material_edit.png', array('width'=>'28')),
						$url = array('controller'=>'Eventos', 'action'=>'evento_personal_edit', $eventos_usuario['EventosUsuario']['id']),
						$options = array ('alt'=>null, 'escape'=>false, 'id'=>null, 'class'=>'edit', 'title'=>'Editar'),
						$confirmMessage = false
					);*/
					echo $ajax->link(
						$html->image('material_delete.png', array('width'=>'28')), 
						array( 'controller'=>'Eventos', 'action'=>'evento_personal_delete', $value=$eventos_usuario['EventosUsuario']['id']), 
						array( 'update' => array('personal'), 'escape'=>false, 'confirm' =>null, 'indicator'=>null ) 
					);
					?>
					</td>
				</tr>
			<?	
				}
			?>
		</table>
		</div>
	</div>