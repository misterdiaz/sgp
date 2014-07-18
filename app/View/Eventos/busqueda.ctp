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
//pr($session);
if(!$session->check('paginator.condicion')){
	$condicion = $this->params['paging']['Evento']['defaults']['conditions'];
	$_SESSION['paginator']['condicion']=$condicion;
}
//pr($_SESSION['paginator']['condicion']);
?>

<script>
	$('#mce').addClass('current');
	$(document).ready(function() {
		var data= ["FII", "gvSIG"];
		$('#EventoInstitucion').autocomplete({
			source: <? echo $javascript->object($institucion, array('q'=>'[')); ?>
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
<h2>Busqueda Avanzada de Eventos</h2>
<?= $form->create('Evento', array('action'=>'busqueda')) ?>
<div class="span-24 last">
<?= $form->input('institucion', array('label'=>array('text'=>'Institución donde se realizo el evento:', 'class'=>'span-4 derecha'), 'class'=>'span-12', 'div'=>array('class'=>"input text span-16") ) );?>
<div class="span-6 last nota">Ingrese parte del nombre y el sistema le mostrara todas las opciones disponibles.</div>
</div>
<div class="span-24 last">
	<?= $form->input("tipo_evento_id", array('label'=>array('text'=>'Tipo de evento:', 'class'=>'span-4 derecha'), 'class'=>'span-6 last', 'empty'=>'Cualquiera...', 'div'=>array('class'=>"input select span-12") ) );?>
	<?= $form->input("nacionalidad", array('options'=>array(1=>'Nacional', 2=>'Internacional'), 'label'=>array('text'=>'Origen del evento:', 'class'=>'span-4 derecha'), 'class'=>'span-6', 'empty'=>'Cualquiera...', 'div'=>array('class'=>"input select span-12 last") ) );?>
</div>
<div class="span-24 last">
<? echo $form->input("usuario_id", array('label'=>array('text'=>"Personal que asistio al evento:", 'class'=>'span-4 derecha'), 'options'=>null, 'empty'=>'Seleccione...', 'class'=>'span-6 last', 'div'=>array('class'=>'input select span-10') ) ); ?>
</div>
<fieldset class="span-22">
<legend  id="param_fecha">Incluir un rango de fecha a la busqueda</legend>
<br/>
<div id="data_fecha">
	<? echo $form->input('fecha_desde', array('type'=>'text', 'label'=>array('text'=>'Fecha desde:', 'class'=>'span-4 derecha'), 'id'=>'fecha_desde', 'class'=>'span-6 last', 'div'=>array('class'=>"input text span-10"), 'autocomplete'=>'off')); ?>
	<? echo $form->input('fecha_hasta', array('type'=>'text', 'label'=>array('text'=>'Fecha hasta:', 'class'=>'span-4 derecha'), 'id'=>'fecha_hasta', 'class'=>'span-6 last', 'div'=>array('class'=>"input text span-10 last"), 'autocomplete'=>'off')); ?>
</div>
</fieldset>
<?= $form->end(array('label'=>'Buscar', 'div'=>array('class'=>'submit span-24 last', 'style'=>'margin-left:20px;'))) ?>
<div class="span-24">
<div class="break"></div>
</div>
<h2>Eventos</h2>
<? 
	if(!empty($eventos)){
?>
<div>
<table cellpadding="0" cellspacing="0">
<tr>
	<thead>
		<th width="50px"><?php echo $paginator->sort('Nro.','id');?></th>
		<th><?php echo $paginator->sort('Nombre','name');?></th>
		<th><?php echo $paginator->sort('Institución','institucion');?></th>
		<th><?php echo $paginator->sort('Tipo de Evento','tipo_evento_id');?></th>
		<th><?php echo $paginator->sort('Pais','pais_id');?></th>
		<th><?php echo $paginator->sort('estado_id');?></th>
		<th class="actions" width="100px"><?php __('Acciones');?></th>
	</thead>
</tr>
<?php
$i = 0;
//pr($eventos);
foreach ($eventos as $evento):
	$class = null;
	$class2 = "class=''";
	if ($i++ % 2 != 0) {
		$class = ' class="altrow"';
		$class2 = "class=' altrow'";
	}
?>
	<tr>
		<td <?php echo $class;?>>
			<?php echo $evento['Evento']['id']; ?>
		</td>
		<td <?php echo $class;?>>
			<?php echo $evento['Evento']['name']; ?>
		</td>
		<td <?php echo $class;?>>
			<?php echo $evento['Evento']['institucion']; ?>
		</td>
		<td <?php echo $class;?>>
			<?php echo $html->link($evento['TipoEvento']['title'], array('controller'=> 'tipo_eventos', 'action'=>'view', $evento['TipoEvento']['id'])); ?>
		</td>
		<td <?php echo $class;?>>
			<?php echo $html->link($evento['Paises']['name'], array('controller'=> 'paises', 'action'=>'view', $evento['Paises']['id'])); ?>
		</td>
		<td <?php echo $class;?>>
			<?php echo $html->link($evento['Estado']['name'], array('controller'=> 'estados', 'action'=>'view', $evento['Estado']['id'])); ?>
		</td>
		<td  <?php echo $class2;?> class="actions">
			<?php echo $html->link($html->image('material_info.png', array('width'=>'28')), array('action'=>'view', $evento['Evento']['id']), array('escape'=>FALSE)); ?>
			<?php echo $html->link($html->image('material_edit.png', array('width'=>'28')), array('action'=>'edit', $evento['Evento']['id']), array('class'=>'edit', 'escape'=>FALSE)); ?>
			<?php echo $html->link($html->image('material_delete.png', array('width'=>'28')), array('action'=>'delete', $evento['Evento']['id']), array('escape'=>FALSE), "ADVERTENCIA: Al eliminar este evento tambien eliminaras del sistema todas las carpetas y archivos pertenecientes al mismo. ¿Realmente deseas hacerlo?"); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

	<div class="paging">
		<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $paginator->numbers();?>
		<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
	</div>
</div>
<? 
	}else{
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<thead>
		<th width="50px">Nro.</th>
		<th>Nombre</th>
		<th>Institución</th>
		<th>Tipo de Evento</th>
		<th>Pais</th>
		<th>Estado</th>
		<th class="actions"><?php __('Acciones');?></th>
	</thead>
</tr>
</table>
<? 
	}
?>
<br/>