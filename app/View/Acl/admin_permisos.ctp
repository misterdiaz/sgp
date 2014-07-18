<script>
	$('#acl').addClass('current');
	$(document).ready(function(){
		$(".pdf, input:submit, .subtmit").button();
	});
</script>
<?php
 /*********************************************************************************
*  República Bolivariana de Venezuela                     
*  Ministerio del Poder Popular de Ciencia y Tecnologia
*  Fundación Instituto de Ingenieria                                                                                                                              
*  Centro de Procesamiento Digital de Imagenes - (CPDI)                                    
*                                                                                 
*                                                                                                  
*  Creado por: Ing. Luis Diaz - ldiazj@fii.gob.ve    			                                                                      
*	                                                                              
***********************************************************************************/
echo $this->Form->create();
?>

<div>
<h2>Asignar permisos entre Grupos/Usuarios - Acciones</h2>
<br/>
<?
	
	echo $this->Form->input('aro', array('options'=>$aros,'label'=>array('text'=>'Elegir el grupo:', 'class'=>'span-4 derecha'), 'empty'=>'Seleccione...', 'selected'=>'', 'class'=>'span-6 last', 'type'=>'select', 'div'=>array('class'=>'input select span-10') ));
	echo $this->Js->submit("Continuar", array("id"=>'bt_sel', 'update'=>'#miembros', 'url'=>array('action'=>'aro_view_miembros')));
	/*$this->Js->get('#btsel');
	$this->Js->event('click', 
	$this->Js->request(
        array('action' => 'aro_view_miembros'),
        array('async' => true, 'update' => '#miembros')
    )
	);*/
	
?>

	<div id="miembros">
	</div>
</div>

<div class="actions">
	<ul>
		<li><?= $this->Html->link($this->Html->image("home.png", array("width"=>"48", 'alt'=>'Inicio', 'title'=>'Inicio')), 
			"/", 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
		<li>
			<?= $this->Html->link($this->Html->image("iEngrenages.png", array("width"=>"48", 'alt'=>'Configuración', 'title'=>'Configuración')), 
			array( "controller"=>"Panel", "action"=>"index", 'admin'=>true), 
			array("confirm"=>null, "indicator"=>null, "escape"=>false)); ?>
		</li>
	</ul>
</div>