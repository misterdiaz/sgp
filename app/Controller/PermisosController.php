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
		$this->set('permiso', $this->Permiso->read(null, $id));
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
			$fecha_hasta = date_create($fecha_desde);
			$fecha_hasta = date_add($fecha_hasta, date_interval_create_from_date_string($nro_dias.' days'));
			//echo date_format($fecha_hasta, 'Y-m-d');exit;
			$this->request->data['Permiso']['fecha_hasta'] = date_format($fecha_hasta, 'Y-m-d');
			if($nro_dias == 0) $this->request->data['Permiso']['nro_dias'] = '0.5';
			if ($this->Permiso->save($this->request->data)) {
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
		}
		$this->Session->setFlash(__('Permiso was not deleted'));
		$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));
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

}
