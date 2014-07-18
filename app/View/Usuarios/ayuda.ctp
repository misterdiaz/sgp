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

echo $javascript->link('flowplayer-3.2.4.min');	
//echo $html->link('', array('/img/menu_eventos2.flv'), array('id'=>'player', 'style'=>'display:block;width:400px;height:300px'));
?>
<a  href="http://192.168.5.62/safii/img/menu_eventos2.flv" style="display:block;width:400px;height:300px" id="player">
</a>
<script>
	flowplayer("player", "js/flowplayer-3.2.5.swf");
</script>
<br/>