<?php
$this->Html->addCrumb('Proyectos', array('controller'=>'Proyectos', 'action'=>'index'));
$this->Html->addCrumb('Reportes', array('controller'=>'Proyectos', 'action'=>'reportes'));
$this->Html->addCrumb('Avance de actividades', '');
?>
<h2>Avance de Actividades por Proyectos</h2>

<?php 
if($rol_id != 2){
	$requerido = 'required';
}else{
	$requerido = '';
}

$defaults = array('label'=>false, 'div'=>false, 'class'=>'form-control');
echo $this->Form->create('Proyecto', array('class'=>'form', 'inputDefaults'=>$defaults));

	
	$meses = array(1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Obtubre', 11=>'Noviembre', 12=>'Diciembre');
	$trimestre = array(1=>'1er Trimestre (Ene-Feb-Mar)', 2=>'2do Trimestre (Abr-May-Jun)', 3=>'3er Trimestre (Jul-Ago-Sep)', 4=>'4to Trimestre (Oct-Nov-Dic)');
	$semestre = array(1=>'1er Semestre (Ene-Jun)', 2=>'2do Semestre (Jul-Dic');
	$tiposReporte = array(1=>'Mensual', 2=>'Trimestral', 3=>'Semestral', 4=>'Anual');
	//array_push($proyectos, 'Todos los proyectos');

?>
<div class="form-group">
	<label for="ProyectoIncluir">Proyecto: </label>
	<?= $this->Form->input('incluir', array('empty'=>'Todos los proyectos...', 'options'=>$proyectos, $requerido)) ?>
</div>

<div class="form-group">
	<label for="ProyectoTipo">Tipo de reporte: </label>
	<?= $this->Form->input('tipo', array('empty'=>'Seleccione...', 'options'=>$tiposReporte, 'required'=>true)) ?>
</div>

<div class="form-group" id='div_mes'>
	<label for="ProyectoMes">Mes: </label>
	<?= $this->Form->input('mes', array('empty'=>'Seleccione...', 'options'=>$meses,)) ?>
</div>

<div class="form-group" id='div_trimestre'>
	<label for="ProyectoTrimestre">Trimestre: </label>
	<?= $this->Form->input('trimestre', array('empty'=>'Seleccione...', 'options'=>$trimestre,)) ?>
</div>

<div class="form-group" id='div_semestre'>
	<label for="ProyectoSemestre">Semestre: </label>
	<?= $this->Form->input('semestre', array('empty'=>'Seleccione...', 'options'=>$semestre,)) ?>
</div>

<div class="form-group" id='div_year'>
	<label for="ProyectoYear">Año: </label>
	<?= $this->Form->input('year', array('placeHolder'=>'YYYY', 'default'=>date('Y'), 'type'=>'number')) ?>
</div>

<div class="btn-group">
	<button class='btn btn-default'>
		Descargar PDF <span class="glyphicon glyphicon-save"></span>
	</button>
	<a href="<?= $this->Html->url(array('controller'=>'Proyectos', 'action'=>'reportes')) ?>" class="btn btn-default">Cancelar</a>
</div>

<script>
$(document).ready(function() {
	$("#liProyectos").addClass('active');
	$("#ulProyectos").addClass('in');
	$("#lnk_reportes").addClass('current');

	// validate signup form on keyup and submit
	//$("#ProyectoReporteActividadesPersonalForm").validate();

	var tipoReporte = $("#ProyectoTipo");
	var inital = tipoReporte.is(":checked");
	var topics = $("#div_mes, #div_trimestre, #div_semestre, #div_year")[inital ? "show" : "hide"]();
	iniciar();
	//var topicInputs = topics.find("input").attr("disabled", !inital);
	tipoReporte.click(function() {
		iniciar();		
	});
	
	function iniciar(){
		var valor = $("#ProyectoTipo").val();
		switch(valor){
			case '1':
				$("#div_mes").show();
				$("#div_trimestre, #div_semestre, #div_year").hide();
				$("#ProyectoMes").attr('required', true);
				break;
			case '2':
				$("#div_trimestre").show();
				$("#div_mes, #div_semestre, #div_year").hide();
				$("#ProyectoTrimestre").attr('required', true);
				break;
			case '3':
				$("#div_semestre").show();
				$("#div_mes, #div_trimestre, #div_year").hide();
				$("#ProyectoSemestre").attr('required', true);
				break;
			case '4':
				$("#div_year").show('invisible');
				$("#div_mes, #div_trimestre, #div_semestre").hide();
				$("#ProyectoYear").attr('required', true);
				break;
			default:
				$("#div_mes, #div_trimestre, #div_semestre, #div_year").hide();
				break;
		}
	}
});
</script>