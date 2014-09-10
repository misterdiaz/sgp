<?php
$this->Html->addCrumb('Control de Acceso', array('controller'=>'Acl', 'action'=>'permisos', 'admin'=>true));
$this->Html->addCrumb('Designar de permisos por grupo');
$tipo_opc = array(1=>"Permitir", -1=>"Denegar");
$tipo = array(0=>"Grupo", -1=>"Denegado", "1"=>"Permitido");
$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
echo $this->Form->create('Acl', array('class'=>'form', 'inputDefaults'=>$defaults, 'action'=>'grupo_permiso/'.$aro_id));
$permisos = array('create'=>'Crear', 'read'=>'Leer', 'update'=>'Actualizar', 'delete'=>'Eliminar');
?>
<h2>Objetos Disponibles:</h2>

<div class="form-group form-horizontal row">
	<label for="AcoAco" class="col-sm-2 control-label">Elegir el objeto: </label>
	<div class="col-sm-2">
		<?= $this->Form->input('aco', array('options'=>$objetos, 'class'=>'form-control', 'empty'=>'Seleccione...', 'required'=>true)) ?>
	</div>
	<div class="col-sm-2">
		<?= $this->Form->input('tipo', array('options'=>$tipo_opc, 'class'=>'form-control', 'empty'=>'Tipo de permiso', 'required'=>true)) ?>
	</div>
	<div class="col-sm-2">
		<?= $this->Form->input('permisos', array('options'=>$permisos, 'class'=>'form-control', 'multiple'=>true, 'required'=>true)) ?>
	</div>
	<div class="btn-group">
		<?php echo $this->Form->end(array('label'=>'Asignar permisos', 'div'=>false, "class"=>"btn btn-primary")); ?>
		<a href="<?= $this->Html->url(array('controller'=>'Acl', 'action'=>'permisos', 'admin'=>true)) ?>" class="btn btn-warning">Regresar</a>
		<a href="<?= $this->Html->url(array('controller'=>'Panel', 'action'=>'index', 'admin'=>true)) ?>" class="btn btn-danger">Cancelar</a>
	</div>
</div>


<div id="grupo_permiso">
	<h2>Permisos del grupo:</h2>
	<table class='table table-responsive'>
		<thead>
			<tr>
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
<div>
	<h2>Permisos de los miembros del grupo:</h2><? echo $this->Html->link('Asignar permisos a miembros del grupo', array('controller'=>'Acl', 'action'=>'aro_miembro_add', $this->request->data['Acl']['aro']), array('id'=>'add_permiso', 'title'=>'Asignar permisos especiales a un usuario especifico')) ?>
</div>
<table class='table table-responsive'>
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
<script type="text/javascript">
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