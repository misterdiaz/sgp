<?php $proyecto = $proyecto;?>
<div class="proyectos form span-24 last">
<h1>Proyecto: <?= $proyecto['name'] ?></h1>
	<?php
		$this->Form->create('Proyecto');
		//pr($proyecto);
		//echo $this->Form->input('name', array('label'=>array('text'=>'Nombre del proyecto: ', 'class'=>'span-5 derecha'), 'class'=>'span-14 last', 'div'=>array('class'=>'span-24 last')));
		echo $this->Form->input('objetivoGeneral', array('label'=>array('text'=>'Objetivo general: ', 'class'=>'span-5 derecha'), 'class'=>'span-14 last', 'div'=>array('class'=>'span-24 last'), 'readonly'=>true, 'value'=>$proyecto['objetivoGeneral']));
		echo $this->Form->input('cliente', array('label'=>array('text'=>'Cliente: ', 'class'=>'span-5 derecha'), 'class'=>'span-14 last', 'div'=>array('class'=>'span-24 last'), 'readonly'=>true, 'value'=>$proyecto['cliente']));
		echo $this->Form->input('fecha_inicio', array('label'=>array('text'=>'Fecha de inicio: ', 'class'=>'span-5 derecha'), 'type'=>'text', 'class'=>'span-5 last', 'div'=>array('class'=>'span-10'), 
			'readonly'=>true, 'value'=>$proyecto['fecha_inicio']
		));
		echo $this->Form->input('fecha_culminacion', array('label'=>array('text'=>'Fecha de culminación: ', 'class'=>'span-4 derecha'), 'type'=>'text', 'class'=>'span-5 last', 'div'=>array('class'=>'span-12 last'), 
			'readonly'=>true, 'value'=>$proyecto['fecha_culminacion']
		));
		echo $this->Form->input('coordinadorName', array('label'=>array('text'=>'Coordinador: ', 'class'=>'span-5 derecha'), 
			'readonly'=>true, 'type'=>'text', 'class'=>'span-12 last', 'div'=>array('class'=>'span-18', 'id'=>'divCoord'), 'readonly'=>true, 'value'=>$fullname));
		$statusOpc = array(1=>'Activo', 2=>'Inactivo', 3=>'Culminado', 4=>'Cancelado');
		echo $this->Form->input('status', array('label'=>array('text'=>'Status: ', 'class'=>'span-5 derecha'), 'options'=>$statusOpc, 'empty'=>'Seleccione...', 'class'=>'span-5 last', 'div'=>array('class'=>'span-24 last'), 'disabled'=>true, 'selected'=>$proyecto['status']));
		
	?>
</div>

<script>
$(document).ready(function() {
	$("#linkObj").fancybox({
        'type' : 'ajax',
        'scrolling': 'no',
        'autoScale': 'true',
        'autoDimensions': 'true'
    });
    $(".edit_obj").fancybox({
        'type' : 'ajax',
        'scrolling': 'no',
        'autoScale': 'true',
        'autoDimensions': 'true'
    });
    
    $('.grafico').fancybox({
        'autoScale': 'true',
        'autoDimensions': 'true'
    });
    $('#lnkPorcentaje').fancybox({
        'autoScale': 'true',
        'autoDimensions': 'true'
    });
    
    /*$('#ePorcentaje').fancybox({
    	'type' : 'ajax',
        'autoScale': 'true',
        'autoDimensions': 'true'
     });*/
    
    $(".linkActividades").fancybox({
        'type': 'ajax',
        //'scrolling': 'no',
        'autoScale': 'true',
        'autoDimensions': 'true'
    });

});
</script>