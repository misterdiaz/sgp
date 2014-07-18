<script type="text/javascript">
	$(function() {
		$("#add_permiso").fancybox({
			'type': 'ajax'
		});
		$("checkbox #permission").button();
		$("#permisos").buttonset();
		$(".pdf, input:submit, .subtmit").button();
	});

	function setCheckbox(){
		//alert($("#permission0").attr("checked"));
		if($("#permission0").attr("checked")){
		    //alert($("#permission1").attr("checked"));
			$("#permission1").attr("checked", false);
			$("#l1").attr("aria-pressed", false);
			$("#l1").removeClass("ui-state-active");
			//alert($("#permission1").attr("checked"));
			$("#permission2").attr("checked", false);
			$("#l2").attr("aria-pressed", false);
			$("#l2").removeClass("ui-state-active");
			$("#permission3").attr("checked", false);
			$("#l3").attr("aria-pressed", false);
			$("#l3").removeClass("ui-state-active");
			$("#permission4").attr("checked", false);
			$("#l4").attr("aria-pressed", false);
			$("#l4").removeClass("ui-state-active");
		}
	}
	function setAll(){
		if($("#permission0").attr("checked")){
		    $("#permission0").attr("checked", false);
		    $("#l0").attr("aria-pressed", false);
			$("#l0").removeClass("ui-state-active");
		}
	    
	}
	$("#permission0").click(setCheckbox);
	$(".permiso").click(setAll);
	
</script>
<? 
	if(isset($msg_flash)){
		show_mensaje($msg_flash);
	}
?>
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
$tipo = array(-1=>"Denegado", 0=>"Grupo", 1=>"Permitido");
//pr($grupo);
//pr($this->request);
?>
<span class="span-24">
<h2>Objetos Disponibles:</h2>
<? 
	echo $this->Form->input('aco', array('options'=>$objetos, 'label'=>array('text'=>'Elegir el objeto:', 'class'=>'span-3 derecha'),'class'=>'span-4 last', 'empty'=>'Seleccione...', 'selected'=>'', 'div'=>array('class'=>'input select span-7')));
?>
	<span id="permisos" class="span-12" style="margin-top: 6px;">
		
		<input type="radio" name="data[tipo]" value="1" id="tipo0" />
		<label for="tipo0">Permitir</label>
		<input type="radio" name="data[tipo]" value="-1" id="tipo1" />
		<label for="tipo1">Denegar</label>
		
		<input type="checkbox" name="data[permisos][create]" id="permission1" />
		<label for="permission1" id="l1" class="permiso">Crear</label>
		
		<input type="checkbox" name="data[permisos][read]" id="permission2" />
		<label for="permission2" id="l2" class="permiso">Leer</label>
		
		<input type="checkbox" name="data[permisos][update]" id="permission3" />
		<label for="permission3" id="l3" class="permiso">Actualizar</label>
		
		<input type="checkbox" name="data[permisos][delete]" id="permission4" />
		<label for="permission4" id="l4" class="permiso">Eliminar</label>
		
		<input type="checkbox" name="data[permisos][all]" id="permission0" CHECKED/>
		<label for="permission0" id="l0">Todos</label>
	</span>
<span class="span-2 last" style="margin-left: 20px;">
<?php
	echo $this->Js->submit("Agregar permisos", array(
		'url'=>array('action'=>'grupo_permiso', $value = $this->request->data['Aro']['aro']),
		'update'=>'#miembros',
		'style'=>'margin-left: -40px;',
		'id'=>'submit-permisos')
	);
?>
<? echo $this->Js->writeBuffer(); ?>
</span>
</span>

<div class="span-24 last">
&nbsp;
</div>
<div id="grupo_permiso" class="span-24 last">
<span class="span-24 last">
<h2>Permisos del grupo:</h2>
</span>
<table>
<thead>
	<tr>
		<th rowspan="2" width="30%">&nbsp;</th>
		<th rowspan="2" width="30%">Objeto</th>
		<th colspan="4" style="text-align:center;">Permisos</th>
	</tr>
	<tr>
		<th width="10%" style="text-align:center;">Crear</th>
		<th width="10%" style="text-align:center;">Leer</th>
		<th width="10%" style="text-align:center;">Actualizar</th>
		<th width="10%" style="text-align:center;">Eliminar</th>
	</tr>
</thead>
<?php
	$i = 0;
	if(!empty($grupo))
	foreach($grupo[0]['Aco'] as $obj){
		if($i++ % 2 != 0) $class = "class='altrow'";
		else $class = "";
		//pr($obj);
?>
	<tr>
		<td></td>
		<td <? echo $class?>><?= $obj['alias'] ?></td>
		<td <? echo $class?> style="text-align:center;"><?= $tipo[$obj['Permission']['_create']] ?></td>
		<td <? echo $class?> style="text-align:center;"><?= $tipo[$obj['Permission']['_read']] ?></td>
		<td <? echo $class?>style="text-align:center;"><?= $tipo[$obj['Permission']['_update']] ?></td>
		<td <? echo $class?> style="text-align:center;"><?= $tipo[$obj['Permission']['_delete']] ?></td>
	</tr>
<?php
	}
?>
</table>
</div>
<span class="span-24 last">
<h2>Permisos de los miembros del grupo:</h2><? echo $this->Html->link('Asignar permisos a miembros del grupo', array('controller'=>'Acl', 'action'=>'aro_miembro_add', $this->request->data['Aro']['aro']), array('id'=>'add_permiso', 'title'=>'Asignar permisos especiales a un usuario especifico')) ?>
</span>
<table>
<thead>
	<tr>
		<th rowspan="2" width="30%">Usuario</th>
		<th rowspan="2" width="30%">Objeto</th>
		<th colspan="4" style="text-align:center;">Permisos</th>
	</tr>
	<tr>
		<th width="10%" style="text-align:center;">Crear</th>
		<th width="10%" style="text-align:center;">Leer</th>
		<th width="10%" style="text-align:center;">Actualizar</th>
		<th width="10%" style="text-align:center;">Eliminar</th>
	</tr>
</thead>
<?php
	$i = 0;
	foreach($miembros as $user){
		//pr($user);
		if($i++ % 2 != 0) $class = "class='altrow'";
		else $class = "";
		$num_acos= count($user['Aco']);
		//echo $num_acos;
		if($num_acos){
?>
	<tr>
		<td <? echo $class ?> rowspan="<?= $num_acos ?>" style="vertical-align: middle;"><?= $user['Aro']['alias'] ?></td>
			<? 
				foreach($user['Aco'] as $accion){
			?>
				<td <? echo $class?>><?= $accion['alias'] ?> </td>
				<td <? echo $class?> style="text-align:center;"><?= $tipo[$accion['Permission']['_create']] ?> </td>
				<td <? echo $class?> style="text-align:center;"><?= $tipo[$accion['Permission']['_read']] ?> </td>
				<td <? echo $class?> style="text-align:center;"><?= $tipo[$accion['Permission']['_update']] ?> </td>
				<td <? echo $class?> style="text-align:center;"><?= $tipo[$accion['Permission']['_delete']] ?> </td>
				</tr><tr>
			<?
				}
			?>
		
		
	</tr>
<?php
		}
	}
?>
</table>