<script>
	$('#mce').addClass('current');
	$(document).ready(function() {
		//alert("hola1");
		 $("#MaterialPerteneceInstituto").click(function () {
      		$("#autor_local").toggleClass("invisible");
			$("#autor_foraneo").toggleClass("invisible");
   		 });
		
		$("#eventos").tabs({
			//disabled: [3],		
			collapsible: true
 		});
		$("#archivos").tabs({
			//disabled: [3],
 		});
		$("#eventos").tabs("select", "#materiales");
		//$("#link_material").fancybox();

		$("#link_material").fancybox({
			onStart : function() {
				$("#archivos").removeClass('invisible');
			}, 
			onClosed : function() {
				$("#archivos").addClass('invisible');
			},
			modal2: true,
			//'titlePosition' : 'inside',
			'transitionIn' : 'none',
			'transitionOut' : 'none'
		});
		
		$(".info").fancybox();
		$(".edit").fancybox({
			showNavArrows: true,
			modal2: true
		});

	});
</script>
<?
	//pr($this->data);
	echo "<h2>".$this->data['Evento']['name']."</h2>";
?>

<div class="eventos form span-24 last" id="eventos" style="height: 450px;">
    	<ul>
			<li><a href="#datos">Información del Evento</a></li>
			<li><a href="#ubicacion">Ubicación</a></li>
			<li><a href="#personal">Personal</a></li>
			<li><a href="#materiales">Listado de Documentos</a></li>
		</ul>
<?php echo $form->create('Evento');?>
	<div id="datos">
	<?php
		echo $form->input('id');
		echo "<br/>";
		echo "<div class='span-24'>";
		echo $form->input('tipo_evento_id', array('label'=>array('text'=>'Tipo de Evento:', 'class'=>'span-4 derecha'), 'empty'=>'Seleccione...', 'disabled'=>true, 'class'=>'span-6 last', 'div'=>array('class'=>'input select span-10')));
		echo $form->input('institucion', array('label'=>array('text'=>'Institución:', 'class'=>'span-3 derecha'), 'class'=>'span-9 last', 'readonly'=>true, 'div'=>array('class'=>'input text span-14 last')));
		
		echo "</div>";
		echo $form->input('name', array('label'=>array('text'=>'Nombre del Evento:', 'class'=>'span-4 derecha'), 'class'=>'span-18', 'readonly'=>true, 'div'=>array('class'=>'input text span-24 last', 'style'=>'height: 43px')));
		echo $form->input('nivel', array('label'=>array('text'=>'Nivel:', 'class'=>'span-4 derecha'), 'options'=>array(1=>'Nacional', 2=>'Internacional'), 'class'=>'span-6 last', 'disabled'=>true, 'div'=>array('class'=>'input text span-10', 'style'=>'height: 43px')));
		echo $form->input('descripcion', array('label'=>array('text'=>'Descripción:', 'class'=>'span-3 derecha'), 'class'=>'span-9 last', 'readonly'=>true,'div'=>array('class'=>'input textarea span-12 last')));
	?>
	</div>
	<div id="ubicacion">
	<?php
		echo "<br/>";
		echo "<div class='span-24 last'>";
		echo $form->input('fecha_desde', array('type'=>'text', 'label'=>array('text'=>'Fecha desde:', 'class'=>'span-4 derecha'), 'id'=>'fecha_desde', 'class'=>'span-6', 'div'=>array('class'=>'input text span-12'), 'readonly'=>TRUE));
		echo $form->input('fecha_hasta', array('type'=>'text', 'label'=>array('text'=>'Fecha hasta:', 'class'=>'span-4 derecha'), 'id'=>'fecha_hasta', 'class'=>'span-6', 'div'=>array('class'=>'input text span-12 last'), 'readonly'=>TRUE));
		echo "</div>";
		echo "<div class='span-24 last'>";
		echo $form->input('pais_id', array('label'=>array('text'=>'Pais:', 'class'=>'span-4 derecha'), 'class'=>'span-6 last', 'div'=>array('class'=>'input select span-12'), 'disabled'=>TRUE));
		echo $form->input('estado_id', array('label'=>array('text'=>'Estado:', 'class'=>'span-4 derecha'), 'class'=>'span-6 last', 'div'=>array('class'=>'input select span-12 last'), 'empty'=>'Seleccione...', 'selected'=>$this->data['Evento']['estado_id'], 'disabled'=>TRUE));
		echo "</div>";
		echo $form->input('direccion', array('label'=>array('text'=>'Dirección:', 'class'=>'span-4 derecha'), 'class'=>'span-18 last', 'div'=>array('class'=>'input textarea span-24 last'), 'readonly'=>TRUE));
	?>
	</div>
	
	<div id="personal">
	<?php
		if(isset($creador) && $creador){
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
				    'url'=> array('controller'=>'Eventos', 'action'=>'add_usuario_evento', $value=$id), 
				    'update' => array('personal'),
				    'condition' => null, // '$("#campo1").val() == $("#campo2").val()'
				    'confirm' => null,
				    'indicator' => null,
				    'before' => null // '$("#post2").html("Wait a moment")'
				    ));
				//echo $form->end(array('div'=>array('class'=>'submit span-2 last'), 'label'=>'Agregar'));
			echo "</div>";
		}
		
		echo "<br/><h3>Listado del personal asistente al evento:</h3>";
		
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
					if(isset($creador) && $creador){
					echo $ajax->link(
						$html->image('material_delete.png', array('width'=>'28')), 
						array( 'controller'=>'Eventos', 'action'=>'evento_personal_delete', $value=$eventos_usuario['EventosUsuario']['id']), 
						array( 'update' => array('personal'), 'escape'=>false, 'confirm' =>null, 'indicator'=>null ) 
					);
					}
					?>
					</td>
				</tr>
			<?	
				}
			?>
		</table>
		</div>
	</div>
<?php
	$evento_id = $this->data['Evento']['id'];
	echo $form->end();
?>
	<div id="materiales">
		
		<?php
			if(isset($creador) && $creador){
		?>
		<label for="link_material">
		<?php
		//pr($this->data);
		echo $html->link(
			$title = $html->image('material_add.png', array('width'=>56)),
			$url = "#archivos",
			$options = array ('alt'=>null, 'escape'=>false, 'id'=>'link_material', 'title'=>'Agregar Material del Evento'),
			$confirmMessage = false
		);
		?>
		</label>
		<?php
			}
			echo "<br/><h3>Listado de materiales:</h3>";
		?>
		<?php
			//pr($materiales);
		?>
		<table>
			<thead>
			<tr>
				<th><?php echo $paginator->sort('Nro.','id');?></th>
				<th width="30%"><?php echo $paginator->sort('Titulo','title');?></th>
				<th width="20%"><?php echo $paginator->sort('Autor','autor');?></th>
				<th><?php echo $paginator->sort('Fecha','fecha');?></th>
				<th><?php echo $paginator->sort('Tipo','type');?></th>
				<th width="120px">Acciones</th>
			</tr>
			</thead>
			<?php
				$i=0;
				foreach($materiales as $material){
				if($i++ % 2 != 0) $class = "class='altrow'";
				else $class = "";
			?>
			<tr>
				<td <?php echo $class; ?> ><?= $material['Material']['id']; ?></td>
				<td <?php echo $class; ?> ><?= $material['Material']['title']; ?></td>
				<td <?php echo $class; ?> >
				<? 
					if(!empty($material['Material']['usuario_id'])){
						echo $material['Usuario']['name'];
					}else{
						echo $material['Material']['autor'];
					}
					 
				?>
				</td>
				<td <?php echo $class; ?> ><?= turnFecha($material['Material']['fecha']); ?></td>
				<td <?php echo $class; ?> ><?= getExtension($material['Material']['name']); ?></td>
				<td <?php echo $class; ?> >
					<?php 
					echo $html->link(
						$title = $html->image('material_info.png', array('width'=>'28')),
						$url = array('controller'=>'Materiales', 'action'=>'view', $material['Material']['id']),
						$options = array ('alt'=>null, 'escape'=>false, 'id'=>null, 'class'=>'info', 'title'=>'Información del Material'),
						$confirmMessage = false
					);
					if(isset($creador) && $creador){
						echo $html->link(
							$title = $html->image('material_edit.png', array('width'=>'28')),
							$url = array('controller'=>'Materiales', 'action'=>'edit', $material['Material']['id']),
							$options = array ('alt'=>null, 'escape'=>false, 'id'=>null, 'class'=>'edit', 'title'=>'Editar Material'),
							$confirmMessage = false
						);
						echo $html->link(
							$title = $html->image('material_delete.png', array('width'=>'28')),
							$url = array('controller'=>'Materiales', 'action'=>'delete', $material['Material']['id']),
							$options = array ('alt'=>null, 'escape'=>false, 'id'=>null, 'title'=>'Eliminar'),
							$confirmMessage = "¿Estas seguro de querer eliminar este archivo del sistema?"
						);
					}
					echo $html->link(
						$title = $html->image('download.png', array('width'=>'28')),
						$url = array('controller'=>'Materiales', 'action'=>'download', $material['Material']['id']),
						$options = array ('alt'=>null, 'escape'=>false, 'id'=>null, 'title'=>'Descargar'),
						$confirmMessage = false
					);
					?>
				</td>
			<?php
				}
			?>
			</tr>
		</table>
<div class="paging">
	<?php
		$this->Paginator->options(array(
 		'update' => '#content',
 		'evalScripts' => true,
		'before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),
		'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))
 		));
	?>
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
		
	</div>
</div>
<div id="archivos" class="invisible span-11 last" style="height: 400px;">
	<ul>
		<li><a href="#info_archivo">Datos del Material</a></li>
		<li><a href="#info_autor">Datos del autor</a></li>
	</ul>
	<div id="info_archivo">
	<?
		echo $form->create('Material', array('enctype' => 'multipart/form-data', 'action'=>'add'));
		//echo $form->input('id', array('type'=>'hidden'));
		echo "<br/>";
		echo "<span class='nota'>El tamaño maximo permitido del archivo es de 8 Mb.</span>";
		echo $form->input('archivo', array('label'=>array('text'=>'Archivo:', 'class'=>'span-2 derecha'),'between'=>'','type'=>'file', 'class'=>'span-8 last', 'div'=>array('class'=>'input file span-10 last')));
		
		echo $form->input('title', array('label'=>array('text'=>'Titulo:', 'class'=>'span-2 derecha'), 'class'=>'span-8 last', 'div'=>array('class'=>'input text span-10 last')));
		echo $form->input('descripcion', array('label'=>array('text'=>'Descripción:', 'class'=>'span-2 derecha'), 'class'=>'span-8 last', 'div'=>array('class'=>'input text span-10 last')));
		echo $form->input('etiquetas', array('label'=>array('text'=>'Palabras clave:', 'class'=>'span-2 derecha'), 'class'=>'span-8 last', 'div'=>array('class'=>'input text span-10 last')));
		echo $form->input('evento_id', array('type'=>'hidden', 'value'=>$evento_id));
		
	?>
	</div>
	<div id="info_autor">
		<?php
			echo "<br/>";
			echo $form->input('pertenece_instituto', array('label'=>array('text'=>'¿El autor Pertenece al instituto?', 'class'=>'span-6')));
			echo "<br/>";
		?>
		<div id="autor_local" class="invisible" style="height: 239px;">
			<?
				echo $form->input('usuario_id', array('options'=>$personal_completo, 'label'=>array('text'=>'Nombre:', 'class'=>'span-2 derecha'), 'class'=>'span-8 last', 'empty'=>'Seleccione...', 'div'=>array('class'=>'input select span-10 last')));
			?>
			<br />
		</div>
		<div id="autor_foraneo" style="height: 239px;">
		<?php
			echo $form->input('autor', array('label'=>array('text'=>'Nombre:', 'class'=>'span-2 derecha'), 'class'=>'span-8 last', 'div'=>array('class'=>'input text span-10 last')));
			echo "<br/>";echo "<br/>";
			echo $form->input('autor_tlf', array('label'=>array('text'=>'Teléfono:', 'class'=>'span-2 derecha'), 'class'=>'span-8 last', 'div'=>array('class'=>'input text span-10 last')));
			echo "<br/>";echo "<br/>";
			echo $form->input('autor_email', array('label'=>array('text'=>'Email:', 'class'=>'span-2 derecha'), 'class'=>'span-8 last', 'div'=>array('class'=>'input text span-10 last')));
			echo "<br/>";echo "<br/>";
		?>
		</div>
	</div>
	<?
		echo $form->end('Guardar');
	?>
</div>
<?php echo $this->Js->writeBuffer(); ?>