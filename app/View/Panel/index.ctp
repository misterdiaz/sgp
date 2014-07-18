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
?>

<p>
<?php
//pr(AuthComponent::user());
if(AuthComponent::user('id')){
?>


</div>
<?php
	}
?>

<script>
$(document).ready(function() {
	$("#liHome").addClass('active');
});
</script>
<? echo $this->Js->writeBuffer(); ?>