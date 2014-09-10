<?php
class UsuariosController extends AppController {

	public $name = 'Usuarios';
	public $uses = array('Usuario', 'Personal', 'Rol');
	public $components= array('RequestHandler', 'Cookie', 'Auth');
	
	public $paginate = array(
        'Usuario' => array ('limit' => 25, 'order' => array('Usuario.status' => 'asc')),
    );
	
	function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->autoRedirect = false;
		//$this->Auth->authorize = 'crud';
		$this->Auth->allowedActions = array('login', 'logout', 'admin_login', 'admin_logout', 'change_password');//Descomentar esta linea para las acciones a las cuales queremos dar libre acceso. (Usar * para dar acceso a todas las acciones.)
	}

	function admin_index() {
		$this->Usuario->recursive = 0;
		$this->set('usuarios', $this->paginate());
	}
	public function index() {
		$usuario = $this->Usuario->find('all', array('conditions'=>array('Usuario.id'=>$this->Auth->user('id'))));
		$this->set(compact('usuario'));

	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Usuario invalido');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('usuario', $this->Usuario->read(null, $id));
	}

	public function change_password() {
		if(!$this->Auth->user()){
			$this->Session->setFlash('Debes iniciar sesión para poder realizar el cambio de clave.');
			$this->redirect(array('controller'=>'Usuarios', 'action' => 'login', 'admin'=>false));
		}
		if (!empty($this->request->data)) {
			$id = AuthComponent::user('id');
			$this->request->data['Usuario']['id']=$id;
			$this->Usuario->id = $id;
			if($this->Usuario->save($this->request->data)){
				$this->Session->setFlash('Clave modificada con exito');
				$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));
			}else{
				$this->Session->setFlash('La clave no fue modificada. Por favor, intente nuevamente.');
				$this->redirect(array('controller'=>'Usuario', 'action' => 'change_password', 'admin'=>false));
			}
		}
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Usuario->create();
			if ($this->Usuario->save($this->data)) {
				$this->Session->setFlash(__('The usuario has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The usuario could not be saved. Please, try again.', true));
			}
		}
		$roles = $this->Usuario->Rol->find('list');
		$this->set(compact('roles'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid usuario', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Usuario->save($this->request->data)) {
				$this->Session->setFlash(__('The usuario has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The usuario could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->request->data = $this->Usuario->read(null, $id);
			$this->request->data['Usuario']['clave'] = "";
		}
		$roles = $this->Usuario->Rol->find('list');
		$this->set(compact('roles'));
	}

	public function update($id = null) {
		$id = $this->Auth->user('id');
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid usuario', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Usuario->save($this->request->data)) {
				$this->Session->setFlash(__('The usuario has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The usuario could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->request->data = $this->Usuario->read(null, $id);
			$this->request->data['Usuario']['clave'] = "";
		}
		$roles = $this->Usuario->Rol->find('list');
		$this->set(compact('roles'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Usuario Invalido', true));
			$this->redirect(array('action'=>'index', 'admin'=>true));
		}
		if ($this->Usuario->delete($id)) {
			$this->Session->setFlash(__('Usuario eliminado', true));
			$this->redirect(array('action'=>'index', 'admin'=>true));
		}
		$this->Session->setFlash(__('Usuario no fue eliminado', true));
		$this->redirect(array('action' => 'index', 'admin'=>true));
	}
		//funciones para el logueo de usuarios, manejo de permisos, mediante Acl
	
	public function login(){
		//pr($this->data);
		//echo $this->Auth->password("cpdi1357,");
		$this->layout= "login";
		if ($this->request->is('post')) {
			//pr($this->request);
			//$this->Auth->_setDefaults();
			//$this->request->data['Usuario']['clave'] = md5($this->request->data['Usuario']['clave']);
	    	if ($this->Auth->login()){
	    		//if($this->Auth->loggedIn()) echo "logueado";
	    		$this->Session->setFlash('Usted ha iniciado sesión.');
				//$this->Auth->_loggedIn = true;
	       		$this->redirect($this->Auth->redirect());
	    	}else {
	    		//pr($this->data);
	        	$this->Session->setFlash("Lo siento, la combinación nombre de usuario - contraseña es incorrecta. Por favor, verifique los datos he intente de nuevo", 'default', array('class'=>'message'));
	    	}
		}
	}
	
	function admin_login(){
		$this->redirect(array('controller'=>'Usuarios', 'action'=>'login', 'admin'=>false));
	}
	
	
	function logout() {
		$this->Session->setFlash('La sesión ha sido cerrada');
		$this->redirect($this->Auth->logout());
		
	}
	
	function admin_logout() {
		$this->Session->setFlash('La sesión ha sido cerrada');
		$this->redirect($this->Auth->logout());
		
	}
	
	function admin_crear_usuarios(){
		$afiliados = $this->Personal->find('all', array('conditions'=>''));
		pr($afiliados);
		$i = 0;
		foreach ($afiliados as $row) {
			$datos = array();
			$this->Usuario->create();
			$loginV= split("@",$row['Personal']['email']);
			$datos['Usuario']['login'] = $loginV[0];
			$pass = $row['Personal']['cedula'];
			$datos['Usuario']['clave'] = md5($pass);
			$datos['Usuario']['nombre'] = $row['Personal']['nombre'];
			$datos['Usuario']['apellido'] = $row['Personal']['apellido'];
			$datos['Usuario']['cedula'] = $row['Personal']['cedula'];
			$datos['Usuario']['telefono'] = $row['Personal']['telefono'];
			$datos['Usuario']['email'] = $row['Personal']['email'];
			$datos['Usuario']['email_secundario'] = $row['Personal']['email_secundario'];
			$datos['Usuario']['celular'] = $row['Personal']['celular'];
			$datos['Usuario']['status'] = 1;
			$datos['Usuario']['rol_id'] = 3;
			//echo $i++;
			pr($datos);
			if($this->Usuario->save($datos)) echo "Usuario ".$datos['Usuario']['login']." creado<br/>";
		}
		echo "OPERACION FINALIZADA";
		
	}
	
	function admin_updatePasswords(){
		$usuarios = $this->Usuario->find('all', array('fields'=>'id, clave, cedula'));
		//pr($afiliados);
		$i = 0;
		foreach ($usuarios as $row) {
			$this->Usuario->create();
			$this->Usuario->id = $row['Usuario']['id'];
			//pr($row);
			if($row['Usuario']['id'] == 2){
				$user['Usuario']['clave'] =  "cpdi1357,";
			}else{
				$user['Usuario']['clave'] =  $row['Usuario']['cedula'];
			}
			//echo "Id: ".$row['Usuario']['id']." - clave: ".$user['Usuario']['clave']."<br/>";
			$this->Usuario->save($user);
		}
		echo "OPERACION FINALIZADA";exit;
		
	}
	
	public function admin_setRol(){
		$aro = new Aro();
		$usuario = array('alias' => 'admin',
            'parent_id' => 1,
            'model' => 'Usuario',
            'foreign_key' => 2);
		$aro->create();
        //Save data
        $aro->save($usuario);
	}
	
	public function admin_setRoles(){
		$usuarios = $this->Usuario->find('all', array('fields'=>'id, login, rol_id', 'order'=>'Usuario.id'));
		$roles = $this->Usuario->Rol->find('all', array('fields'=>'id, nombre', 'order'=>'Rol.id'));
		$aro = new Aro();
		foreach ($roles as $grupo){
			$alias = $grupo['Rol']['nombre'];
			$parent_id = null;
			$model = "Rol";
			$foreign_key = $grupo['Rol']['id'];
			
			$Rol = array('alias' => $alias,
	            'parent_id' => $parent_id,
	            'model' => $model,
	            'foreign_key' => $foreign_key);
			$aro->create();
	        //Save data
	        $aro->save($Rol);
		}
		//exit;
		foreach ($usuarios as $usuario){
			//pr($usuario);exit;
			$alias = $usuario['Usuario']['login'];
			$parent_id = $usuario['Usuario']['rol_id'];
			$model = "Usuario";
			$foreign_key = $usuario['Usuario']['id'];
						
			$rol = array('alias' => $alias,
	            'parent_id' => $parent_id,
	            'model' => $model,
	            'foreign_key' => $foreign_key);
			$aro->create();
	        //Save data
	        $aro->save($rol);
		}
		echo "Proceso realizado.";exit;
	}
}
?>