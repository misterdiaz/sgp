<?php
 /*********************************************************************************
*  República Bolivariana de Venezuela                     						  *
*  Ministerio del Poder Popular de Ciencia y Tecnologia							  *
*  Fundación Instituto de Ingenieria                                              *
*  Centro de Procesamiento Digital de Imagenes - (CPDI)                           *
*                                                                                 *
*  Creado por: Ing. Luis Diaz - ldiazj@fii.gob.ve    			                  *
*	                                                                              *
**********************************************************************************/

//pr($this->request);
//pr(AuthComponent::user());
//pr($permisos);
if(AuthComponent::user('id')){
	$user_id = AuthComponent::user('id');

	echo $this->Element('panel-usuario');//Panel con los datos del usuario

	echo $this->Element('panel-actividades', array('actividades'=>$actividades));//Panel con los datos de las actividades por finalizar

	echo $this->Element('panel-permisos'); //Panel con los datos de los permisos

	echo $this->Element('panel-vacaciones'); //Panel con los datos de los dias disponibles
}
?>

<script>
$(document).ready(function() {
	$("#liHome").addClass('active');
	$('.actions a, .btn-group a').tooltip();
});
</script>
<? echo $this->Js->writeBuffer(); ?>
