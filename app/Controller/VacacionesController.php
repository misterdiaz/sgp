<?php
App::uses('AppController', 'Controller');
/**
 * Vacaciones Controller
 *
 * @property Vacacion $Vacacion
 */
class VacacionesController extends AppController {

	public $uses = array('Vacacion', 'DiasDisponibles', 'Periodo');

	//public $destinatarios = array('oabarca@fii.gob.ve', 'aimarar@fii.gob.ve', 'olgam@fii.gob.ve');
	public $destinatarios = array('aimarar@fii.gob.ve', 'olgam@fii.gob.ve');
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->mapActions(
			array(
			//'create' => array(),
			//'read' => array(),
			'update' => array('solicitarDisponibles'),
			//'delete' => array()
			)
		);
		$this->Auth->allowedActions = array('calcularFechaHasta');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Vacacion->recursive = 0;
		$this->set('vacaciones', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Vacacion->id = $id;
		if (!$this->Vacacion->exists()) {
			throw new NotFoundException(__('Invalid vacacion'));
		}
		$this->set('vacacion', $this->Vacacion->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Vacacion->create();
			if ($this->Vacacion->save($this->request->data)) {
				$this->Session->setFlash(__('The vacacion has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vacacion could not be saved. Please, try again.'));
			}
		}
		$usuarios = $this->Vacacion->Usuario->find('list');
		$periodos = $this->Vacacion->Periodo->find('list');
		$this->set(compact('usuarios', 'periodos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Vacacion->id = $id;
		if (!$this->Vacacion->exists()) {
			throw new NotFoundException(__('Invalid vacacion'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Vacacion->save($this->request->data)) {
				$this->Session->setFlash(__('The vacacion has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vacacion could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Vacacion->read(null, $id);
		}
		$usuarios = $this->Vacacion->Usuario->find('list');
		$periodos = $this->Vacacion->Periodo->find('list');
		$this->set(compact('usuarios', 'periodos'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Vacacion->id = $id;
		if (!$this->Vacacion->exists()) {
			throw new NotFoundException(__('Invalid vacacion'));
		}
		if ($this->Vacacion->delete()) {
			$this->Session->setFlash(__('Vacacion deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Vacacion was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Vacacion->recursive = 0;
		$this->set('vacaciones', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Vacacion->id = $id;
		if (!$this->Vacacion->exists()) {
			throw new NotFoundException(__('Invalid vacacion'));
		}
		$this->set('vacacion', $this->Vacacion->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Vacacion->create();
			if ($this->Vacacion->save($this->request->data)) {
				$this->Session->setFlash(__('The vacacion has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vacacion could not be saved. Please, try again.'));
			}
		}
		$usuarios = $this->Vacacion->Usuario->find('list');
		$periodos = $this->Vacacion->Periodo->find('list');
		$this->set(compact('usuarios', 'periodos'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Vacacion->id = $id;
		if (!$this->Vacacion->exists()) {
			throw new NotFoundException(__('Invalid vacacion'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Vacacion->save($this->request->data)) {
				$this->Session->setFlash(__('The vacacion has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vacacion could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Vacacion->read(null, $id);
		}
		$usuarios = $this->Vacacion->Usuario->find('list');
		$periodos = $this->Vacacion->Periodo->find('list');
		$this->set(compact('usuarios', 'periodos'));
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Vacacion->id = $id;
		if (!$this->Vacacion->exists()) {
			throw new NotFoundException(__('Invalid vacacion'));
		}
		if ($this->Vacacion->delete()) {
			$this->Session->setFlash(__('Vacacion deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Vacacion was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function solicitarDisponibles() {
		$periodos = $this->Periodo->Find('all', array(
				'conditions'=>array('usuario_id'=>$this->Auth->user('id'), 'disponible >'=>0),
				'recursive'=>-1,
				'order'=>'year ASC',
			));
		$dias_disponibles = $this->Periodo->field('SUM(disponible)', array('usuario_id'=>$this->Auth->user('id')));
		$this->set(compact('periodos', 'dias_disponibles'));
		if ($this->request->is('post')) {
			$nro_dias = $this->request->data['nro_dias'];
			$total_dias = 0;
			$usuario_id = $this->Auth->user('id');
			$date_desde = $this->request->data['Vacacion']['fecha_desde']['year']."-".$this->request->data['Vacacion']['fecha_desde']['month']."-".$this->request->data['Vacacion']['fecha_desde']['day'];
			$sql = "BEGIN;";
			$this->Vacacion->query($sql);
			foreach ($nro_dias as $year => $cant) {
				$total_dias += $cant;
				try {
					$sql = "UPDATE periodos SET disponible = disponible - $cant WHERE usuario_id=$usuario_id AND year = $year;";
					$this->Vacacion->query($sql);
				} catch (Exception $e) {
					$this->Session->setFlash('Problemas con la solicitud al solicitar los días disponibles');
					$this->Vacacion->query("ROLLBACK;");
					return;
				}
			}
			$this->request->data['Vacacion']['nro_dias'] = $total_dias;
			$this->request->data['Vacacion']['fecha_hasta'] = $this->_calcularFechaHasta($date_desde, $total_dias);
			$this->Vacacion->create();
			if($this->Vacacion->save($this->request->data)){
				$this->Vacacion->query("COMMIT;");
				$this->Session->setFlash('La solicitud ha sido registrada con exito.');
				$datos['fecha_desde'] = $this->request->data['Vacacion']['fecha_desde'];
				$datos['fecha_incorporacion'] = $this->_calcularFechaHasta($date_desde, $total_dias+1);
				$datos['nro_dias'] = $total_dias;
				$this->_enviarCorreo(null, $this->Auth->user('email'), 'Solicitud de Vacaciones (días disponibles)', 'solicitud', 'html', $datos);
				$this->redirect(array('controller'=>'Panel', 'action' => 'index'));
			}else{
				$this->Session->setFlash('Problemas con la solicitud');
				$this->Vacacion->query("ROLLBACK;");
			}	
			
		}
		
	}

	public function _calcularFechaHasta($fecha_desde, $maxDias){
		//Esta pequeña funcion me crea una fecha de entrega sin sabados ni domingos
	    //Creamos un for desde 0 hasta maximo de dias
	    $segundos = 0;
	    $inicio = strtotime($fecha_desde);
	    $fecha_hasta = $fecha_desde;
	    for ($i=0; $i < $maxDias-1; $i++){
			//Acumulamos la cantidad de segundos que tiene un dia en cada vuelta del for
			$segundos += 86400;
			//Obtenemos el dia de la fecha, aumentando el tiempo en N cantidad de dias, segun la vuelta en la que estemos
			$caduca = date("D",$inicio+$segundos);
			
	        //Comparamos si estamos en sabado o domingo, si es asi restamos una vuelta al for, para brincarnos el o los dias...
			if ($caduca == "Sat") $i--;
			else if ($caduca == "Sun") $i--;
			else $fecha_hasta = date("Y-m-d", $inicio + $segundos);//Si no es sabado o domingo, y el for termina y nos muestra la nueva fecha
		}
		return $fecha_hasta;
	}

	public function registrarDisponibles() {
		if ($this->request->is('post')) {
			if($this->Periodo->existe($this->request->data)){
				if($this->Periodo->update($this->request->data)){
					$this->Session->setFlash('Dias disponibles registrados con exito');
					$this->redirect(array('controller'=>'Panel', 'action' => 'index'));
				}else{
					$this->Session->setFlash('Los Dias disponibles no fueron registrados. Por favor, intente nuevamente.1');
				}
			}else{
				if($this->Periodo->save($this->request->data)){
					$this->Session->setFlash('Dias disponibles registrados con exito');
					$this->redirect(array('controller'=>'Panel', 'action' => 'index'));
				}else{
					$this->Session->setFlash('Los Dias disponibles no fueron registrados. Por favor, intente nuevamente.2');
				}
			}
			
		}
		$personal = $this->Vacacion->Usuario->find('all', array('fields'=>'id, fullname', 'order'=>'fullname', 'conditions'=>array('Usuario.status'=>1, 'Usuario.rol_id !='=>1)));
		$this->set(compact('personal'));
	}

	/**
 * Metodo para enviar correos
 *
 * @param string $from Sender email
 * @param string $to Receiver email
 * @param string $subject Subject
 * @param string $template Template to use
 * @param array  $viewVars Vars to use inside template
 * @param string $emailType user activation, reset password, used in log message when failing.
 * @return boolean True if email was sent, False otherwise.
 */
	protected function _enviarCorreo($from=null, $to, $subject, $template, $emailType='html', $viewVars = null) {
		if(is_null($from)) $from = array('CPDI', 'cpdi@fii.gob.ve');

		$success = false;
		array_push($this->destinatarios, $to);
		try {
			$email = new CakeEmail('mandrill');
			$email->from($from[1], $from[0]);
			$email->to($this->destinatarios);
			$email->subject($subject);
			$email->template($template);
			$email->viewVars($viewVars);

			$success = $email->send();
			//print_r($success);exit;
		} catch (SocketException $e) {
			$this->log(sprintf('Error sending %s notification : %s', $emailType, $e->getMessage()));
		}

		return $success;
	}
}
