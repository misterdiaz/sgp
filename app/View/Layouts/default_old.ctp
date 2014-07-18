<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo "Fundación Instituto de Ingenieria - CPDI" ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('blueprint/screen', 'safii.style', 'style', 'jquery-ui-1.9.2.min', 'jquery.fancybox', 'calendar', 'menu'));
		echo $this->Html->script(
			array('jquery', 'jquery.form', 'jquery.validate.min', 'messages_es', 
			'jquery-ui-1.9.2.min', 'jquery.fancybox', 'jquery.ui.datepicker-es',
			'hc/highcharts', 'hc/exporting', 
			'menu', 'validacion'
		));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
<!--[if IE]>
<link rel="stylesheet" href="/safii/css/blueprint/ie.css" media="screen,projection" />
<![endif]-->
<!-- blueprint files end-->

<!--[if lt IE 7]>
<style type="text/css">
   .dock img { behavior: url(iepngfix.htc) }
   </style>
<![endif]-->
</head>
<body>
<?php echo $this->Html->image('indicator.gif', array('id' => 'busy-indicator')); ?>
<div>
	<?php
		$msj_auth = $this->Session->flash('auth');
		$msj_flash = $this->Session->flash('flash');
		echo $msj_auth;
		echo $msj_flash;
		echo $this->Session->flash('flash');
		if(!empty($msj_flash)){

	?>
	<script>
        $(function() {
                $( ".message" ).dialog({
                        modal: true,
                        resizable: false,
                        draggable: false,
                        title: 'Mensaje del sistema',
                        buttons: {
                                Ok: function() {
                                        $( this ).dialog( "close" );
                                }
                        }
                });
       });
        </script>
<?
        }
        if(!empty($msj_auth)){
?>
 <script>
        $(function() {
                $( ".message" ).dialog({
                        modal: true,
                        resizable: false,
                        draggable: false,
                        title: 'Mensaje del sistema',
                        buttons: {
                                Ok: function() {
                                        $( this ).dialog( "close" );
                                }
                        }
                });
                $( ".error-message" ).dialog({
                        modal: true,
                        resizable: false,
                        draggable: false,
                        title: 'Mensaje del sistema',
                        buttons: {
                                Ok: function() {
                                        $( this ).dialog( "close" );
                                }
                        }
                });
        });
        </script>
<?php
		}
?>
</div>
		<div class="container">
		<div id="content" class="span-24 last sombra">
			<!--cintillo-->
			<div id="cintillo">
				<img src="<?= $this->Html->url('/') ?>img/cintillo.jpg" width="950" alt="logo Gobierno" />
			</div>
			<!--banner-->
			<div id="banner_top" class="bannertop">
				<img src="<?= $this->Html->url('/') ?>img/btop_Home.jpg" alt="banner_top" />
			</div>
		<!-- inicio del menu -->
		<div id="menu">
			<ul class="menu">
			<li id="help">
				<?php				
					if (AuthComponent::user('id')){
						echo "<a><span>Usuario: ".AuthComponent::user('fullname')."</span></a>";
					}else{
						echo "<a href='Usuarios/login'><span>Iniciar sesión</span></a>";
					}
				?>
					</a>
				</li>
				<? 
					//pr($_SESSION);
				if (AuthComponent::user('id')){
					
				?>
					<li class="last"><a href="<?= $this->Html->url(array('controller'=>'Usuarios', 'action'=>'logout', 'admin'=>false)); ?>"><span>Cerrar Sesión</span></a></li>
				<?
					}
				?>
			
			
			</ul>
		</div>
		<!-- Fin del menu -->
		<div id="contenido">
			<?php echo $content_for_layout; ?>
		</div>
		</div>
	</div>
	<!--footer-->
	<div class="container">
		<div class="span-24 last" style="margin:10px 0px 10px 0px">
			<div style="text-align:center">
				&copy;2012. <a href="http://www.fii.gob.ve" target="_blank"><b>Fundaci&oacute;n Instituto de Ingenier&iacute;a para Investigaci&oacute;n y Desarrollo Tecnol&oacute;gico &ndash; FII</b></a>. RIF G-200046503<br />
				Centro de Procesamiento Digital de Im&aacute;genes &ndash; CPDI
			</div>
		</div>
	</div>	<!--fin footer-->
	<?php echo $this->element('sql_dump'); ?>
	<?php

		
	?>
<div style="display:none;">
<a href="http://apycom.com/">Apycom jQuery Menus</a>
</div>
<script type="text/javascript">
$("input:submit").button({
	icons: {
		secondary:  "ui-icon-disk",
	}
});
</script>
<? echo $this->Js->writeBuffer(); ?>
</body>
</html>
