<?php
App::uses('AppController', 'Controller');
/**
 * TipoActividades Controller
 *
 * @property TipoActividad $TipoActividad
 */
class TipoActividadesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TipoActividad->recursive = 0;
		$this->set('tipoActividades', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->TipoActividad->id = $id;
		if (!$this->TipoActividad->exists()) {
			throw new NotFoundException(__('Invalid tipo actividad'));
		}
		$this->set('tipoActividad', $this->TipoActividad->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TipoActividad->create();
			if ($this->TipoActividad->save($this->request->data)) {
				$this->Session->setFlash(__('The tipo actividad has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tipo actividad could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->TipoActividad->id = $id;
		if (!$this->TipoActividad->exists()) {
			throw new NotFoundException(__('Invalid tipo actividad'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TipoActividad->save($this->request->data)) {
				$this->Session->setFlash(__('The tipo actividad has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tipo actividad could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TipoActividad->read(null, $id);
		}
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
		$this->TipoActividad->id = $id;
		if (!$this->TipoActividad->exists()) {
			throw new NotFoundException(__('Invalid tipo actividad'));
		}
		if ($this->TipoActividad->delete()) {
			$this->Session->setFlash(__('Tipo actividad deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tipo actividad was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->TipoActividad->recursive = 0;
		$this->set('tipoActividades', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->TipoActividad->id = $id;
		if (!$this->TipoActividad->exists()) {
			throw new NotFoundException(__('Invalid tipo actividad'));
		}
		$this->set('tipoActividad', $this->TipoActividad->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->TipoActividad->create();
			if ($this->TipoActividad->save($this->request->data)) {
				$this->Session->setFlash(__('The tipo actividad has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tipo actividad could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->TipoActividad->id = $id;
		if (!$this->TipoActividad->exists()) {
			throw new NotFoundException(__('Invalid tipo actividad'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TipoActividad->save($this->request->data)) {
				$this->Session->setFlash(__('The tipo actividad has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tipo actividad could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TipoActividad->read(null, $id);
		}
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
		$this->TipoActividad->id = $id;
		if (!$this->TipoActividad->exists()) {
			throw new NotFoundException(__('Invalid tipo actividad'));
		}
		if ($this->TipoActividad->delete()) {
			$this->Session->setFlash(__('Tipo actividad deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tipo actividad was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
