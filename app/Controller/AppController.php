<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $destinatarios = array('aimarar@fii.gob.ve', 'olgam@fii.gob.ve');
		
	public $components = array('Acl', 'Session',
	'Auth'=>array(
		'authenticate' => array(
            'Form' => array('fields' => array('username' => 'login', 'password'=>'clave'), 'userModel'=>'Usuario')
		),
		'userModel'=>'Usuario',
		'loginRedirect' => array('controller' => 'Usuarios', 'action' => 'login'),
		'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
		'loginAction'=>array('controller' => 'Usuarios', 'action' => 'login'),
		'loginError'=>'Lo siento, la combinación nombre de usuario - contraseña es incorrecta',
		'authError'=>'Debes iniciar sesión para continuar.',
		'autoRedirect'=>true,
		'allowedActions'=>array('display')
	), 
	'RequestHandler', 'Email');
	public $helpers = array('Html', 'Form', 'Session', 'Js'=> array('Jquery'), 'Calendar');
	public $uses= array('Auditoria');
    
	
	public function beforeFilter() {
		//Configure AuthComponent
		//Security::setHash('md5');
		//$this->Auth->authenticate = ClassRegistry::init('Usuario');
		//$this->Auth->authorize = 'crud';
		$this->Auth->authenticate = array(
    		'Form' => array('fields' => array('username' => 'login', 'password'=>'clave'), 'userModel'=>'Usuario'),
    		//'Basic' => array('userModel' => 'Usuario')
		);
		$this->Auth->authError = 'Lo sentimos, pero no estas autorizado para ingresar a este modulo. Debes iniciar sesión o cambiar de usuario.';
		//$this->Auth->authorize = array('Actions' => array('actionPath' => 'controllers/'), 'Controller');
		// Pass settings in
		$this->Auth->authorize = array(
			AuthComponent::ALL => array('actionPath' => 'controllers/'),
			'Actions',
			'Crud'
		);
		$this->Auth->userModel = "Usuario";
		$this->Auth->loginRedirect = '/';
		$this->Auth->ajaxLogin = array('controller'=>'Usuarios', 'action'=>'login');
	}
	
	public function _sendEmail($correos, $asunto, $cuerpo, $template="correo"){
		/*$this->Email->smtpOptions = array(
			'port'=>'25',
			'timeout'=>'60',
			'host' => 'mail.caefii.org.ve',
			'username'=>'sistema+caefii.org.ve',
			'password'=>'dreamteam.77');*/
		/* Configurar método de entrega */
		$this->Email->to = "$correos";
		$this->Email->subject = $asunto;
		$this->Email->from = 'Sistema Administrativo CPDI <cpdi@fii.gob.ve>';
		$this->Email->template = $template;
		$this->Email->sendAs = 'html';
		$this->set('titulo', $asunto);
		$this->set('cuerpo', $cuerpo);
		$this->Email->delivery = 'smtp';
		/* No le pases ningún argumento a send() */
		return $this->Email->send();
		/* Chequeo de errores SMTP. */
		//$this->set('smtp-errors', $this->Email->smtpError);
		//echo $this->Email->smtpError;exit;

	}

	public function getAcoId(){
		$controlador = ucfirst($this->params['controller']);
		$accion = $this->params['action'];
		$acoPadre= $this->Acl->Aco->find('first', array(
			'conditions' => array(
			'Aco.alias' => array($controlador),
		),
		'fields'=>array('id'), 'recursive'=>-1
		));
		$aco = $this->Acl->Aco->find('first', array(
			'conditions' => array(
			'Aco.alias' => $accion,
			'Aco.parent_id' => $acoPadre['Aco']['id'],
		),
		'fields'=>array('id'), 'recursive'=>-1
		));
		return $aco['Aco']['id'];
		
	} 
}
