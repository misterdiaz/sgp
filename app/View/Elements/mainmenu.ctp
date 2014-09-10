<?php 
if (AuthComponent::user('id')):
?>
<ul class="nav nav-sidebar">
  <li id="liHome"><?= $this->Html->link('Inicio', array('controller'=>'Panel', 'admin'=>false)) ?></li>
  <li id="liProyectos">
    <a data-toggle="collapse" data-parent="#accordion" href="#ulProyectos">Proyectos <b class="caret"></b></a>
    <ul id="ulProyectos" class="ul-collapse collapse nav nav-stacked sub-nav">
    <?php
      if(AuthComponent::user('rol_id') == 2):
    ?>
      <li><?= $this->Html->link('Agregar', array('controller'=>'Proyectos', 'action'=>'add', 'admin'=>false), array('id'=>'lnk_proyectosAdd')) ?></li>
    <?php
      endif;
    ?>
      <li><?= $this->Html->link('Información', array('controller'=>'Proyectos', 'action'=>'index', 'admin'=>false), array('id'=>'lnk_proyectos')) ?></li>
      <li><?= $this->Html->link('Reportes', array('controller'=>'Proyectos', 'action'=>'reportes', 'admin'=>false), array('id'=>'lnk_reportes')) ?></li>
    </ul>
  </li>
  <li id="liActividades">
    <a data-toggle="collapse" data-parent="#accordion" href="#ulActividades">Actividades <b class="caret"></b></a>
    <ul id="ulActividades" class="ul-collapse collapse nav nav-stacked sub-nav">
      <li><?= $this->Html->link('Mis actividades', array('controller'=>'Actividades', 'action'=>'index', 'admin'=>false), array('id'=>'lnk_actividades')) ?></li>
    </ul>
  </li>
  <li id="liHoras">
    <a data-toggle="collapse" data-parent="#accordion" href="#ulHoras">Registro de Horas <b class="caret"></b></a>
    <ul id="ulHoras" class="ul-collapse collapse nav nav-stacked sub-nav">
      <li><?= $this->Html->link('Registro', array('controller'=>'Horas', 'action'=>'add', 'admin'=>false), array('id'=>'lnk_registro_horas')) ?></li>
    </ul>
  </li>
</ul>
<?php
endif;
?>
<script type="text/javascript">
  
</script>