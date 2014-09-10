<?php
App::uses('AppController', 'Controller');
/**
 * Vacaciones Controller
 *
 * @property Vacacion $Vacacion
 */
class VacacionesController extends AppController {

	public $uses = array('Vacacion', 'DiasDisponibles', 'Periodo');

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
		//$this->Auth->allowedActions = array('admin_index');
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
				'conditions'=>array('usuario_id'=>$this->Auth->user('id')),
				'recursive'=>-1,
				'order'=>'year ASC',
			));
		$this->set(compact('periodos'));
		if ($this->request->is('post')) {
			$nro_dias = $this->request->data['nro_dias'];
			$total_dias = 0;
			$usuario_id = $this->Auth->user('id');
			$sql = "BEGIN;";
			$this->Vacacion->query($sql);
			foreach ($nro_dias as $year => $cant) {
				$total_dias += $cant;
				try {
					$sql = "UP3DATE periodos SET disponible = disponible - $cant WHERE usuario_id=$usuario_id AND year = $year;";
					$this->Vacacion->query($sql);
				} catch (Exception $e) {
					$this->Session->setFlash('Problemas con la solicitud al solicitar los días disponibles');
					$this->Vacacion->query("ROLLBACK;");
					return;
				}
			}
			$this->request->data['Vacacion']['nro_dias'] = $total_dias;
			$this->Vacacion->create();
			if($this->Vacacion->save($this->request->data)){
				$this->Vacacion->query("COMMIT;");
				$this->Session->setFlash('La solicitud ha sido registrada con exito.');
				$this->redirect(array('controller'=>'Panel', 'action' => 'index'));
			}else{
				$this->Session->setFlash('Problemas con la solicitud');
				$this->Vacacion->query("ROLLBACK;");
			}	
			
		}
		
	}
}
