<h2>Reporte de Actividades del CPDI</h2>

<?php
echo $this->Form->create('Event', array('action'=>'generar_reporte'));
$mes = date('m');
$meses = array(0=>'Todos', 1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre');
echo $this->Form->input('mes', array('options'=>$meses, 'selected'=>$mes, 'label'=>array('class'=>'span-4 derecha', 'text'=>'Seleccione el mes: ')));
echo $this->Form->end('Generar');
?>