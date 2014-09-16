<?php
App::uses('AppController', 'Controller');
/**
 * Permisos Controller
 *
 * @property Permiso $Permiso
 */
class PermisosController extends AppController {

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->mapActions(
			array(
			'create' => array('aprobar', 'denegar'),
			//'read' => array(),
			//'update' => array(),
			//'delete' => array()
			)
		);
		//$this->Auth->allowedActions = array('admin_index');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Permiso->recursive = 0;
		$this->set('permisos', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Invalid permiso'));
		}
		$centros = $this->Permiso->Centro->find('list');
		$permiso = $this->Permiso->read(null, $id);
		$this->set(compact('permiso', 'centros'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Permiso->create();
			//pr($this->request->data);exit;
			$nro_dias = $this->request->data['Permiso']['nro_dias'];
			//pr($this->request->data['Permiso']['fecha_desde']);
			$fecha_desde = $this->request->data['Permiso']['fecha_desde']['year']."-".$this->request->data['Permiso']['fecha_desde']['month'].'-'.$this->request->data['Permiso']['fecha_desde']['day'];
			$fecha_hasta = $this->_calcularFechaHasta($fecha_desde, $nro_dias);
			//echo date_format($fecha_hasta, 'Y-m-d');exit;
			$this->request->data['Permiso']['fecha_hasta'] = $fecha_hasta;
			if($nro_dias == 0) $this->request->data['Permiso']['nro_dias'] = '0.5';
			if ($this->Permiso->save($this->request->data)) {
				$datos['fecha_desde'] = $fecha_desde;
				$datos['nro_dias'] = $nro_dias;
				$this->_enviarCorreo(null, $this->Auth->user('email'), 'Solicitud de Permiso', 'permiso', 'html', $datos);
				$this->Session->setFlash(__('El permiso ha sido solicitado.'));
				$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));
			} else {
				$this->Session->setFlash(__('The permiso could not be saved. Please, try again.'));
			}
		}
		$usuarios = $this->Permiso->Usuario->find('list');
		$centros = $this->Permiso->Centro->find('list');
		$this->set(compact('usuarios', 'centros'));
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

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Invalid permiso'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$nro_dias = $this->request->data['Permiso']['nro_dias'];
			//pr($this->request->data['Permiso']['fecha_desde']);
			$fecha_desde = $this->request->data['Permiso']['fecha_desde']['year']."-".$this->request->data['Permiso']['fecha_desde']['month'].'-'.$this->request->data['Permiso']['fecha_desde']['day'];
			$fecha_hasta = date_create($fecha_desde);
			$fecha_hasta = date_add($fecha_hasta, date_interval_create_from_date_string($nro_dias.' days'));
			//echo date_format($fecha_hasta, 'Y-m-d');exit;
			$this->request->data['Permiso']['fecha_hasta'] = date_format($fecha_hasta, 'Y-m-d');
			if($nro_dias == 0) $this->request->data['Permiso']['nro_dias'] = '0.5';
			if ($this->Permiso->save($this->request->data)) {
				$this->Session->setFlash(__('La solicitud de permiso ha sido modificada.'));
				$this->redirect(array('controller'=>'Panel', 'action' => 'index'));
			} else {
				$this->Session->setFlash('La solicitud de permiso no fue modificada. Por favor, intente nuevamente.');
			}
		} else {
			$this->request->data = $this->Permiso->read(null, $id);
		}
		$usuarios = $this->Permiso->Usuario->find('list');
		$centros = $this->Permiso->Centro->find('list');
		$this->set(compact('usuarios', 'centros'));
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
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Permiso invalido'));
		}
		if ($this->Permiso->delete()) {
			$this->Session->setFlash(__('Permiso eliminado con exito'));
			$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));
		}else{
			$this->Session->setFlash(__('El Permiso no fue eliminado. Por favor intente nuevamente.'));
			$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));	
		}
		
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Permiso->recursive = 0;
		$this->set('permisos', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Invalid permiso'));
		}
		$this->set('permiso', $this->Permiso->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Permiso->create();
			if ($this->Permiso->save($this->request->data)) {
				$this->Session->setFlash(__('The permiso has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The permiso could not be saved. Please, try again.'));
			}
		}
		$usuarios = $this->Permiso->Usuario->find('list');
		$centros = $this->Permiso->Centro->find('list');
		$this->set(compact('usuarios', 'centros'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Invalid permiso'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Permiso->save($this->request->data)) {
				$this->Session->setFlash(__('The permiso has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The permiso could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Permiso->read(null, $id);
		}
		$usuarios = $this->Permiso->Usuario->find('list');
		$centros = $this->Permiso->Centro->find('list');
		$this->set(compact('usuarios', 'centros'));
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
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Invalid permiso'));
		}
		if ($this->Permiso->delete()) {
			$this->Session->setFlash(__('Permiso deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Permiso was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function aprobar($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) throw new NotFoundException(__('Permiso Invalido'));

		if($this->Permiso->aprobar($id)) $this->Session->setFlash('El permiso fue aprobado con éxito.');

		else $this->Session->setFlash('El permiso no fue aprobado.');

		$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));
	}

	public function denegar($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) throw new NotFoundException(__('Permiso Invalido'));

		if($this->Permiso->denegar($id)) $this->Session->setFlash('El permiso fue denegado con éxito.');

		else $this->Session->setFlash('El permiso no fue denegado. Por favor, intente nuevamente');

		$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));
	}

	public function generarPdf($id = null) {
		if (!$this->request->is('post')) {
			$this->Session->setFlash('Opción no permitida');
		}
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) throw new NotFoundException(__('Permiso Invalido'));

		$this->set('Permiso', $this->Permiso->read(null, $id));
		$this->layout = "pdf";
	}

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
