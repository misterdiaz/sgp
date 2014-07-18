<?php
    //session_destroy();
	//session_start();
?>
<div class="login">
	<div class="login-in">
		<div class="logo-name">
			<?php echo $html->image('logo.png', array('width'=>'65', 'alt'=>'Fundación Instituto de Ingenieria')); ?>
			<h2>Entrada al Sistema</h2>
		</div>

		<form id = "loginform" name = "loginform" method="post" action="<?php echo $html->url(array('controller'=>'usuarios', 'action'=>'login')) ?>">
			<fieldset style="border:0;" >

			<div>
			
				<?php echo $html->image('login-user.png', array('class'=>'username', 'style'=>'position:absolute;')); ?>
				<input type="text" class="text" name="username" id="username" required = "1" style="float:right;"/>

			</div>

			<div>
				<?php echo $html->image('login-pass.png', array('class'=>'username', 'style'=>'position:absolute; padding-top:13px;')); ?>
				<input type="password" class="text" name="password" id="username" required = "0" style="float:right;" />
			</div>

			<div class="row">
				<button type="submit" class="loginbutn" title="entrar" onfocus="this.blur();"></button>
			</div>
			</fieldset>
		</form>
	</div>


	<?php if (isset($loginerror) && $loginerror == 1) {?>
	<div class="login-alert">
		Nombre de Usuario o Clave incorrecta
	</div>
	<?php } ?>
</div>
