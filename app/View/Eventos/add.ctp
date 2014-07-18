<script>
	$('#mce').addClass('current');
	$(document).ready(function() {
		
		//alert("hola1");
		$("#eventos").tabs({
			disabled: [2,3],		
			collapsible: true
 		});

		$("#fecha_desde").datepicker({
			inline: true,
			changeYear: true,
			changeMonth: true,
			maxDate: '+0D',
			minDate: '-20Y'
		});
		$("#fecha_hasta").datepicker({
			inline: true,
			changeYear: true,
			changeMonth: true,
			maxDate: '+0D',
			minDate: '-20Y'
		});
	});
</script>
<h2>Registrar evento</h2>
<div class="eventos form span-24 last" id="eventos">
    	<ul>
			<li><a href="#datos">Información del Evento</a></li>
			<li><a href="#ubicacion">Ubicación</a></li>
			<li><a href="#personal">Personal</a></li>
			<li><a href="#materiales">Listado de Documentos</a></li>
		</ul>
<?php echo $form->create('Evento');?>
	<div id="datos">
	<?php
		//echo $this->Session->read('Auth.Usuario.id');
		echo $form->input('id');
		echo "<br/>";
		echo "<div class='span-24'>";
		echo $form->input('tipo_evento_id', array('label'=>array('text'=>'Tipo de Evento:', 'class'=>'span-4 derecha'), 'empty'=>'Seleccione...', 'class'=>'span-6 last', 'div'=>array('class'=>'input select span-10')));
		echo $form->input('institucion', array('label'=>array('text'=>'Institución:', 'class'=>'span-3 derecha'), 'class'=>'span-9 last', 'div'=>array('class'=>'input text span-14 last')));
		
		echo "</div>";
		echo $form->input('name', array('label'=>array('text'=>'Nombre del Evento:', 'class'=>'span-4 derecha'), 'class'=>'span-18', 'div'=>array('class'=>'input text span-24 last', 'style'=>'height: 43px')));
		echo $form->input('nivel', array('label'=>array('text'=>'Nivel:', 'class'=>'span-4 derecha'), 'options'=>array(1=>'Nacional', 2=>'Internacional'), 'class'=>'span-6 last', 'div'=>array('class'=>'input text span-10', 'style'=>'height: 43px')));
		echo $form->input('descripcion', array('label'=>array('text'=>'Descripción:', 'class'=>'span-3 derecha'), 'class'=>'span-9 last','div'=>array('class'=>'input textarea span-12 last')));
	?>
	</div>
	<div id="ubicacion">
	<?php
		echo "<br/>";
		echo "<div class='span-24 last'>";
		echo $form->input('fecha_desde', array('type'=>'text', 'label'=>array('text'=>'Fecha desde:', 'class'=>'span-4 derecha'), 'id'=>'fecha_desde', 'class'=>'span-6', 'div'=>array('class'=>'input text span-12')));
		echo $form->input('fecha_hasta', array('type'=>'text', 'label'=>array('text'=>'Fecha hasta:', 'class'=>'span-4 derecha'), 'id'=>'fecha_hasta', 'class'=>'span-6', 'div'=>array('class'=>'input text span-12 last')));
		echo "</div>";
		echo "<div class='span-24 last'>";
		echo $form->input('pais_id', array('label'=>array('text'=>'Pais:', 'class'=>'span-4 derecha'), 'class'=>'span-6 last', 'selected'=>232, 'div'=>array('class'=>'input select span-12')));
		echo $ajax->observeField('EventoPaisId', 
		    array(
		        'url' => array('controller'=>'Estados', 'action' =>'getEstados', $value=null ),
		        'update'=>'div_estados'
		    )
		);
		echo "<div id='div_estados'>";
		echo $form->input('estado_id', array('label'=>array('text'=>'Estado:', 'class'=>'span-4 derecha'), 'class'=>'span-6 last', 'empty'=>'Seleccione...', 'div'=>array('class'=>'input select span-12 last')));
		echo "</div>";
		echo "</div>";
		echo $form->input('direccion', array('label'=>array('text'=>'Dirección:', 'class'=>'span-4 derecha'), 'class'=>'span-18 last', 'div'=>array('class'=>'input textarea span-24 last')));
	?>
	</div>
	<div id="personal">
	<?php
		echo "<br/>";
		echo "<div class='span-24 last'>";
		echo $form->input('personal_id', array('options'=>$personal, 'selected'=>$session->read('Auth.Usuario.id'), 'label'=>array('text'=>'Nombre del personal:', 'class'=>'span-4 derecha'), 'class'=>'span-6 last', 'empty'=>'Seleccione...', 'div'=>array('class'=>'input select span-10')));
		echo "<label class='span-4 derecha'>Asistio al evento como: </label>";
		echo "<div class='span-3'>";
		echo $form->input('participante', array('checked'=>TRUE, 'between'=>' '));
		echo "</div>";
		echo "<div class='span-3'>";
		echo $form->input('ponente', array('between'=>' '));
		echo "</div>";
		echo $form->end(array('div'=>array('class'=>'submit span-2 last'), 'label'=>'Agregar'));
		echo "</div>";
		echo "<div class='span-24 last' style='height:132px'>&nbsp;</div>";
	?>
	</div>
	<div id="materiales"></div>
<?php
	echo $form->end(array('div'=>array('class'=>'submit span-4'), 'label'=>'Registrar evento'));
?>
<div id="materia"></div>
</div>
