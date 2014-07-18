<?php
class NivelesController extends AppController {

	var $name = 'Niveles';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Nivel->recursive = 0;
		$this->set('niveles', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Nivele.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('nivele', $this->Nivel->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Nivel->create();
			if ($this->Nivel->save($this->data)) {
				$this->Session->setFlash(__('The Nivele has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Nivele could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Nivele', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Nivel->save($this->data)) {
				$this->Session->setFlash(__('The Nivele has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Nivele could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Nivel->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Nivele', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Nivel->del($id)) {
			$this->Session->setFlash(__('Nivele deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>