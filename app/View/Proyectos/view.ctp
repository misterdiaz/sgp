<?php
$this->Html->addCrumb('Proyectos', array('controller'=>'Proyectos', 'action'=>'index'));
$this->Html->addCrumb('Ver', array('controller'=>'Proyectos', 'action'=>'view'));
$proyecto = $proyecto[0];
$nombre = $proyecto['Proyecto']['name'];
$objetivoGeneral = $proyecto['Proyecto']['objetivoGeneral'];
$fecha_inicio = $proyecto['Proyecto']['fecha_inicio'];
$fecha_culminacion = $proyecto['Proyecto']['fecha_culminacion'];
$statusOpc = array(1=>'Activo', 2=>'Inactivo', 3=>'Culminado', 4=>'Cancelado');
$fechaInicio = turnFecha($proyecto['Proyecto']['fecha_inicio'], 2);
$fechaFin = turnFecha($proyecto['Proyecto']['fecha_culminacion'], 2);
$intervalo_meses = date('n', strtotime($fechaFin)- strtotime($fechaInicio));
//echo $intervalo_meses;
//pr($proyecto['Objetivo']);
$gantt = array();
$i=0;
foreach ($proyecto['Objetivo'] as $Objetivo) {
  foreach ($Objetivo['Actividad'] as $Actividad) {
    //pr($Actividad);
    $total = 0;
    foreach ($Actividad['Avance'] as $suma) {
      $total += $suma['porcentaje'];
    }
    $c = $i+1;
    $inicioV = explode('/', $Actividad['fecha_inicio']);
    $finV =  explode('/', $Actividad['fecha_culminacion']);
    //pr($inicioV);
    $gantt[$i]['name'] = "Actividad $c";
    $gantt[$i]['nombre'] = $Actividad['nombre'];
    $gantt[$i]['responsable'] = $Actividad['Usuario']['fullname'];
    $gantt[$i]['total'] = $total;
    $intervalo['from'] = mktime(0, 0, 0, $inicioV[1], $inicioV[0], $inicioV[2])*1000;
    $intervalo['to'] = mktime(0, 0, 0, $finV[1], $finV[0], $finV[2])*1000;
    $gantt[$i]['intervals'][] = $intervalo;
    $i++;
  }
  # code...
}
$tasks =  json_encode($gantt);
//pr($tasks);
?>
<h1>Proyecto: <?= $nombre ?></h1>

<?php
	$defaults = array('label'=>false, 'div'=>false);

	echo $this->Form->create('Proyecto', array('class'=>'form-horizontal', 'inputDefaults'=>$defaults));
	$urlObjAdd = $this->Html->url(array("controller"=>"Objetivos", "action"=>"add", $proyecto["Proyecto"]["id"]));

?>
<div class="panel panel-info">
  <div class="panel-heading"><a data-toggle="collapse" href="#informacion">Información general</a></div>
  <ul class="list-group collapse in" id="informacion">
  	<li class="list-group-item">
  		<strong>Objetivo General: </strong>	<?= $objetivoGeneral ?>
  	</li>
    <li class="list-group-item">
    	<strong>Fecha de inicio: </strong> <?= $fecha_inicio ?>
    </li>
    <li class="list-group-item">
    	<strong>Fecha de culminación: </strong> <?= $fecha_culminacion ?>
    </li>
    <li class="list-group-item">
    	<strong>Coordinador: </strong> <?= $proyecto['Usuario']['fullname'] ?>
    </li>
    <li class="list-group-item">
    	<strong>Código: </strong> <?= $proyecto['Proyecto']['codigo'] ?>
    </li>
    <li class="list-group-item">
    	<strong>Presupuesto: </strong> Bs. <?= $proyecto['Proyecto']['presupuesto'] ?>
    </li>
    <li class="list-group-item">
    	<strong>Status: </strong> <?= $statusOpc[$proyecto['Proyecto']['status']] ?>
    </li>
  </ul>
</div>

<!-- MANEJO DE ARCHIVOS !-->
<div class="panel panel-info">
  <div class="panel-heading">
  Archivos <button type="button" class="btn btn-default btn-sm " data-toggle='modal' data-target="#uploader">Agregar <span class="glyphicon glyphicon-plus-sign"></span></button>
  </div>
  <div class="panel-body"> </div>
</div>

<div class="modal fade" id="uploader">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Subir archivos</h4>
      </div>
      <div class="modal-body">
        <?= $this->Element('uploader') ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- FIN DEL MANEJO DE ARCHIVOS !-->

<div class="panel panel-info">
  <div class="panel-heading">
  	<a data-toggle="collapse" href="#objetivos">Objetivos especificos</a>
	  <a class="btn btn-default btn-sm" href='<?= $urlObjAdd?>'>
	  	Agregar <span class="glyphicon glyphicon-plus-sign"></span>
	  </a>
  </div>
  <div id="objetivos" class="collapse">
  <?
  $i = 0;
  if(!empty($proyecto['Objetivo'])):
  	foreach($proyecto['Objetivo'] as $objetivo){
  		$objEspecifico = $objetivo['descripcion'];
		$actividades = $objetivo['Actividad'];
		$urlActAdd = $this->Html->url(array('controller'=>'Actividades', 'action'=>'add', $proyecto['Proyecto']['id'], $objetivo['id']));
  ?>
  <table class="table table-bordered table-responsive">
  	<thead>
  		<tr class='success'>
  			<th>Nro.</th>
  			<th>Descripción</th>
  			<th width="8%">Acciones</th>
  		</tr>
  	</thead>
  	<tbody>
  		<tr>
  			<td><?= $i + 1 ?></td>
  			<td><?= $objEspecifico ?></td>
  			<td class='actions'>
  			<?php 

          echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>',
					  array('controller'=>'Objetivos', 'action'=>'edit', $objetivo['id']), array("confirm"=>null, "indicator"=>null, "escape"=>false,
              "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Editar objetivo especifico"
             ));

				echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',
			    array('controller'=>'Objetivos', 'action'=>'delete', $objetivo['id'], $objetivo['proyecto_id']), array("confirm"=>"Estas seguro de eliminar este objetivo y sus actividades? ", "indicator"=>null, "escape"=>false, 
            "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Eliminar objetivo especifico" )); 
        ?>
  			</td>
  		</tr>
  	</tbody>
  </table>
<div class="panel panel-warning">
  <div class="panel-heading">Actividades
  	<a data-toggle="modal" href="<?= $urlActAdd ?>" class='btn btn-default btn-sm'>
		Agregar <span class="glyphicon glyphicon-plus-sign"></span>
	</a>
  </div>
  <table class='table table-bordered table-responsive'>
  	<thead>
  		<th>Nombre</th>
  		<th>Producto</th>
  		<th>Inicio</th>
  		<th>Culminación</th>
  		<th>Responsable</th>
  		<th>Peso</th>
  		<th width='8%'>Acciones</th>
  	</thead>
  	<?php
  		if(!empty($actividades)):
  			foreach($actividades as $actividad):
  				$nombre = $actividad['nombre'];
  				$producto = $actividad['producto'];
  				if(!empty($actividad['fecha_inicio'])) $inicio_actividad = $actividad['fecha_inicio'];
  				else $inicio_actividad = "";
  				if(!empty($actividad['fecha_culminacion'])) $fin_actividad = $actividad['fecha_culminacion'];
  				else $fin_actividad = "";
  				$responsable = $actividad['Usuario']['fullname'];
  				$peso = $actividad['peso'];

  	?>
  	<tbody>
  		<tr>
  			<td><?= $nombre ?></td>
  			<td> <?= $producto ?> </td>
  			<td> <?= $inicio_actividad ?> </td>
  			<td> <?= $fin_actividad ?> </td>
  			<td> <?= $responsable ?></td>
  			<td> <?= $peso ?></td>
  			<td class='actions'>
  				<?php
            echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>',
					  array('controller'=>'Actividades', 'action'=>'edit', $actividad['id'], $objetivo['proyecto_id']), array("confirm"=>null, "indicator"=>null, 'class'=>'edit_obj', "escape"=>false, "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Editar actividad"));

				    echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>',
					    array('controller'=>'Actividades','action'=>'delete', $actividad['id'], $objetivo['proyecto_id']), 
              array("confirm"=>"Estas seguro de eliminar esta actividad?", "indicator"=>null, "escape"=>false,
              "data-toggle"=>"tooltip", "data-placement"=>"top", "title"=>"Eliminar actividad"));
          ?>
  			</td>
  		</tr>
  	</tbody>
  	<?php
  			endforeach;
  		endif;
  	?>
  </table>
</div>
<? 
		$i++;
	}//end foreach
endif;
?>
 </div>
</div>

<div class="panel panel-info">
  <div class="panel-heading"><a data-toggle="collapse" href="#estadisticas">Gráficos</a></div>
  <ul class="list-group collapse in" id="estadisticas">
  	<li class="list-group-item" id="gantt" style='width:100%'>
  		
  	</li>
  </ul> 
</div>

<div class="btn-group">
	<?php
		echo $this->Html->link('Editar <span class="glyphicon glyphicon-edit"></span>', 
			array('controller'=>'Proyectos', 'action'=>'edit', $proyecto['Proyecto']['id']), array('class'=>'btn btn-default', 'escape'=>false));

		echo $this->Html->link('Eliminar <span class="glyphicon glyphicon-trash"></span>', 
			array('controller'=>'Proyectos', 'action'=>'delete', $proyecto['Proyecto']['id']), array('class'=>'btn btn-default', 'escape'=>false, "confirm"=>"Estas seguro de eliminar esta proyecto?"));

		echo $this->Html->link('Descargar PDF <span class="glyphicon glyphicon-save"></span>', 
			array('controller'=>'Proyectos', 'action'=>'resumenPdf', 1, $proyecto['Proyecto']['id']), array('class'=>'btn btn-default', 'escape'=>false));
	?>	
</div>

<script>
$(document).ready(function() {
	$("#liProyectos").addClass('active');
	$("#ulProyectos").addClass('in');
	$("#lnk_proyectos").addClass('current');
  $('.actions a').tooltip();
  $().alert()
});
</script>
<script type="text/javascript">
// Define tasks
var tasks = <?= $tasks ?>;

// re-structure the tasks into line seriesvar series = [];
var series = [];
$.each(tasks.reverse(), function(i, task) {
    var item = {
        name: task.name,
        data: []
    };
    $.each(task.intervals, function(j, interval) {
        item.data.push({
            x: interval.from,
            y: i,
            label: interval.label,
            from: interval.from,
            to: interval.to
        }, {
            x: interval.to,
            y: i,
            from: interval.from,
            to: interval.to
        });
        // add a null value between intervals
        if (task.intervals[j + 1]) {
            item.data.push(
                [(interval.to + task.intervals[j + 1].from) / 2, null]
            );
        }

    });

    series.push(item);
});


// create the chart
var chart = new Highcharts.Chart({

    chart: {
        renderTo: 'gantt'
    },
    
    title: {
        text: 'Diagrama de Gantt'
    },

    xAxis: {
        type: 'datetime'
    },

    yAxis: {
        tickInterval: 1,
        labels: {
            formatter: function() {
                if (tasks[this.value]) {
                    return tasks[this.value].name;
                }
            }
        },
        startOnTick: false,
        endOnTick: false,
        title: {
            text: 'Actividades'
        },
            minPadding: 0.2,
            maxPadding: 0.2
    },

    legend: {
        enabled: false
    },

    tooltip: {
        formatter: function() {
            return '<b>'+ tasks[this.y].nombre + '</b><br/>' +
                '<b>Responsable: </b>' + tasks[this.y].responsable + '<br/>'+
                '<b>Fecha de inicio: </b>'+Highcharts.dateFormat('%d-%m-%Y', this.point.options.from)  + '<br/>'+
                '<b>Fecha de culminación: </b>' + Highcharts.dateFormat('%d-%m-%Y', this.point.options.to)+'<br/>'+
                '<b>Porcentaje de avance: </b>'+tasks[this.y].total+' %'; 
        }
    },

    plotOptions: {
        line: {
            lineWidth: 18,
            marker: {
                enabled: false
            },
            dataLabels: {
                enabled: true,
                align: 'left',
                formatter: function() {
                    return this.point.options && this.point.options.label;
                }
            }
        }
    },

    series: series

});
</script>