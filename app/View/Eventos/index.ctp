<script type="text/javascript">
	function getEventos(){
		if(document.getElementById('EventoBusqueda').value != ""){
			document.getElementById('EventoIndexForm').submit();
		}else{
			return false;
		}
		
	}
	// increase the default animation speed to exaggerate the effect
	$.fx.speeds._default = 1000;
	$('#mce').addClass('current');
	$(function() {
		
		$(".view").fancybox();
		
		$('#confirmacion').dialog({
			autoOpen: false,
			show: 'blind',
			hide: 'explode',
			resizable: false,
			draggable: false,
			height:140,
			modal: true,
			buttons: {
				'Delete all items': function() {
					return true;
					$(this).dialog('close');
				},
				Cancel: function() {
					return false;
					$(this).dialog('close');
				}
			}
		});
		
		$('.delete').click(function() {
			//$('#confirmacion').dialog('open');
			return false;
		});
	});
	</script>


<div class="eventos">
<h2><?php __('Eventos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registro(s) de %count% en total, comenzando con el registro %start% y terminando con el %end%.', true)
));
?>
</p>
<div align="left">
<?php
	echo $form->create('Evento', array('action'=>'index')); 
	echo $form->input('busqueda', array('label'=>false, 'class'=>'searchbtn', 'onblur'=>"getEventos();"));
?>
</div>

<table cellpadding="0" cellspacing="0">
<tr>
	<thead>
		<th width="50px"><?php echo $paginator->sort('Nro.','id');?></th>
		<th><?php echo $paginator->sort('Nombre','name');?></th>
		<th><?php echo $paginator->sort('Institución','institucion');?></th>
		<th><?php echo $paginator->sort('Tipo de Evento','tipo_evento_id');?></th>
		<th><?php echo $paginator->sort('Nivel','nivel');?></th>
		<th class="actions"><?php __('Acciones');?></th>
	</thead>
</tr>
<?php
$niveles = array(1=>'Nacional', 2=>'Internacional');
$i = 0;
//pr($eventos);
foreach ($eventos as $evento):
	$class = null;
	$class2 = "class=''";
	if ($i++ % 2 != 0) {
		$class = ' class="altrow"';
		$class2 = "class='altrow'";
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
			<?php echo $niveles[$evento['Evento']['nivel']]; ?>
		</td>
		<td  <?php echo $class2;?> class="actions">
			<?php echo $html->link($html->image('material_info.png', array('width'=>'28', 'title'=>'Ver Información')), array('action'=>'view', $evento['Evento']['id']), array('escape'=>FALSE)); ?>
			<?php echo $html->link($html->image('material_edit.png', array('width'=>'28', 'title'=>'Editar Evento')), array('action'=>'edit', $evento['Evento']['id']), array('class'=>'edit', 'escape'=>FALSE)); ?>
			<?php echo $html->link($html->image('material_delete.png', array('width'=>'28', 'title'=>'Eliminar Evento')), array('action'=>'delete', $evento['Evento']['id']), array('escape'=>FALSE), "ADVERTENCIA: Al eliminar este evento tambien eliminaras del sistema todas las carpetas y archivos pertenecientes al mismo. ¿Realmente deseas hacerlo?"); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div id="confirmacion">Realmente desea eliminar este evento?</div>
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
<?    echo $this->Js->writeBuffer(); ?>