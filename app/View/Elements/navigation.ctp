<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Sistema de gestión de proyectos</a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><?= $this->Html->link('Panel', array('controller'=>'Panel', 'admin'=>false)) ?></li>
        <li><?= $this->Html->link('Configuración', array('controller'=>'Panel', 'admin'=>true)) ?></li>
        <li><a href="#">Ayuda</a></li>
      </ul>
      <form class="navbar-form navbar-right">
        <input type="text" class="form-control" placeholder="Buscar...">
      </form>
    </div>
  </div>
</div>