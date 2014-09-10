<?php
App::uses('AppController', 'Controller');
/**
 * Actividades Controller
 *
 * @property Actividad $Actividad
 */
class ActividadesController extends AppController {
	
	public $components= array('RequestHandler', 'Auth', 'Acl');
	
	function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->autoRedirect = false;
		//$this->Auth->authorize = 'crud';
		//$this->Auth->allowedActions = array();//Descomentar esta linea para las acciones a las cuales queremos dar libre acceso. (Usar * para dar acceso a todas las acciones.)
		$this->Auth->mapActions(
			array(
			//'create' => array(),
			'read' => array('listActividades', 'delete_avance'),
			'update' => array('update_avance'),
			//'delete' => array('evento_personal_delete')
			)
		);
		//$this->Auth->allowedActions = array('*');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Actividad->recursive = 1;
		//echo $this->Auth->user('id');
		$this->paginate = array(
	        'limit' => 25,
	        'order' => array('Actividad.fecha_culminacion' => 'asc')
	    );
	    //$this -> set('actividades', $this -> paginate('Actividad', array('Actividad.responsable_id' => $this -> Auth -> user('id'), 'Actividad.status' => 1)));
		$actividades = $this->paginate(array('Actividad.responsable_id'=>$this->Auth->user('id'), 'Actividad.status'=>1));
		//debug($actividades);
		$this->set('actividades', $actividades);
	}
	
	public function horas(){

	}
	
	public function listActividades(){
		$this->Actividad->recursive = 1;
		//echo $this->Auth->user('id');
		$this->paginate = array(
	        'limit' => 10,
	        'order' => array('Actividad.status, Actividad.fecha_culminacion' => 'asc')
	    );
	    //$this -> set('actividades', $this -> paginate('Actividad', array('Actividad.responsable_id' => $this -> Auth -> user('id'), 'Actividad.status' => 1)));
		$actividades = $this->paginate(array('Actividad.responsable_id'=>$this->Auth->user('id'), 'Actividad.status'=>1));
		//debug($actividades);
		$this->set('actividades', $actividades);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Actividad->id = $id;
		$this->Actividad->recursive = 1;
		if (!$this->Actividad->exists()) {
			throw new NotFoundException(__('Actividad no existe'));
		}
		$actividad = $this->Actividad->read(null, $id);
		$proyecto = $this->Actividad->Objetivo->Proyecto->read(null, $actividad['Objetivo']['proyecto_id']);
		//echo $proyecto['Proyecto']['name'];
		$this->set(compact('actividad', 'proyecto'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($proyecto_id = null, $objetivo_id=null) {
		if ($this->request->is('post')) {
			$this->Actividad->create();
			if ($this->Actividad->save($this->request->data)) {
				$this->Session->setFlash(__('La actividad ha sido agragada con exito!'));
				$this->redirect(array('controller'=>'Proyectos', 'action' => 'view', $proyecto_id));
			} else {
				$this->Session->setFlash(__('The actividad could not be saved. Please, try again.'));
			}
		}
		$this->Actividad->Objetivo->Proyecto->recursive = -1;
		$fechas = $this->Actividad->Objetivo->Proyecto->read('fecha_inicio, fecha_culminacion', $proyecto_id);
		$personal = $this->Actividad->Usuario->find('all', array('fields'=>'id, fullname', 'order'=>'fullname', 'conditions'=>array('Usuario.status'=>1, 'Usuario.rol_id !='=>1)));
		//pr($fechas);
		//$responsables = $this->Actividad->Usuarios->find('list');
		//$vs = $this->Actividad->V->find('list');
		$this->set(compact('objetivo_id', 'proyecto_id', 'personal', 'fechas'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null, $proyecto_id=null) {
		$this->Actividad->id = $id;
		if (!$this->Actividad->exists()) {
			throw new NotFoundException(__('Actividad invalida'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$proyecto_id = $this->request->data['Actividad']['proyecto_id'];
			if ($this->Actividad->save($this->request->data)) {
				$this->Session->setFlash(__('La actividad ha sido modificada con exito.'));
				//echo $proyecto_id;exit;
				$this->redirect(array('controller'=>'Proyectos', 'action'=>'view', $proyecto_id));
			} else {
				$this->Session->setFlash(__('La actividad no fue modificada. Por favor, verifique los datos he intente nuevamente.'));
			}
		} else {
			$this->request->data = $this->Actividad->read(null, $id);
		}
		
		$this->Actividad->Objetivo->Proyecto->recursive = -1;
		$fechas = $this->Actividad->Objetivo->Proyecto->read('fecha_inicio, fecha_culminacion', $this->request->data['Objetivo']['proyecto_id']);		
		$responsable_name = $this->Actividad->Usuario->find('all', array('fields'=>'fullname', 'conditions'=>array('Usuario.id'=>$this->request->data['Actividad']['responsable_id'])));
		$personal = $this->Actividad->Usuario->find('all', array('fields'=>'id, fullname', 'order'=>'fullname', 'conditions'=>array('Usuario.status'=>1, 'Usuario.rol_id !='=>1)));
		//pr($this->request->data);
		$this->request->data['Actividad']['responsable_name'] =  $responsable_name[0]['Usuario']['fullname'];
		$this->Set(compact('personal', 'fechas', 'proyecto_id'));
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
		/*if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}*/
		$this->Actividad->id = $id;
		if (!$this->Actividad->exists()) {
			throw new NotFoundException(__('Actividad invalida'));
		}
		if ($this->Actividad->delete()) {
			$this->Session->setFlash(__('Actividad eliminada con exito'));
			$this->redirect(array('controller'=>'Proyectos', 'action' => 'view', $proyecto_id));
		}
		$this->Session->setFlash(__('La actividad no fue eliminada. Por favor, intente nuevamente'));
		$this->redirect(array('controller'=>'Proyectos', 'action' => 'view', $proyecto_id));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Actividad->recursive = 0;
		$this->set('actividades', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Actividad->id = $id;
		if (!$this->Actividad->exists()) {
			throw new NotFoundException(__('Invalid actividad'));
		}
		$this->set('actividad', $this->Actividad->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Actividad->create();
			if ($this->Actividad->save($this->request->data)) {
				$this->Session->setFlash(__('The actividad has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The actividad could not be saved. Please, try again.'));
			}
		}
		$objetivos = $this->Actividad->Objetivo->find('list');
		$responsables = $this->Actividad->Responsable->find('list');
		$vs = $this->Actividad->V->find('list');
		$this->set(compact('objetivos', 'responsables', 'vs'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Actividad->id = $id;
		if (!$this->Actividad->exists()) {
			throw new NotFoundException(__('Actividad invalida'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Actividad->save($this->request->data)) {
				$this->Session->setFlash(__('La actividad ha sido modificada con exito.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La actividad no fue modificada. Por favor, verifique los datos he intente nuevamente.'));
			}
		} else {
			$this->request->data = $this->Actividad->read(null, $id);
		}
		$objetivos = $this->Actividad->Objetivo->find('list');
		$responsables = $this->Actividad->Responsable->find('list');
		$vs = $this->Actividad->V->find('list');
		$this->set(compact('objetivos', 'responsables', 'vs'));
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
		$this->Actividad->id = $id;
		if (!$this->Actividad->exists()) {
			throw new NotFoundException(__('Invalid actividad'));
		}
		if ($this->Actividad->delete()) {
			$this->Session->setFlash(__('Actividad deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Actividad was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function update_avance($id=null) {
		if(is_null($id)){
			$this->Session->setFlash(__('Actividad invalidad'));
		}
		if (!$this->request->is('post')) {
			$this->Session->setFlash(__('No puede realizar esta acción'));	
		}
		//echo "estoy aqui 1";
		$actividad_id = $this->request->data['Actividad']['actividad_id'];
		$this->Actividad->id = $actividad_id;
		$actividad = $this->Actividad->read(null, $actividad_id);
		$this->set('actividad', $actividad);
		if($this->Auth->user('id') != $actividad['Actividad']['responsable_id']){
			//echo "estoy aqui 2";
			$this->Session->setFlash(__('Lo siento, debe ser el responsable de la actividad para poder actualizar los avances.'));
			$this->redirect(array('controller'=>'Actividades', 'action' => 'view', $actividad_id));
		}else{
			//echo "estoy aqui 3";
			$existe = $this->Actividad->Avance->existe($this->request->data);
			//echo $existe;exit;
			if($existe) $this->Actividad->Avance->id = $existe;
			if($this->Actividad->Avance->save($this->request->data['Actividad'])){
				$this->Session->setFlash(__('Avance de la actividad actualizado con exito!'));
			}else{
				$this->Session->setFlash(__('La actividad no pudo ser actualizada, por favor intente nuevamente.'));
			}
			$this->redirect(array('controller'=>'Actividades', 'action' => 'view', $actividad_id));
		}
		
	}

/**
 * delete_avance method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete_avance($id = null, $actividad_id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Actividad->Avance->id = $id;
		if (!$this->Actividad->Avance->exists()) {
			throw new NotFoundException(__('Avance invalido'));
		}
		if ($this->Actividad->Avance->delete()) {
			$this->Session->setFlash(__('Avance eliminado con exito'));
			$this->redirect(array('action'=>'view', $actividad_id));
		}
		$this->Session->setFlash(__('El avance no fue eliminado. Por favor, intente nuevamente'));
		$this->redirect(array('action'=>'view', $actividad_id));
	}

}
