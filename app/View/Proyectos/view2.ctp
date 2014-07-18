<?php
$proyecto = $proyecto[0];
$nombre = $proyecto['Proyecto']['name'];
$fechaInicio = turnFecha($proyecto['Proyecto']['fecha_inicio'], 2);
$fechaFin = turnFecha($proyecto['Proyecto']['fecha_culminacion'], 2);
$intervalo_meses = date('n', strtotime($fechaFin)- strtotime($fechaInicio));
//echo $intervalo_meses;
$categoriasX = array();
for ($i=0; $i < $intervalo_meses; $i++) { 
	array_push($categoriasX, date('m/Y', strtotime($fechaInicio." + $i month")));	
}
$categoriasX =  json_encode($categoriasX);
?>
<div class="row">
<h1>Proyecto: <?= $nombre ?></h1>
	<?php
		$this->Form->create('Proyecto');
		//pr($proyecto);
		echo $this->Form->input('objetivoGeneral', array('label'=>array('text'=>'Objetivo general: ', 'class'=>'span-5 derecha'), 'class'=>'span-14 last', 'div'=>array('class'=>'span-24 last'), 'readonly'=>true, 'value'=>$proyecto['Proyecto']['objetivoGeneral']));
		echo $this->Form->input('cliente', array('label'=>array('text'=>'Cliente: ', 'class'=>'span-5 derecha'), 'class'=>'span-14 last', 'div'=>array('class'=>'span-24 last'), 'readonly'=>true, 'value'=>$proyecto['Proyecto']['cliente']));
		echo $this->Form->input('fecha_inicio', array('label'=>array('text'=>'Fecha de inicio: ', 'class'=>'span-5 derecha'), 'type'=>'text', 'class'=>'span-5 last', 'div'=>array('class'=>'span-10'), 
			'readonly'=>true, 'value'=>$proyecto['Proyecto']['fecha_inicio']));
		echo $this->Form->input('fecha_culminacion', array('label'=>array('text'=>'Fecha de culminación: ', 'class'=>'span-4 derecha'), 'type'=>'text', 'class'=>'span-5 last', 'div'=>array('class'=>'span-12 last'), 
			'readonly'=>true, 'value'=>$proyecto['Proyecto']['fecha_culminacion'])
		);
		echo $this->Form->input('coordinadorName', array('label'=>array('text'=>'Coordinador: ', 'class'=>'span-5 derecha'), 'readonly'=>true, 'type'=>'text', 'class'=>'span-12 last', 'div'=>array('class'=>'span-18', 'id'=>'divCoord'), 'readonly'=>true, 'value'=>$proyecto['Usuario']['fullname']));
		echo $this->Form->input('coordinador_id', array('label'=>null, 'type'=>'hidden', 'value'=>$proyecto['Proyecto']['coordinador_id']));
		echo $this->Form->input('codigo', array('label'=>array('text'=>'Código: ', 'class'=>'span-5 derecha'), 'type'=>'text', 'class'=>'span-5 last', 'div'=>array('class'=>'span-10'),
			'readonly'=>true, 'value'=>$proyecto['Proyecto']['codigo']
		));
		echo $this->Form->input('presupuesto', array('label'=>array('text'=>'Presupuesto: Bs.', 'class'=>'span-4 derecha'), 'type'=>'text', 'class'=>'span-5 last', 'div'=>array('class'=>'span-12 last'),
			'readonly'=>true, 'value'=>$proyecto['Proyecto']['presupuesto']
		));
		$statusOpc = array(1=>'Activo', 2=>'Inactivo', 3=>'Culminado', 4=>'Cancelado');
		echo $this->Form->input('status', array('label'=>array('text'=>'Status: ', 'class'=>'span-5 derecha'), 'options'=>$statusOpc, 'empty'=>'Seleccione...', 'class'=>'span-5 last', 'div'=>array('class'=>'span-24 last'), 
	    	'disabled'=>true, 'selected'=>$proyecto['Proyecto']['status']));
		
	?>
</div>
<!-- MANEJO DE ARCHIVOS	!-->
<div>
	<h2>Archivos</h2>
	<span><?= $this->Html->link('Subir archivo', "#uploader"); ?></span>
<table>
	<thead>
	<tr>
		<th width='80px'>Tipo archivo</th>
		<th>Nombre</th>
		<th width='100px'>Acciones</th>
	</tr>
	</thead>
</table>
</div>
<div id="uploader" class='invisible'>
	<?= $this->Element('uploader') ?>
</div>
<!-- FIN DEL MANEJO DE ARCHIVOS	!-->
<div class="objesp">
<h2>
	Objetivos especificos
	<?= $this->Html->link('Agregar', array('controller'=>'Objetivos', 'action'=>'add', $proyecto['Proyecto']['id']), array('id'=>'linkObj')) ?>
</h2>
</div>

<?php
//pr($proyecto);
$i=0;
$acu_culminado = 0;
if(!empty($proyecto['Objetivo'])){
foreach($proyecto['Objetivo'] as $objetivo){
	//pr($objetivo);
	$objEspecifico = $objetivo['descripcion'];
	$actividades = $objetivo['Actividad'];
?>
<div>
	<span class='span-2'><b>Nro.</b></span>
	<span class='span-18'><b>Descripción</b></span>
	<span class='span-3 last'><b>Acciones</b></span>
	
	<span class='span-2'><?= $i + 1 ?></span>
	<span class='span-18'><?= $objEspecifico ?></span>
	<span class='span-3 last'>
		<?= $this->Html->link($this->Html->image("action_edit.png", array("width"=>"24", 'alt'=>'Editar')), 
			array('controller'=>'Objetivos', 'action'=>'edit', $objetivo['id']), array("confirm"=>null, "indicator"=>null, 'class'=>'edit_obj', "escape"=>false)); ?>
		<?= $this->Html->link($this->Html->image("action_delete.png", array("width"=>"24", 'alt'=>'Eliminar')), 
			array('controller'=>'Objetivos','action'=>'delete', $objetivo['id'], $objetivo['proyecto_id']), array("confirm"=>"Estas seguro de eliminar este objetivo?", "indicator"=>null, "escape"=>false));?>
		
	</span>
<div>
	<span ><span style="font-size: 120%; font-weight: bold;">Actividades</span> -
		<?= $this->Html->link('Agregar', array('controller'=>'Actividades', 'action'=>'add', $proyecto['Proyecto']['id'], $objetivo['id']), array('class'=>'linkActividades')) ?>
	</span>
<?php
	if(!empty($actividades)){
?>
<table class="span-23 last">
<thead>
	<tr>
		<th width='33%'><b>Nombre</b></th>
		<th width='33%'><b>Producto</b></th>
		<th><b>Inicio</b></th>
		<th><b>Culminación</b></th>
		<th width='34%'><b>Responsable</b></th>
		<th><b>Peso (%)</b></th>
		<th><b>Acciones</b></th>
	</tr>
</thead>
<?php
	$j = 0;
	$pesos = array();
	$culminados =  $culminadoObj = array();
	$responsables = array();
	//pr($actividades);
	foreach($actividades as $actividad){
		$peso = $actividad['peso'];
		$culminado = 0;
		foreach ($actividad['Avance'] as $fila) {
			//pr($fila);
			$culminado += $fila['porcentaje'];
		}
		$responsable = $actividad['Usuario']['fullname'];
		array_push($pesos, $peso);
		$culminado_real = ($culminado * $peso)/100;
		$acu_culminado += $culminado_real;
		array_push($culminados, $culminado_real);
		array_push($culminadoObj, $culminado);
		array_push($responsables, $responsable); 
?>	
	<tr>
		<td><?= $actividad['nombre'] ?></td>
		<td><?= $actividad['producto'] ?></td>
		<td><?php if(!empty($actividad['fecha_inicio'])) echo $actividad['fecha_inicio'] ?></td>
		<td><?php if(!empty($actividad['fecha_inicio'])) echo $actividad['fecha_culminacion'] ?></td>
		<td><?= $responsable ?></td>
		<td><?= $actividad['peso'] ?></td>
		<td>
		<?= $this->Html->link($this->Html->image("action_edit.png", array("width"=>"24", 'alt'=>'Editar')), 
			array('controller'=>'Actividades', 'action'=>'edit', $actividad['id']), array("confirm"=>null, "indicator"=>null, 'class'=>'edit_obj', "escape"=>false)); ?>
		<?= $this->Html->link($this->Html->image("action_delete.png", array("width"=>"24", 'alt'=>'Eliminar')), 
			array('controller'=>'Actividades','action'=>'delete', $actividad['id'], $objetivo['proyecto_id']), array("confirm"=>"Estas seguro de eliminar esta actividad?", "indicator"=>null, "escape"=>false));?>
		</td>
	</tr>
<?php
	$j++;
	}//fin foreach actividades
	}
?>
</table>
 
</div>
</div>

<?php //comienzo a crear los graficos
if(!empty($actividades)){//valido que existan actividades
	$i++;
echo "<div class='span-23 last invisible' id='objetivo".$objetivo['id']."'>";
	echo "<div style='margin-left:5px;' class='span-23 last'>";
	echo "<h3>Progreso de las Actividades</h3>";
	echo $this->Html->image("../graficos/objetivo".$objetivo['id'].".png");
	echo "</div>";
	echo "<div style='margin-left:5px;' class='span-23 last'>";
	echo "<h3>Progreso del Objetivo: ";
	echo $this->Html->image("../graficos/progresoObj".$objetivo['id'].".png")."</h3>";
	echo "</div>";
echo "</div>";
}//fin de la validacion $actividades
}//fin foreach objetivos

if(!empty($actividades)){
?>
<div id="graficoProyecto" class='span-18 invisible'>
</div>
<?php
} 
} 
?>
<div class="actions">
	<ul>
		<li><?= $this->Html->link($this->Html->image("home.png", array("width"=>"48", 'alt'=>'Proyectos')), 
			"/", 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("project-plan.png", array("width"=>"48", 'alt'=>'Proyectos')), 
			array( "controller"=>"Proyectos", "action"=>"index"), 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("action_edit.png", array("width"=>"48", 'alt'=>'Editar')), 
				array('controller'=>'Proyectos', 'action'=>'edit', $proyecto['Proyecto']['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false));
			?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("action_delete.png", array("width"=>"48", 'alt'=>'Eliminar')), 
				array('controller'=>'Actividades','action'=>'delete', $proyecto['Proyecto']['id']), array("confirm"=>"Estas seguro de eliminar esta proyecto?", "indicator"=>null, "escape"=>false));
			?>
		</li>
		<?
		if(!empty($proyecto['Objetivo']) && !empty($actividades)){
		?>
		<li>
			<?= $this->Html->link($this->Html->image("bar-chart.png", array("width"=>"48", 'alt'=>'Proyectos')), 
			"#graficoProyecto", 
			array("confirm"=>null, "indicator"=>null, "escape"=>false, 'id'=>'lnkPorcentaje')); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("porcentaje.png", array("width"=>"48", 'alt'=>'Proyectos')), 
			array( "controller"=>"Proyectos", "action"=>"edit_porcentaje", $proyecto['Proyecto']['id']), 
			array("confirm"=>null, "indicator"=>null, "escape"=>false, 'id'=>'ePorcentaje')); ?>
		</li>
		<?
		}
		?>
	</ul>
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
    
    //graficos
    $('#graficoProyecto').highcharts({
            title: {
                text: 'Avance del proyecto: <?= $nombre ?>',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: <?= $categoriasX ?>
            },
            yAxis: {
                title: {
                    text: 'Porcentaje Culminado'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '%'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Estimado',
                data: [20, 50, 80, 100]
            }, {
                name: 'Avance',
                data: [10, 20, ]
            }, 
            ]
        });

});
</script>