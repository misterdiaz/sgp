<?php
/*******************************************************************************
*    República Bolivariana de Venezuela
*    Ministerio del Poder para Ciencia, Tecnología e Industrias Intermedias
*    Fundación Instituto de Ingenieria
*    Centro de Procesamiento Digital de Imagenes
*    
*     Archivo: admin_aro_miembro_add.ctp
*     Fecha de Creación: 10/09/2010
*     Creado por: Ing. Luis Alfredo Diaz Jaramillo - ldiazj@fii.gob.ve
*     
*******************************************************************************/

echo $this->Form->create('Aro');
?>
<div class="span-20" style="height:300px">
<script type="text/javascript">
	$(function() {
		$("checkbox #permision").button();
		$("#permisos2").buttonset();
		$(".pdf, input:submit, .subtmit").button();
	});
	$("#submit_ajax").click(function(){
	    $.fancybox.close();
	});
	function setCheckbox(){
		//alert($("#permission0").attr("checked"));
		if($("#permision0").attr("checked")){
		    //alert($("#permission1").attr("checked"));
			$("#permision1").attr("checked", false);
			$("#l21").attr("aria-pressed", false);
			$("#l21").removeClass("ui-state-active");
			//alert($("#permission1").attr("checked"));
			$("#permision2").attr("checked", false);
			$("#l22").attr("aria-pressed", false);
			$("#l22").removeClass("ui-state-active");
			$("#permision3").attr("checked", false);
			$("#l23").attr("aria-pressed", false);
			$("#l23").removeClass("ui-state-active");
			$("#permision4").attr("checked", false);
			$("#l24").attr("aria-pressed", false);
			$("#l24").removeClass("ui-state-active");
		}
	}
	function setAll(){
		if($("#permision0").attr("checked")){
		    $("#permision0").attr("checked", false);
		    $("#l20").attr("aria-pressed", false);
			$("#l20").removeClass("ui-state-active");
		}
	    
	}
	$("#permision0").click(setCheckbox);
	$(".permiso2").click(setAll);
</script>
<h2>Asignar permisos especiales a un usuario especifico</h2>
<br/>
<div class="span-20 last">
<? echo $this->Form->input('usuario_id', array('label'=>array('text'=>'Usuario del grupo:', 'class'=>'span-4 derecha'), 'empty'=>'Seleccione...', 'class'=>'span-6 last','options'=>$usuarios, 'div'=>array('class'=>'input select span-10'))); ?>
<? echo $this->Form->input('aco_id', array('label'=>array('text'=>'Objetos disponibles:', 'class'=>'span-4 derecha'), 'empty'=>'Seleccione...', 'class'=>'span-6 last','options'=>$objetos, 'div'=>array('class'=>'input select span-10 last'))); ?>
</div>
<br/>
<div class="span-14" style="height:60px"></div>
<div class="span-15" style="height:60px">
	<span id="permisos2">
		<input type="radio" name="data[tipo2]" value="1" id="tipo20" />
		<label for="tipo20">Permitir</label>
		<input type="radio" name="data[tipo2]" value="-1" id="tipo21" />
		<label for="tipo21">Denegar</label>
		
		<input type="checkbox" name="data[permisos2][create]" id="permision1" />
		<label for="permision1" id="l21" class="permiso2">Crear</label>
		
		<input type="checkbox" name="data[permisos2][read]" id="permision2" />
		<label for="permision2" id="l22" class="permiso2">Leer</label>
		
		<input type="checkbox" name="data[permisos2][update]" id="permision3" />
		<label for="permision3" id="l23" class="permiso2">Actualizar</label>
		
		<input type="checkbox" name="data[permisos2][delete]" id="permision4" />
		<label for="permision4" id="l24" class="permiso2">Eliminar</label>
		
		<input type="checkbox" name="data[permisos2][all]" id="permision0" CHECKED/>
		<label for="permision0" id="l20">Todos</label>
	</span>
</div>
<div class="span-5 last">
<?php
	echo $this->Js->submit('Agregar permisos', array (
	'url'=> array ('controller'=>'Acl', 'action'=>'aro_miembro_add_permiso', $value = $aro_id),
	'update'=> array ('miembros'),
	'condition'=>NULL, // '$("#campo1").val() == $("#campo2").val()'
	'confirm'=>null,
	'indicator'=>null,
	'id'=>'submit_ajax',
	'after'=>null // '$("#post2").html("Wait a moment")'
	));
?>
</div>
</div>