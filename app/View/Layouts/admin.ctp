<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('Instituto de Ingenieria - CPDI - '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('safii.style', 'jquery-ui-1.8.2.custom', 'fancybox/jquery.fancybox-1.3.1', 'menu_black'));
		
		echo $this->Html->script(array('jquery', 'jquery-ui-1.8.2.custom.min', 'fancybox/jquery.mousewheel-3.0.2.pack', 'fancybox/jquery.fancybox-1.3.1', 'jquery.ui.datepicker-es', 'menu', 'validacion'));
		
		echo $scripts_for_layout;
		
		
	?>
		<!--blueprint files being -->
<link rel="stylesheet" href="/css/blueprint/screen.css" media="screen, projection" />
<link rel="stylesheet" href="/css/blueprint/print.css" media="print" />
<!--[if IE]>
<link rel="stylesheet" href="/css/blueprint/ie.css" media="screen,projection" />
<![endif]-->
<!-- blueprint files end-->

<!--[if lt IE 7]>
<style type="text/css">
   .dock img { behavior: url(iepngfix.htc) }
   </style>
<![endif]-->
<script type="text/javascript">
$(function() {
	$(".pdf, input:submit, .subtmit").button();
});
</script>
</head>
<body>
	<div>
		<?php
			
			//if($logueo) echo "";
			//else{
		?>
			
			<script>
				/*
				jQuery(document).ready(function() {
					$.fancybox(
						{
							"title": "Inicio de Sesión",
							"href": "/duida/usuarios/login",
							"modal": true,
				        	"autoDimensions"	: false,
							"width"         		: "auto",
							"height"        		: "auto",
							"transitionIn"		: "none",
							"transitionOut"		: "none"
						}
					);
				});
*/
			</script>

		<?
			//} 
		?>
		<?php 
			$isauth = $this->Session->check('Message.auth.message');
			$mensaje = $this->Session->flash();
			if(!empty($mensaje) || $isauth){
				if(!empty($mensaje)){
					echo $mensaje;
				}else{
					show_mensaje($session->read('Message.auth.message'));
					$this->Session->delete('Message');
				}
		?>
			
		<script type="text/javascript">
			$(document).ready(function() {
				$(".message").addClass("visible");
				$("message").click(function(){
						$(".message").slideUp(1500);
						return;
				});
				$(".message").slideDown(1500, function(){
					setTimeout("$('.message').slideUp(1500);", 7000);
				});
				
			});
		</script>
		<?	
			}
		?>
	</div>
	<div id="sobreHeader">
		<div id="header">
				<center>
				<? echo $this->Html->image('cintillo.jpg', array('style'=>'margin:0 auto')); ?>
				</center>
				<h1><?php echo __('CPDI: Centro de Procesamiento Digital de Imágenes', true); ?></h1>
		</div>
	</div>
	<div id="menu">
		<ul class="menu">
			<li id="mcu"><a href="#" class="parent"><span>Usuarios</span></a>
				<div>
					<ul>
						<li><?= $this->Html->link('Listado', array('controller'=>'Usuarios', 'action'=>'index')) ?></li>
						<li><?= $this->Html->link('Agregar', array('controller'=>'Usuarios', 'action'=>'add')) ?></li>
					</ul>
				</div>
			</li>

			<li id="acl"><a href="#" class="parent"><span>ACL's</span></a>
				<div>
					<ul>
						<li><?= $this->Html->link("Administrar ARO's", array('controller'=>'Acl', 'action'=>'aro')) ?></li>
						<li><?= $this->Html->link("Administrar ACO's", array('controller'=>'Acl', 'action'=>'aco')) ?></li>
						<li><?= $this->Html->link("Asignar Permisos", array('controller'=>'Acl', 'action'=>'permisos')) ?></li>
					</ul>
				</div>
			</li>

			<li id="mcp"><a href="#"><span>Parametros</span></a>
				<div><ul>
					<li><a href="#" class="parent"><span>Paises</span></a>
						<div>
							<ul>
								<li><?= $this->Html->link("Listar", array('controller'=>'Paises', 'action'=>'/')) ?></li>
								<li><?= $this->Html->link("Registrar", array('controller'=>'Paises', 'action'=>'add')) ?></li>
							</ul>
						</div>
					</li>
					<li><a href="#" class="parent"><span>Estados</span></a>
						<div>
							<ul>
								<li><?= $this->Html->link("Listar", array('controller'=>'Estados', 'action'=>'/')) ?></li>
								<li><?= $this->Html->link("Registrar", array('controller'=>'Estados', 'action'=>'add')) ?></li>
							</ul>
						</div>
					</li>
					<li><a href="#" class="parent"><span>Tipos de Evento</span></a>
						<div>
							<ul>
								<li><?= $this->Html->link("Listar", array('controller'=>'TipoEventos', 'action'=>'/')) ?></li>
								<li><?= $this->Html->link("Registrar", array('controller'=>'TipoEventos', 'action'=>'add')) ?></li>
							</ul>
						</div>					
					</li>
					<li><a href="#" class="parent"><span>Elipsoides</span></a>
						<div>
							<ul>
								<li><?= $this->Html->link("Listar", array('controller'=>'Elipsoides', 'action'=>'/')) ?></li>
								<li><?= $this->Html->link("Registrar", array('controller'=>'Elipsoides', 'action'=>'add')) ?></li>
							</ul>
						</div>					
					</li>
					<li><a href="#" class="parent"><span>Datum</span></a>
						<div>
							<ul>
								<li><?= $this->Html->link("Listar", array('controller'=>'Datumes', 'action'=>'/')) ?></li>
								<li><?= $this->Html->link("Registrar", array('controller'=>'Datumes', 'action'=>'add')) ?></li>
							</ul>
						</div>					
					</li>
					<li><a href="#" class="parent"><span>Equipos</span></a>
						<div>
							<ul>
								<li><?= $this->Html->link("Listar", array('controller'=>'Equipos', 'action'=>'/')) ?></li>
								<li><?= $this->Html->link("Registrar", array('controller'=>'Equipos', 'action'=>'add')) ?></li>
							</ul>
						</div>					
					</li>
					
				</ul></div>
			</li>
			<li class="last"><a href="<?= $this->Html->url('/', true); ?>"><span>Salir del Panel Administrativo</span></a></li>
		</ul>
	</div>
	<div id="container" class="container">
		<div id="main">
			<div id="content" class="span-24 sombra">
	
				<?php echo $content_for_layout; ?>
	
			</div>
			<div id="spinner" style="display: none; position: fixed; bottom: 50px; right: 50px;">
                <?php echo $this->Html->image('spinner.gif'); ?>
			</div>
		</div>
		<div id="footer">
			&copy; 2010 Fundación Instituto de Ingenieria - Centro de Procesamiento Digital de Imágenes (CPDI)<br/>
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true), 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
<?= $this->Element('mensajes')?>

</body>
</html>
