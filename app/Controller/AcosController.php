<?php
class AcosController extends AppController {

	var $name = 'Acos';
	var $helpers = array('Html', 'Form');

	function admin_index() {
		$this->Aco->recursive = 0;
		$this->set('acos', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Aco.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('aco', $this->Aco->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Aco->create();
			if ($this->Aco->save($this->data)) {
				$this->Session->setFlash(__('The Aco has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Aco could not be saved. Please, try again.', true));
			}
		}
		$aros = $this->Aco->Aro->find('list');
		$this->set(compact('aros'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Aco', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Aco->save($this->data)) {
				$this->Session->setFlash(__('The Aco has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Aco could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Aco->read(null, $id);
		}
		$aros = $this->Aco->Aro->find('list');
		$this->set(compact('aros'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Aco', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Aco->del($id)) {
			$this->Session->setFlash(__('Aco deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>