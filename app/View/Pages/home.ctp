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
if(AuthComponent::user('id')){
?>
<div class="span-10">
<?php
		$year = date('Y');
		$month = date('m');
		$base_url = $this->webroot.'events/calendar';
		$data = $this->requestAction("Events/parametros/$year/".mes2letras($month));
		//print_r($datos);
		echo "<div class='span-8'>";
		echo $this->element('calendar', array('year'=>$year, 'month'=>mes2letras($month), 'data'=>$data, 'base_url'=>$base_url));
		echo "</div>";
		echo "<div class='span-16 last'>";
			//echo "<h4>Noticias:</h4>";
		echo "</div>";
		
?>
</div>
<div class="span-12">
<p class='panel'>
	<?= $this->Html->link($this->Html->image("project-plan.png", array("width"=>"128", 'alt'=>'Proyectos')), array( "controller"=>"Proyectos", "action"=>"index"), array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
</p>
<p class='panel'>
	<?= $this->Html->link($this->Html->image("metadata.png", array("width"=>"128", 'alt'=>'Metadata')), array( "controller"=>"Metadatos", "action"=>"index", 'admin'=>false), array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
</p>
<p class='panel'>
	<?= $this->Html->link($this->Html->image("maps.png", array("width"=>"128", 'alt'=>'Puntos de Control')), array( "controller"=>"Puntos", "action"=>"index", 'admin'=>false), array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
</p>
<p class='panel'>
	<?= $this->Html->link($this->Html->image("iEngrenages.png", array("width"=>"128", 'alt'=>'Configuracion')), array( "controller"=>"Panel", "action"=>"index", 'admin'=>true), array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
</p>
</div>
<?php
	}else{
?>
<div class='span-24 last'>
	<br/>
	<p>	Si es la primera vez que ingresa al sistema por favor <b><a href='Usuarios/add'>registrese aqui</a></b>.</p>
	<p>Para iniciar sesión por favor haga click <b><a href='Usuarios/login'>en este link aqui</a></b>.</p>
</div>
<?php
	}
?>

</p>
<? echo $this->Js->writeBuffer(); ?>
