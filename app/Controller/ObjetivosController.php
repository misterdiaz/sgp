<?php
App::uses('AppController', 'Controller');
/**
 * Objetivos Controller
 *
 * @property Objetivo $Objetivo
 */
class ObjetivosController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Objetivo->recursive = 0;
		$this->set('objetivos', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Objetivo->id = $id;
		if (!$this->Objetivo->exists()) {
			throw new NotFoundException(__('Invalid objetivo'));
		}
		$this->set('objetivo', $this->Objetivo->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($proyecto_id=null) {
		if ($this->request->is('post') && !is_null($proyecto_id)) {
			$this->Objetivo->create();
			if ($this->Objetivo->save($this->request->data)) {
				$this->Session->setFlash(__('El objetivo ha sido agregado con exito!'));
				$this->redirect(array('controller'=>'Proyectos', 'action' => 'view', $proyecto_id));
			} else {
				$this->Session->setFlash(__('The objetivo could not be saved. Please, try again.'));
			}
		}
		$proyectos = $this->Objetivo->Proyecto->find('list');
		
		$this->set(compact('proyectos', 'proyecto_id'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Objetivo->id = $id;
		if (!$this->Objetivo->exists()) {
			throw new NotFoundException(__('Objetivo Especifico no existe'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			//pr($this->request->data);exit;
			if ($this->Objetivo->save($this->request->data)) {
				$this->Session->setFlash(__('El objetivo especifico ha sido modificado con exito'));
				$this->redirect(array('controller'=>'Proyectos','action' => 'view', $this->request->data['Objetivo']['proyecto_id']));
			} else {
				$this->Session->setFlash(__('El objetivo especifico no pudo ser modificado. Por favor, intente nuevamente.'));
			}
		} else {
			$this->request->data = $this->Objetivo->read(null, $id);
		}
		$proyectos = $this->Objetivo->Proyecto->find('list');
		$this->set(compact('proyectos'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null, $proyecto_id=null) {
		$this->Objetivo->id = $id;
		if (!$this->Objetivo->exists()) {
			throw new NotFoundException(__('Objetivo no existe'));
		}
		if ($this->Objetivo->delete()) {
			$this->Session->setFlash(__('Objetivo eliminado con exito'));
			$this->redirect(array('controller'=>'Proyectos', 'action' => 'view', $proyecto_id));
		}
		$this->Session->setFlash(__('El Objetivo no fue eliminado'));
		$this->redirect(array('controller'=>'Proyectos', 'action' => 'view', $proyecto_id));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Objetivo->recursive = 0;
		$this->set('objetivos', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Objetivo->id = $id;
		if (!$this->Objetivo->exists()) {
			throw new NotFoundException(__('Invalid objetivo'));
		}
		$this->set('objetivo', $this->Objetivo->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Objetivo->create();
			if ($this->Objetivo->save($this->request->data)) {
				$this->Session->setFlash(__('The objetivo has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The objetivo could not be saved. Please, try again.'));
			}
		}
		$proyectos = $this->Objetivo->Proyecto->find('list');
		$this->set(compact('proyectos'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Objetivo->id = $id;
		if (!$this->Objetivo->exists()) {
			throw new NotFoundException(__('Invalid objetivo'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Objetivo->save($this->request->data)) {
				$this->Session->setFlash(__('The objetivo has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The objetivo could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Objetivo->read(null, $id);
		}
		$proyectos = $this->Objetivo->Proyecto->find('list');
		$this->set(compact('proyectos'));
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
		$this->Objetivo->id = $id;
		if (!$this->Objetivo->exists()) {
			throw new NotFoundException(__('Invalid objetivo'));
		}
		if ($this->Objetivo->delete()) {
			$this->Session->setFlash(__('Objetivo deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Objetivo was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
