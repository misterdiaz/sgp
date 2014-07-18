<?= $this->Form->create('Usuario', array('action' =>'login', 'class'=>'form-signin')); ?>
	<h2 class="form-signin-heading">Inicio de sesión</h2>
	<?= $this->Form->input('login', array('class'=>'form-control', 'placeholder'=>'Usuario', 'label'=>false, 'autofocus')); ?>
	<?= $this->Form->input('clave', array('class'=>'form-control', 'placeholder'=>'Constraseña', 'label'=>false, 'type'=>'password')); ?>
	<!--<label class="checkbox">
	  <input type="checkbox" value="remember-me"> Remember me
	</label> !-->
	<button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
<?= $this->Form->end(); ?>
