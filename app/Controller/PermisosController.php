<?php
App::uses('AppController', 'Controller');
/**
 * Permisos Controller
 *
 * @property Permiso $Permiso
 */
class PermisosController extends AppController {

	public $components = array('RequestHandler', 'Auth', 'Acl');

	public $paginate = array(
        'limit' => 25,
        'order' => array(
            'Permiso.fecha_desde' => 'asc'
        )
    );

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->mapActions(
			array(
			'create' => array('aprobar', 'denegar'),
			//'read' => array(),
			//'update' => array(),
			'delete' => array('reportes', 'reporteGeneral', 'reporteIndividual')
			)
		);
		//$this->Auth->allowedActions = array('admin_index');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$user_id = $this->Auth->user('id');
		$this->Permiso->recursive = 0;
		$this->set('permisos', $this->paginate('Permiso', array("usuario_id=$user_id")));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Invalid permiso'));
		}
		$centros = $this->Permiso->Centro->find('list');
		$permiso = $this->Permiso->read(null, $id);
		$this->set(compact('permiso', 'centros'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Permiso->create();
			//pr($this->request->data);exit;
			if($this->request->data['Permiso']['nro_dias'] == 0) $this->request->data['Permiso']['nro_dias'] = '0.5';
			$nro_dias = $this->request->data['Permiso']['nro_dias'];
			//pr($this->request->data['Permiso']['fecha_desde']);
			$fecha_desde = $this->request->data['Permiso']['fecha_desde']['year']."-".$this->request->data['Permiso']['fecha_desde']['month'].'-'.$this->request->data['Permiso']['fecha_desde']['day'];
			$fecha_hasta = $this->_calcularFechaHasta($fecha_desde, $nro_dias);
			//echo date_format($fecha_hasta, 'Y-m-d');exit;
			$this->request->data['Permiso']['fecha_hasta'] = $fecha_hasta;
			$this->request->data['Permiso']['centro_id'] = $this->Auth->user('centro_id');
			if ($this->Permiso->save($this->request->data)) {
				$datos['fecha_desde'] = $fecha_desde;
				$datos['nro_dias'] = $nro_dias;
				$this->_enviarCorreo(null, $this->Auth->user('email'), 'Solicitud de Permiso', 'permiso', 'html', $datos);
				$this->Session->setFlash(__('El permiso ha sido solicitado.'));
				$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));
			} else {
				$this->Session->setFlash(__('The permiso could not be saved. Please, try again.'));
			}
		}
		$usuarios = $this->Permiso->Usuario->find('list');
		$centros = $this->Permiso->Centro->find('list');
		$this->set(compact('usuarios', 'centros'));
	}

	public function _calcularFechaHasta($fecha_desde, $maxDias){
		//Esta pequeña funcion me crea una fecha de entrega sin sabados ni domingos
	    //Creamos un for desde 0 hasta maximo de dias
	    $segundos = 0;
	    $inicio = strtotime($fecha_desde);
	    $fecha_hasta = $fecha_desde;
	    for ($i=0; $i < $maxDias-1; $i++){
			//Acumulamos la cantidad de segundos que tiene un dia en cada vuelta del for
			$segundos += 86400;
			//Obtenemos el dia de la fecha, aumentando el tiempo en N cantidad de dias, segun la vuelta en la que estemos
			$caduca = date("D",$inicio+$segundos);
			
	        //Comparamos si estamos en sabado o domingo, si es asi restamos una vuelta al for, para brincarnos el o los dias...
			if ($caduca == "Sat") $i--;
			else if ($caduca == "Sun") $i--;
			else $fecha_hasta = date("Y-m-d", $inicio + $segundos);//Si no es sabado o domingo, y el for termina y nos muestra la nueva fecha
		}
		return $fecha_hasta;
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Invalid permiso'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$nro_dias = $this->request->data['Permiso']['nro_dias'];
			//pr($this->request->data['Permiso']['fecha_desde']);
			$fecha_desde = $this->request->data['Permiso']['fecha_desde']['year']."-".$this->request->data['Permiso']['fecha_desde']['month'].'-'.$this->request->data['Permiso']['fecha_desde']['day'];
			$fecha_hasta = date_create($fecha_desde);
			$fecha_hasta = date_add($fecha_hasta, date_interval_create_from_date_string($nro_dias.' days'));
			//echo date_format($fecha_hasta, 'Y-m-d');exit;
			$this->request->data['Permiso']['fecha_hasta'] = date_format($fecha_hasta, 'Y-m-d');
			if($nro_dias == 0) $this->request->data['Permiso']['nro_dias'] = '0.5';
			if ($this->Permiso->save($this->request->data)) {
				$this->Session->setFlash(__('La solicitud de permiso ha sido modificada.'));
				$this->redirect(array('controller'=>'Panel', 'action' => 'index'));
			} else {
				$this->Session->setFlash('La solicitud de permiso no fue modificada. Por favor, intente nuevamente.');
			}
		} else {
			$this->request->data = $this->Permiso->read(null, $id);
		}
		$usuarios = $this->Permiso->Usuario->find('list');
		$centros = $this->Permiso->Centro->find('list');
		$this->set(compact('usuarios', 'centros'));
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
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Permiso invalido'));
		}
		if ($this->Permiso->delete()) {
			$this->Session->setFlash(__('Permiso eliminado con exito'));
			$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));
		}else{
			$this->Session->setFlash(__('El Permiso no fue eliminado. Por favor intente nuevamente.'));
			$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));	
		}
		
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Permiso->recursive = 0;
		$this->set('permisos', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Invalid permiso'));
		}
		$this->set('permiso', $this->Permiso->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Permiso->create();
			if ($this->Permiso->save($this->request->data)) {
				$this->Session->setFlash(__('The permiso has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The permiso could not be saved. Please, try again.'));
			}
		}
		$usuarios = $this->Permiso->Usuario->find('list');
		$centros = $this->Permiso->Centro->find('list');
		$this->set(compact('usuarios', 'centros'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Invalid permiso'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Permiso->save($this->request->data)) {
				$this->Session->setFlash(__('The permiso has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The permiso could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Permiso->read(null, $id);
		}
		$usuarios = $this->Permiso->Usuario->find('list');
		$centros = $this->Permiso->Centro->find('list');
		$this->set(compact('usuarios', 'centros'));
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
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) {
			throw new NotFoundException(__('Invalid permiso'));
		}
		if ($this->Permiso->delete()) {
			$this->Session->setFlash(__('Permiso deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Permiso was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function aprobar($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) throw new NotFoundException(__('Permiso Invalido'));

		if($this->Permiso->aprobar($id)) $this->Session->setFlash('El permiso fue aprobado con éxito.');

		else $this->Session->setFlash('El permiso no fue aprobado.');

		$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));
	}

	public function denegar($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) throw new NotFoundException(__('Permiso Invalido'));

		if($this->Permiso->denegar($id)) $this->Session->setFlash('El permiso fue denegado con éxito.');

		else $this->Session->setFlash('El permiso no fue denegado. Por favor, intente nuevamente');

		$this->redirect(array('controller'=>'Panel', 'action' => 'index', 'admin'=>false));
	}

	public function generarPdf($id = null) {
		if (!$this->request->is('post')) {
			$this->Session->setFlash('Opción no permitida');
		}
		$this->Permiso->id = $id;
		if (!$this->Permiso->exists()) throw new NotFoundException(__('Permiso Invalido'));

		$this->set('Permiso', $this->Permiso->read(null, $id));
		$this->layout = "pdf";
	}

	protected function _enviarCorreo($from=null, $to, $subject, $template, $emailType='html', $viewVars = null) {
		if(is_null($from)) $from = array('CPDI', 'cpdi@fii.gob.ve');

		$success = false;
		array_push($this->destinatarios, $to);
		try {
			$email = new CakeEmail('mandrill');
			$email->from($from[1], $from[0]);
			$email->to($this->destinatarios);
			$email->subject($subject);
			$email->template($template);
			$email->viewVars($viewVars);

			$success = $email->send();
			//print_r($success);exit;
		} catch (SocketException $e) {
			$this->log(sprintf('Error sending %s notification : %s', $emailType, $e->getMessage()));
		}

		return $success;
	}

	public function reportes() {

	}

	public function reporteGeneral(){
		if ($this->request->is('post')) {
			//pr($this->request->data);exit;
			$tipo = $this->request->data['Permiso']['tipo'];
			$mes =  $this->request->data['Permiso']['mes'];
			$trimestre =  $this->request->data['Permiso']['trimestre'];
			$semestre =  $this->request->data['Permiso']['semestre'];
			$year =  $this->request->data['Permiso']['year'];
			$anio = date('Y'); //Por defecto trae el año actual
			$status =   $this->request->data['Permiso']['status_id'];
			$condiciones = array();
			$meses = array(1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Obtubre', 11 => 'Noviembre', 12 => 'Diciembre');
			switch ($tipo) {
				case 1 :
					//Reporte mensual
					$condiciones = array('MONTH(Permiso.fecha_desde)'=>$mes);
					$titulo = "del Mes de ".$meses[$mes]."de $anio";
					break;
				case 2 :
					//Reporte trimestral
					switch ($trimestre){
						case 1 :
							$tri = array(1, 3);
							$titulo = "del 1er Trimestre de $anio";
							break;
						case 2 :
							$tri = array(4, 6);
							$titulo = "del 2do Trimestre de $anio";
							break;
						case 3 :
							$tri = array(7, 9);
							$titulo = "del 3er Trimestre de $anio";
							break;
						case 4 :
							$tri = array(10, 12);
							$titulo = "del 4to Trimestre de $anio";
							break;
					}
					$condiciones = array('MONTH(Permiso.fecha_desde) BETWEEN ? AND ?' => $tri);
					break;
				case 3 :
					//Reporte semestral
					switch ($semestre) {
						case 1 :
							$sem = array(1, 6);
							$titulo = "del 1er Semestre de $anio";
							break;
						case 2 :
							$sem = array(7, 12);
							$titulo = "del 2do Semestre de $anio";
							break;
					}
					$condiciones = array('MONTH(Permiso.fecha_desde) BETWEEN ? AND ?' => $sem);
					break;
				case 4 :
					//Reporte anual
					$condiciones = array('YEAR(Permiso.fecha_desde)'=>$year);
					$titulo = "del Año $year";
					break;

				default :
					$condiciones = array('YEAR(Permiso.fecha_desde)'=>$year);
					break;
			}
			array_push($condiciones, array('Permiso.status'=>$status));

			$Permisos = $this->Permiso->find('all', array('conditions'=>$condiciones));
			//pr($Permisos);exit;
			$this->set(compact('Permisos', 'status', 'titulo'));
			//$this->layout = "pdf";
			$this->render('pdf_reporte_general');
		}
	}

	public function reporteGeneralPdf() {
		if (!$this->request->is('post')) {
			$this->Session->setFlash('Opción no permitida');
		}else{
			//pr($this->request->data);exit;
			$tipo = $this->request->data['Permiso']['tipo'];
			$mes =  $this->request->data['Permiso']['mes'];
			$trimestre =  $this->request->data['Permiso']['trimestre'];
			$semestre =  $this->request->data['Permiso']['semestre'];
			$year =  $this->request->data['Permiso']['year'];
			$anio = date('Y'); //Por defecto trae el año actual
			$status =   $this->request->data['Permiso']['status_id'];
			$condiciones = array();
			switch ($tipo) {
				case 1 :
					//Reporte mensual
					$condiciones = array('MONTH(Permiso.fecha_desde)'=>$mes);
					break;
				case 2 :
					//Reporte trimestral
					switch ($trimestre){
						case 1 :
							$tri = array(1, 3);
							break;
						case 2 :
							$tri = array(4, 6);
							break;
						case 3 :
							$tri = array(7, 9);
							break;
						case 4 :
							$tri = array(10, 12);
							break;
					}
					$condiciones = array('MONTH(Permiso.fecha_desde) BETWEEN ? AND ?' => $tri);
					break;
				case 3 :
					//Reporte semestral
					switch ($semestre) {
						case 1 :
							$sem = array(1, 6);
							break;
						case 2 :
							$sem = array(7, 12);
							break;
					}
					$condiciones = array('MONTH(Permiso.fecha_desde) BETWEEN ? AND ?' => $sem);
					break;
				case 4 :
					//Reporte anual
					$condiciones = array('YEAR(Permiso.fecha_desde)'=>$year);
					break;

				default :
					$condiciones = array('YEAR(Permiso.fecha_desde)'=>$year);
					break;
			}
			array_push($condiciones, array('Permiso.status'=>$status));

			$Permisos = $this->Permiso->find('all', array('conditions'=>$condiciones));
			//pr($Permisos);exit;
			$this->set('Permisos', $Permisos);
			$this->layout = "pdf";
		}
		

	}

	public function reporteIndividual() {
		if ($this->request->is('post')) {
			$year =  $this->request->data['Permiso']['year'];
			$usuario_id =  $this->request->data['Permiso']['coordinador_id'];
			$anio = date('Y'); //Por defecto trae el año actual
			$condiciones = array();
			$condiciones = array('YEAR(Permiso.fecha_desde)'=>$year);
			array_push($condiciones, array('Permiso.usuario_id'=>$usuario_id));

			$Permisos = $this->Permiso->find('all', array('conditions'=>$condiciones, 'order'=>'Permiso.fecha_solicitud'));
			//pr($Permisos);exit;
			$this->request->data = array();
			$this->set(compact('Permisos', 'year'));
		}
		$this -> Set('personal', $this -> Permiso -> Usuario -> find('all', array('fields' => 'id, fullname', 'order' => 'fullname', 'conditions' => array('Usuario.status' => 1, 'rol_id !=' => 1, 'Usuario.centro_id'=>$this->Auth->user('centro_id')))));
	}


}
