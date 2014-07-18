<?php
class RolesController extends AppController {

	var $name = 'Roles';
	
	public $paginate = array(
        'Rol' => array ('limit' => 25, 'order' => array('Rol.id' => 'asc')),
    );
	
	function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->authorize = 'crud';
		//$this->Auth->allowedActions = array('*');//Descomentar esta linea para las acciones a las cuales queremos dar libre acceso. (Usar * para dar acceso a todas las acciones.)
	}

	function admin_index() {
		$this->Rol->recursive = 0;
		$this->set('roles', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'rol'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('rol', $this->Rol->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Rol->create();
			$this->request->data['Rol']['alias'] = $this->data['Rol']['nombre']; 
			if ($this->Rol->save($this->request->data)) {
				$this->Session->setFlash('El Rol ha sido creado con exito.');
				$this->redirect(array('action' => 'index', 'admin'=>true));
			} else {
				$this->Session->setFlash('El Rol no fue creado. Por favor, intente nuevamente.');
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Rol Invalido');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Rol->save($this->data)) {
				$this->Session->setFlash('El Rol ha sido modificado con exito.');
				$this->redirect(array('action' => 'index', 'admin'=>true));
			} else {
				$this->Session->setFlash('El Rol no fue modificado. Por favor, intente nuevamente.');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Rol->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Rol Invalido');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Rol->delete($id)) {
			$this->Session->setFlash('El Rol ha sido eliminado con exito.');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('El Rol no fue eliminado. Posiblemente existan datos asociados a dicho rol.');
		$this->redirect(array('action' => 'index'));
	}
}
?>