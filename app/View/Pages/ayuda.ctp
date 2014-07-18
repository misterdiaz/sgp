<?php
/*******************************************************************************
*    República Bolivariana de Venezuela
*    Ministerio del Poder para Ciencia, Tecnología e Industrias Intermedias
*    Fundación Instituto de Ingenieria
*    Centro de Procesamiento Digital de Imagenes
*    
*     Archivo: ayuda.ctp
*     Fecha de Creación: 06/10/2010
*     Creado por: Ing. Luis Alfredo Diaz Jaramillo - ldiazj@fii.gob.ve
*     
*******************************************************************************/

	//echo $html->link('', array('/img/menu_eventos2.flv'), array('id'=>'player', 'style'=>'display:block;width:800px;height:600px'));
?>
<script>
	$("#help").addClass("current");
	$(document).ready(function() {
		$('.tutorial').fancybox({modal2: true,'type' : 'iframe', 'width': '840', 'height':'633'});
	});
</script>
<h2>Listado de Video Tutoriales</h2>
<div class="span-8">
<p>
<b>Tutorial sobre como registrarse</b>
<? 
echo "<a href='/tutoriales/registro_usuario/' title='Tutorial sobre como registrarse' class='tutorial'>";
echo $html->image('registro_usuario.jpeg', array('class'=>'sombra')); 
echo "</a>";
?>
</p>
</div>
<div class="span-8">
<p>
<b>Tutorial sobre registro de eventos</b>
<? 
echo "<a href='/tutoriales/eventos/' title='Tutorial sobre registro y consulta de eventos' class='tutorial'>";
echo $html->image('evento.jpeg', array('class'=>'sombra'));
echo "</a>";
?>
</p>
</div>
<div class="span-24 last nota">
<p>* Hacer click en la imagen del videotutorial que desea ver y espere a que se cargue el video.</p>
</div>