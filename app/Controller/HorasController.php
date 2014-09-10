<?php
App::uses('AppController', 'Controller');
/**
 * Horas Controller
 *
 * @property Hora $Hora
 */
class HorasController extends AppController {

	public $components = array('Date');
	public $uses = array('Hora', 'ReporteActividad');
	
	function beforeFilter() {
		//pr($this->Auth);
		parent::beforeFilter();

		//$this->Auth->autoRedirect = false;
		//$this->Auth->authorize = array('Actions');
		$this -> Auth -> mapActions(array(
			'create' => array(), 
			'read' => array('dedicacion'), 
			'update' => array(),
			'delete' => array()
		));

		//$this->Auth->allowedActions = array('index');//Descomentar esta linea para las acciones a las cuales queremos dar libre acceso. (Usar * para dar acceso a todas las acciones.)
	}
	
/**
 * index method
 *
 * @return void
 */
	public function dedicacion($semana=null) {
		$this->Hora->recursive = 0;
		if(is_null($semana)){
			$rango = $this->Date->get_rango_semana_laboral_actual();
			$semana = date('W');
		}else{
			$rango = $this->Date->get_rango_semana_laboral($semana);
		}
		
		
		$conditions = "semana = $semana";
		$this->set('horas', $this->paginate('Hora', array($conditions)));
		$this->set(compact('rango', 'semana'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Hora->id = $id;
		if (!$this->Hora->exists()) {
			throw new NotFoundException(__('Registro invalido'));
		}
		$tipoActividades = $this->Hora->TipoActividad->find('list');
		$actividades = $this->ReporteActividad->find('list', array(
			'conditions'=>array('responsable_id'=>$this->Auth->user('id'), 'status'=>1, 'month(fecha_inicio) between ? and ?'=>array(1, 6), 'year(fecha_inicio)'=>date('Y')),
			'fields'=>'actividad_id, actividad'
		));
		$this->set(compact('tipoActividades', 'actividades'));
		$this->request->data= $this->Hora->read(null, $id);
		//$this->set('hora', $this->Hora->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($semana=null) {
		if ($this->request->is('post')) {
			$this->Hora->create();
			if ($this->Hora->save($this->request->data)) {
				$this->Session->setFlash(__('Las horas de dedicación han sido registradas con exito'));
				$this->request->data = array();
				//$this->redirect(array('action' => 'dedicacion'));
			} else {
				$this->Session->setFlash(__('El registro no fue completado. Por favor, intente nuevamente.'));
			}
		}
		if ($semana > date('W')) {
			$this->Session->setFlash(__('Lo siento, la operación que desea realizar no esta permitida.'));
			$this->redirect(array('action' => 'dedicacion'));
		}
		if(is_null($semana)){
			$semana = date('W');
		}
		$tipoActividades = $this->Hora->TipoActividad->find('list');
		$actividades = $this->ReporteActividad->find('list', array(
			'conditions'=>array('responsable_id'=>$this->Auth->user('id'), 'status'=>1, 'month(fecha_inicio) between ? and ?'=>array(1, 6), 'year(fecha_inicio)'=>date('Y')),
			'fields'=>'actividad_id, actividad'
		));
		$horas = $this->Hora->find('all', array(
			'conditions'=>array('semana'=>$semana)
		));
		$this->set(compact('tipoActividades', 'actividades', 'semana', 'horas'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Hora->id = $id;
		if (!$this->Hora->exists()) {
			throw new NotFoundException(__('Registro invalido'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Hora->save($this->request->data)) {
				$this->Session->setFlash(__('Las horas de dedicación han sido modificadas con exito'));
				$this->redirect(array('action' => 'dedicacion'));
			} else {
				$this->Session->setFlash(__('El registro no fue completado. Por favor, intente nuevamente.'));
			}
		} else {
			$this->request->data = $this->Hora->read(null, $id);
		}
		$tipoActividades = $this->Hora->TipoActividad->find('list');
		$actividades = $this->ReporteActividad->find('list', array(
			'conditions'=>array('responsable_id'=>$this->Auth->user('id'), 'status'=>1, 'month(fecha_inicio) between ? and ?'=>array(1, 6), 'year(fecha_inicio)'=>$this->request->data['Hora']['year']),
			'fields'=>'actividad_id, actividad'
		));
		$this->set(compact('tipoActividades', 'actividades'));
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
		$this->Hora->id = $id;
		if (!$this->Hora->exists()) {
			throw new NotFoundException(__('Registro invalido'));
		}
		if ($this->Hora->delete()) {
			$this->Session->setFlash(__('Registro de horas dedicadas ha sido eliminado con exito'));
			$this->redirect(array('action' => 'dedicacion'));
		}
		$this->Session->setFlash(__('Registro de horas dedicadas no fue eliminado. Por favor, intente nuevamente.'));
		$this->redirect(array('action' => 'dedicacion'));
	}
}
