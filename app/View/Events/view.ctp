<div class='span-20'>
<h2>Eventos para el dia: <?= turnFecha($fecha) ?></h2>
<table>
	<thead>
		<tr>
			<th width="200px;">Nombre</th>
			<th>Actividad</th>
			<th>Descripción</th>
		</tr>
	</thead>
	<?php
		$i=0;
		$actividades = array(1=>'Reunión', 2=>'Presentación', 3=>'Asistencia a eventos', 4=>'Publicaciones', 5=>'Otro');
		foreach ($events as $event){
			if($i++ % 2 != 0){
				$class=" class='altrow'";
			}else{
				$class=null;
			}
	?> 
	
		<tr>
			<td <?= $class ?>><?= $event['VActividad']['nombre'] ?></td>
			<td <?= $class ?>><?= $actividades[$event['VActividad']['tipo']] ?></td>
			<td <?= $class ?>><b><?= $event['VActividad']['actividad'] ?>: </b><?= $event['VActividad']['descripcion'] ?></td>
		</tr>
	<?php
		}
	?>
</table>
</div>
