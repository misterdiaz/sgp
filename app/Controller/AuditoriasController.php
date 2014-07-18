<?php
App::uses('AppController', 'Controller');
/**
 * Auditorias Controller
 *
 * @property Auditoria $Auditoria
 */
class AuditoriasController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Auditoria->recursive = 0;
		$this->set('auditorias', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Auditoria->id = $id;
		if (!$this->Auditoria->exists()) {
			throw new NotFoundException(__('Invalid auditoria'));
		}
		$this->set('auditoria', $this->Auditoria->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Auditoria->create();
			if ($this->Auditoria->save($this->request->data)) {
				$this->Session->setFlash(__('The auditoria has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The auditoria could not be saved. Please, try again.'));
			}
		}
		$acos = $this->Auditoria->Aco->find('list');
		$usuarios = $this->Auditoria->Usuario->find('list');
		$this->set(compact('acos', 'usuarios'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Auditoria->id = $id;
		if (!$this->Auditoria->exists()) {
			throw new NotFoundException(__('Invalid auditoria'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Auditoria->save($this->request->data)) {
				$this->Session->setFlash(__('The auditoria has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The auditoria could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Auditoria->read(null, $id);
		}
		$acos = $this->Auditoria->Aco->find('list');
		$usuarios = $this->Auditoria->Usuario->find('list');
		$this->set(compact('acos', 'usuarios'));
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
		$this->Auditoria->id = $id;
		if (!$this->Auditoria->exists()) {
			throw new NotFoundException(__('Invalid auditoria'));
		}
		if ($this->Auditoria->delete()) {
			$this->Session->setFlash(__('Auditoria deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Auditoria was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Auditoria->recursive = 0;
		$this->set('auditorias', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Auditoria->id = $id;
		if (!$this->Auditoria->exists()) {
			throw new NotFoundException(__('Invalid auditoria'));
		}
		$this->set('auditoria', $this->Auditoria->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Auditoria->create();
			if ($this->Auditoria->save($this->request->data)) {
				$this->Session->setFlash(__('The auditoria has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The auditoria could not be saved. Please, try again.'));
			}
		}
		$acos = $this->Auditoria->Aco->find('list');
		$usuarios = $this->Auditoria->Usuario->find('list');
		$this->set(compact('acos', 'usuarios'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Auditoria->id = $id;
		if (!$this->Auditoria->exists()) {
			throw new NotFoundException(__('Invalid auditoria'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Auditoria->save($this->request->data)) {
				$this->Session->setFlash(__('The auditoria has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The auditoria could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Auditoria->read(null, $id);
		}
		$acos = $this->Auditoria->Aco->find('list');
		$usuarios = $this->Auditoria->Usuario->find('list');
		$this->set(compact('acos', 'usuarios'));
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
		$this->Auditoria->id = $id;
		if (!$this->Auditoria->exists()) {
			throw new NotFoundException(__('Invalid auditoria'));
		}
		if ($this->Auditoria->delete()) {
			$this->Session->setFlash(__('Auditoria deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Auditoria was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
