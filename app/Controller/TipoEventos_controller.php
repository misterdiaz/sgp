<?php
class TipoEventosController extends AppController {

	var $name = 'TipoEventos';
	var $helpers = array('Html', 'Form');


	function admin_index() {
		$this->layout = "admin";
		$this->TipoEvento->recursive = 0;
		$this->set('tipoEventos', $this->paginate());
	}

	function admin_view($id = null) {
		$this->layout = "ajax";
		if (!$id) {
			$this->Session->setFlash(__('Tipo de Evento Invalido.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tipoEvento', $this->TipoEvento->read(null, $id));
	}

	function admin_add() {
		$this->layout = "admin";
		if (!empty($this->data)) {
			$this->TipoEvento->create();
			if ($this->TipoEvento->save($this->data)) {
				$this->Session->setFlash(__('El Tipo de Evento ha sido guardado con exito.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('El Tipo de Evento no pudo ser guardado. Por favor, verifique los datos he intente nuevamente.', true));
			}
		}
	}

	function admin_edit($id = null) {
		$this->layout = "ajax";
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Tipo de Evento Invalido.', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TipoEvento->save($this->data)) {
				$this->Session->setFlash(__('El Tipo de Evento ha sido modificado con exito.', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('El Tipo de Evento no pudo ser modificado. Por favor, verifique los datos he intente nuevamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TipoEvento->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		$this->layout = "admin";
		if (!$id) {
			$this->Session->setFlash(__('Tipo de Evento Invalido.', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TipoEvento->delete($id)) {
			$this->Session->setFlash(__('El Tipo de Evento ha sido modificado con exito.', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>