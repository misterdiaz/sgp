<?php 
if (AuthComponent::user('id')):
?>
<div class="sidebar-nav">
  <div class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <span class="visible-xs navbar-brand">Sistema Gestión de Proyectos</span>
    </div>
    <div class="navbar-collapse collapse sidebar-navbar-collapse">
      <ul class="nav navbar-nav">
        <li id="liHome"><?= $this->Html->link('Inicio', array('controller'=>'Panel', 'action'=>'index','admin'=>false)) ?></li>
        <li id="liUsuarios">
          <a data-toggle="collapse" data-parent="#accordion" href="#ulUsuarios">Usuarios <b class="caret"></b></a>
          <ul id="ulUsuarios" class="ul-collapse collapse nav nav-stacked sub-nav">
            <li><?= $this->Html->link('Listado', array('controller'=>'Usuarios', 'action'=>'index', 'admin'=>true), array('id'=>'lnk_usuarios')) ?></li>
            
            <li><?= $this->Html->link('Agregar', array('controller'=>'Usuarios', 'action'=>'add', 'admin'=>true), array('id'=>'lnk_reportes')) ?></li>
            <li><?= $this->Html->link('Permisos', array('controller'=>'Acl', 'action'=>'permisos', 'admin'=>true), array('id'=>'lnk_reportes')) ?></li>
          </ul>
        </li>
        <li id="liRoles">
          <a data-toggle="collapse" data-parent="#accordion" href="#ulRoles">Roles <b class="caret"></b></a>
          <ul id="ulRoles" class="ul-collapse collapse nav nav-stacked sub-nav">
            <li><?= $this->Html->link('Listado', array('controller'=>'Roles', 'action'=>'index', 'admin'=>true), array('id'=>'lnk_roles')) ?></li>
            
            <li><?= $this->Html->link('Agregar', array('controller'=>'Roles', 'action'=>'add', 'admin'=>true), array('id'=>'lnk_roles_add')) ?></li>
          </ul>
        </li>
        <li id="liActividades">
          <a data-toggle="collapse" data-parent="#accordion" href="#ulActividades">Tipos de actividades <b class="caret"></b></a>
          <ul id="ulActividades" class="ul-collapse collapse nav nav-stacked sub-nav">
            <li><?= $this->Html->link('Listado', array('controller'=>'TipoActividades', 'action'=>'index', 'admin'=>true), array('id'=>'lnk_actividades')) ?></li>
            <li><?= $this->Html->link('Agregar', array('controller'=>'TipoActividades', 'action'=>'add', 'admin'=>true), array('id'=>'lnk_actividades_add')) ?></li>
          </ul>
        </li>
        <li><?= $this->Html->link('Cerrar Sesión', array('controller'=>'Usuarios', 'action'=>'logout', 'admin'=>false)) ?></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>
<?php
endif;
?>