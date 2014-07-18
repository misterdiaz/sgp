<?php

/**
* Example controller for the Calendar Helper
*
*	Copyright 2008 John Elliott
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
*
* @author John Elliott
* @copyright 2008 John Elliott
* @link http://www.flipflops.org More Information
* @license			http://www.opensource.org/licenses/mit-license.php The MIT License
*
*/

App::uses('Sanitize', 'Utility');

class EventsController extends AppController {

	public $name = 'Events';
	public $uses = array('Event', 'VActividad', 'Usuario');
	public $helpers = array('Html', 'Form', 'Calendar', 'Js'=> array('Jquery'));
	public $components = array('RequestHandler', 'Session', 'Acl', 'Auth');
	
	public $paginate = array(
        'Event' => array ('limit' => 10, 'order' => array('Event.event_date' => 'DESC')),
    );
	
	/**
	* the idea is that the calendar helper itself is purely a shell
	* the calendar will just display whatever is sent to it
	* anything you want to do to it is put togthere here in the controller or in a component when I get around to writing it
	*
	*	@param $year string
	* @param $month string
	*
	**/
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->autoRedirect = false;
		//$this->Auth->authorize = 'crud';
		$this->Auth->mapActions(
			array(
			'create' => array(),
			'read' => array(),
			'update' => array(),
			'delete' => array('reportes', 'generar_reporte')
			)
		);
		$this->Auth->allowedActions = array('parametros', 'calendar');//Descomentar esta linea para las acciones a las cuales queremos dar libre acceso. (Usar * para dar acceso a todas las acciones.)
	}
	
	function parametros(){
		if($this->params['requested']){
			$year = $this->params['pProyectoass'][0];
			$month = $this->params['pass'][1];
			$this->Event->recursive = 0;
			
			$month_list = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
			$day_list = array('Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom');
			$base_url = $this->webroot . 'events/calendar'; // NOT not used in the current helper version but used in the data array
			$view_base_url = $this->webroot. 'events';
			
			
			$data = null;
		
			
			if(!$year || !$month)
				{
					$year = date('Y');
	//				$month = date('M');
					$month_num = date('n');
					$month = mes2letras($month_num);
					$item = null;
				}
				
			$flag = 0;
					
			for($i = 0; $i < 12; $i++) { // check the month is valid if set
					if(strtolower($month) == $month_list[$i])
						{
							if(intval($year) != 0)
								{
									$flag = 1;
									$month_num = $i + 1;
									$month_name = $month_list[$i];
									break;
								}
						}
				}
						
			if($flag == 0) { // if no date set, then use the default values
					$year = date('Y');
					$month = date('M');
					$month_name = date('F');
					$month_num = date('m');
			}
			
			$fields = array("id", "name", "day(event_date) AS event_day");
			$var = $this->Event->find(
				'all', 
				array(
					'conditions' => array(" MONTH(Event.event_date)" => $month_num, "YEAR(Event.event_date)" => $year), //array de condiciones
					'recursive' => 1, //int
			 		'fields' => $fields, //array de nombres de campos
					'order' => "Event.event_date ASC", //string o array definiendo el orden
					'group' => array(), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			
			/**
			* loop through the returned data and build an array of 'events' that is passes to the view
			* array key is the day of month 
			*
			*/
			
			foreach($var as $v) {
			
				
				if(isset($v[0]['event_day'])) {
	
					$day = $v[0]['event_day'];
					
					if(isset($data[$day]))
						{
							$data[$day] .= '<br /><a href="' . $view_base_url . '/view/' . $v['Event']['id'] . '">' . $v['Event']['name'] . '</a>';
						}
					else
						{
							$data[$day] = '<a href="' . $view_base_url . '/view/' . $v['Event']['id'] . '">' . $v['Event']['name'] . '</a>';
						}
				}
				
				
			}
			return $data;
		}
		
		
	}

	function calendar($year = null, $month = null) {
	
		$this->Event->recursive = 0;
		
		$month_list = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
		$day_list = array('Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom');
		$base_url = $this->webroot . 'events/calendar'; // NOT not used in the current helper version but used in the data array
		$view_base_url = $this->webroot. 'events';
		
		
		$data = null;
	
		
		if(!$year || !$month)
			{
				$year = date('Y');
//				$month = date('M');
				$month_num = date('n');
				$month = mes2letras($month_num);
				$item = null;
			}
			
		$flag = 0;
				
		for($i = 0; $i < 12; $i++) { // check the month is valid if set
				if(strtolower($month) == $month_list[$i])
					{
						if(intval($year) != 0)
							{
								$flag = 1;
								$month_num = $i + 1;
								$month_name = $month_list[$i];
								break;
							}
					}
			}
					
		if($flag == 0) { // if no date set, then use the default values
				$year = date('Y');
				$month = date('M');
				$month_name = date('F');
				$month_num = date('m');
		}
		
		$fields = array('id', 'name', 'day(event_date) AS event_day');
		$var = $this->Event->find(
			'all', 
			array(
				'conditions' => array('MONTH(Event.event_date)' => $month_num, 'YEAR(Event.event_date)' => $year), //array de condiciones
				'recursive' => 1, //int
		 		'fields' => $fields, //array de nombres de campos
				'order' => 'Event.event_date ASC', //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);
		
		/**
		* loop through the returned data and build an array of 'events' that is passes to the view
		* array key is the day of month 
		*
		*/
		
		foreach($var as $v) {
		
			
			if(isset($v[0]['event_day'])) {

				$day = $v[0]['event_day'];
				
				if(isset($data[$day]))
					{
						$data[$day] .= '<br /><a href="' . $view_base_url . '/view/' . $v['Event']['id'] . '">' . $v['Event']['name'] . '</a>';
					}
				else
					{
						$data[$day] = '<a href="' . $view_base_url . '/view/' . $v['Event']['id'] . '">' . $v['Event']['name'] . '</a>';
					}
			}
			
			
		}
		
		
		$this->set('year', $year);
		$this->set('month', $month);
		$this->set('base_url', $base_url);
		$this->set('data', $data);
		
		
	}

	function view($year=null, $month=null, $day=null) {
		if (!$year || !$month || !$day) {
			$this->flash(__('Invalid Event', true), array('action'=>'calendar'));
		}
		$fecha = "$year-$month-$day";
		$this->set('events', $this->VActividad->find('all', array('conditions'=>array("VActividad.fecha_culminacion='$fecha'"))));
		$this->set('fecha', $fecha);
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Evento no existe', true), array('action'=>'index'));
		}
		
		if($this->Event->delete()) {
			$this->flash(__('El evento ha sido eliminado', true), array('action'=>'index'));
		} else {
			$this->flash(__('No se pudo eliminar el evento', true), array('action'=>'index'));
		}
	}

	function add() {
		if ($this->request->is('post')) {
			//$clean = new Sanitize();
			
			//$this->data['Event']['name'] = $this->data['Event']['name'];
			//$this->data['Event']['notes'] = $this->data['Event']['notes'];
			$this->request->data['Event']['usuario_id']= $this->Auth->user('id');
			$this->Event->create();
			if ($this->Event->save($this->data)) {
				$this->Session->setFlash(__('La actividad ha sido registrada.', true));
				$this->redirect("/");
				//exit();
			} else {
			}
		}
	}
	
	function reportes(){
		
	}
	
	function generar_reporte(){
		$this->layout= "pdf";
		if(!empty($this->data)){
			$mes = $this->data['Event']['mes'];
			$this->set('mes', $mes);
			if($mes == 0){
				$actividades = $this->VActividad->find('all');
			}else{
				$actividades = $this->VActividad->find('all', array('conditions'=>array('mes'=>$mes)));
			}
			//pr($actividades);exit;
			$this->set('actividades', $actividades);
		}
		
	}

	/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Event->recursive = 0;
		$this->set('eventos', $this->paginate('Event', array('Event.usuario_id'=>$this->Auth->user('id'))));
	}


	

	

}
?>
