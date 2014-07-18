<?php
class EventosController extends AppController {

	var $name = 'Eventos';
	var $helpers = array('Html', 'Form', 'Session', 'Ajax');
	var $uses = array('Evento', 'Paises', 'Estado', 'TipoEvento', 'Usuario', 'Carpeta', 'Material', 'VEventosMesAnio', 'VEventosTipo', 'EventosUsuario');
	var $paginate = array('Evento'=>array('limit'=>10, 'order'=>array('Evento.id'=>'asc')), 'Material'=>array('limit'=>5, 'order'=>array('Material.id'=>'asc')));
	var $components = array('RequestHandler', 'Session', 'Acl');

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->authorize = 'crud';
		$this->Auth->mapActions(
			array(
			'create' => array('add_usuario_evento'),
			'read' => array('busqueda', 'graficos_anual', 'graficos_semestral', 'graficos_trimestral', 'graficos_mensual', 'generarPdfAnual', 'generarPdfSemestral', 'generarPdfTrimestral', 'generarPdfMensual'),
			//'update' => array('ciertaAccion'),
			'delete' => array('evento_personal_delete')
			)
		);
		//$this->Auth->allowedActions = array('*');
		//pr($this->Auth->user());
	}
	
	function index() {
		$this->Evento->recursive = 0;
		if(empty($this->data)){
			if(preg_match("/Eventos/i", $this->referer())){
				$condicion = $this->Session->read('paginator.condicion');
				//echo "condicion cuando no hay data: $condicion";
				$eventos = $this->paginate('Evento', $condicion);
				$this->set('eventos', $eventos);
				$this->helpers['Paginator'] = array('ajax' => 'Ajax');
			}else{
				$this->Session->delete('paginator.condicion');
				$this->set('eventos', $this->paginate());
				$this->helpers['Paginator'] = array('ajax' => 'Ajax');
			}
			
		}else{
			$pista = up($this->data['Evento']['busqueda']);
			$condicion = " upper(Evento.name) LIKE '%$pista%' OR upper(Evento.institucion) LIKE '%$pista%' OR upper(Evento.descripcion) LIKE '%$pista%' OR upper(TipoEvento.title) LIKE '%$pista%' ";
			$eventos = $this->paginate("Evento", array($condicion));
			$this->Session->write('paginator.condicion', $condicion);
			//pr($eventos);
			if(!empty($eventos)){
				$this->set('eventos', $eventos);
				$cant = count($eventos);
				if($cant == 1){
					$mensaje = "La busqueda arrojo UN (01) resultado.";
				}else{
					$mensaje = "La busqueda arrojo ".num2letras(count($eventos))." ( ".codigo(count($eventos))." ) resultados.";
				}
				$this->Session->setFlash($mensaje);
			}else{
				$this->set('eventos', $this->paginate());
				$this->Session->setFlash(__('La busqueda no arrojo resultados. Por favor, intente de nuevo.', true));
			}
		}
	}

	function view($id = null) {
		
		if (!$id) {
			$this->Session->setFlash(__('Evento NO DISPONIBLE.', true));
			$this->redirect(array('action'=>'index'));
		}
		if($this->_isCreador($id)){
			$this->set('creador', true);
		}
		$materiales = $this->Material->find(
			'all',
			array(
			'conditions'=> array ('Material.evento_id'=>$id), //array de condiciones
			'recursive'=>-1, //int
			'fields'=> array (), //array de nombres de campos
			'order'=>null, //string o array definiendo el orden
			'group'=> array (), //campos para GROUP BY
			'limit'=>null, //int
			'page'=>null //int
			)
		);
		$eventos_usuarios= $this->EventosUsuario->find(
			'all', 
			array(
				'conditions' => array('EventosUsuario.evento_id' => $id), //array de condiciones
				'recursive' => 0, //int
		 		'fields' => array(), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);
		//pr($eventos_usuarios);
		$this->set('eventos_usuarios',$eventos_usuarios);
		$vec = array();
		foreach ($eventos_usuarios as $eu) {
			array_push($vec, $eu['EventosUsuario']['usuario_id']);
		}
		//pr($vec);
		$personal = $this->Usuario->find(
		'list',
		array(
			'conditions' => array('NOT' => array('Usuario.id'=>$vec)), //array de condiciones
		 	'fields' => array('Usuario.id', 'Usuario.name'), //array de nombres de campos
			'order' => null, //string o array definiendo el orden
		)
		);
		$personal_completo = $this->Usuario->find(
		'list',
		array(
			'conditions' => array(), //array de condiciones
		 	'fields' => array('Usuario.id', 'Usuario.name'), //array de nombres de campos
			'order' => null, //string o array definiendo el orden
		)
		);
		$this->set('personal', $personal);
		$this->set('personal_completo', $personal_completo);
		$evento= $this->Evento->read(null, $id);
		$this->set('evento', $evento);
		$this->set('id', $id);
		$this->data = $evento;
		$this->data['Evento']['fecha_desde'] = turnFecha($this->data['Evento']['fecha_desde']);
		$this->data['Evento']['fecha_hasta'] = turnFecha($this->data['Evento']['fecha_hasta']);
		$this->data['Material'] = array();
		$tipoEventos = $this->Evento->TipoEvento->find('list');
		$pais = $this->Evento->Paises->find('list');
		$estados = $this->Evento->Estado->find('list');
		$this->set('materiales', $this->paginate('Material', array('Material.evento_id'=>$id)));
		$this->set(compact('tipoEventos', 'pais', 'estados'));
	}

	function add() {
		if (!empty($this->data)){
			//pr($this->data);exit;
			$this->Evento->create();
			$this->data['Evento']['usuario_id'] = $this->Session->read('Auth.Usuario.id');
			if ($this->Evento->save($this->data)) {
				$evento_id = $this->data['Evento']['id']= $this->Evento->getLastInsertID();
				$path_carpeta ='files/'.$this->data['Evento']['id']."/";
				$this->data['Carpeta']['name'] = $this->data['Evento']['name'];
				$this->data['Carpeta']['evento_id'] = $evento_id; 
				if(mkdir($path_carpeta, 0755, TRUE)){
					$this->Carpeta->create();
					$this->Carpeta->save($this->data);
				}
				$this->Session->setFlash(__('El Evento ha sido guardado con exito. PUEDE PROCEDER A AGREGAR EL MATERIAL.', true));
				$this->redirect(array('action'=>'view', $this->data['Evento']['id']));
				//pr($this->data);exit;
			}else {
				$this->Session->setFlash(__('El Evento no pudo ser guardado. Por favor verifique los datos del evento he intente nuevamente.', true));
			}
		}
		$tipoEventos = $this->Evento->TipoEvento->find('list');
		$pais = $this->Evento->Paises->find('list');
		$estados = $this->Evento->Estado->find('list');
		$personal = $this->Usuario->find('list', array('fields'=>array('Usuario.id', 'Usuario.name')));
		$this->set('personal', $personal);
		$this->set(compact('tipoEventos', 'pais', 'estados'));
	}

	function edit($id = null){
		//pr($this->Auth->user());
		if($this->_isCreador($id) || $this->Auth->user('aro_id') == 1){
			$this->set('creador', true);
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Evento NO DISPONIBLE.', true));
				$this->redirect(array('action'=>'index'));
			}
			if (!empty($this->data)) {
				if ($this->Evento->save($this->data)) {
					$this->Session->setFlash('El Evento ha sido modificado con exito.');
					//echo "SESSION EN EL EDIT: ";
					//pr($_SESSION['Message']);
					$this->redirect(array('action'=>'index'));
				} else {
					$this->Session->setFlash(__('El Evento no pudo ser modificado. Por favor verifique los datos del evento he intente nuevamente.', true));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Evento->read(null, $id);
				$this->data['Evento']['fecha_desde'] = turnFecha($this->data['Evento']['fecha_desde']);
				$this->data['Evento']['fecha_hasta'] = turnFecha($this->data['Evento']['fecha_hasta']);
			}
		$eventos_usuarios= $this->EventosUsuario->find(
			'all', 
			array(
				'conditions' => array('EventosUsuario.evento_id' => $id), //array de condiciones
				'recursive' => 0, //int
		 		'fields' => array(), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);
		
		//pr($eventos_usuarios);
		$this->set('eventos_usuarios',$eventos_usuarios);
		$vec = array();
		foreach ($eventos_usuarios as $eu) {
			array_push($vec, $eu['EventosUsuario']['usuario_id']);
		}
		$personal = $this->Usuario->find(
		'list',
		array(
			'conditions' => array('NOT' => array('Usuario.id'=>$vec)), //array de condiciones
		 	'fields' => array('Usuario.id', 'Usuario.name'), //array de nombres de campos
			'order' => null, //string o array definiendo el orden
		)
		);
		$this->set('personal', $personal);
		$this->set('materiales', $this->paginate('Material', array('Material.evento_id'=>$id)));
			$tipoEventos = $this->Evento->TipoEvento->find('list');
			$personal_completo = $this->Usuario->find('list', array('fields'=>array('Usuario.id', 'Usuario.name')));
			$this->set('personal_completo', $personal_completo);
			$this->set('id', $id);
			$pais = $this->Evento->Paises->find('list');
			$estados = $this->Evento->Estado->find('list');
			$this->set(compact('tipoEventos','pais','estados'));
		}else{
			$this->Session->setFlash('Lo siento, ud no tiene permisos para modificar este evento.');
			$this->redirect(array('action'=>'index'));
		}
		
	}
	

	function delete($id = null){
		if (!$id) {
			$this->Session->setFlash(__('Evento NO DISPONIBLE.', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Evento->delete($id)){
			delTree("files/$id");
			$this->Carpeta->delete(array('evento_id'=>$id));
			$this->Session->setFlash(__('El Evento ha sido eliminado con exito.', true));
			$this->redirect(array('action'=>'index'));
		}else{
			$this->Session->setFlash(__('El Evento no pudo ser eliminado. Verifique los datos he intente nuevamente.', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	function busqueda(){
		
		if(!empty($this->data)){
			//pr($this->data);
			$institucion = low($this->data['Evento']['institucion']);
			$tipo_evento_id = $this->data['Evento']['tipo_evento_id'];
			$nacionalidad = $this->data['Evento']['nacionalidad'];
			$usuario_id = $this->data['Evento']['usuario_id'];
			$fecha_desde = $this->data['Evento']['fecha_desde'];
			$fecha_hasta = $this->data['Evento']['fecha_hasta'];
			$condicion['institucion'] = "lower(Evento.institucion) LIKE '%$institucion%'";
			$condicion['tipo_evento_id'] = "Evento.tipo_evento_id='$tipo_evento_id'";
			$condicion['nacionalidad'] = "Evento.nivel = '$nacionalidad'";
			
			if(!empty($fecha_desde)){
				if(!empty($fecha_hasta)){
					$condicion['fecha_desde'] = "(Evento.fecha_desde BETWEEN '$fecha_desde' AND '$fecha_hasta')";					
				}else{
					$condicion['fecha_desde'] = "(Evento.fecha_desde='$fecha_desde')";
				}
			}
			
			$condicion['usuario_id'] = "Evento.personal_id='$usuario_id'";
			
			$eventos = $this->paginate('Evento',  $this->_getCondiciones($condicion));
			//echo "condiciones: ".$this->_getCondiciones($condicion);
			//$this->Session->write("params.paging.Evento.options.conditions", $this->_getCondiciones($condicion));
			$this->params['paging']['Evento']['defaults']['conditions'] = $this->_getCondiciones($condicion);
			$this->params['paging']['Evento']['options']['conditions'] = $this->_getCondiciones($condicion);
			
			//echo $this->_getCondiciones($condicion);
			//pr($eventos);
			
		}else{
			if(preg_match("/Eventos\/busqueda/i", $this->referer())){
				$condicion = $this->Session->read('paginator.condicion');
				//echo "condicion cuando no hay data: $condicion";
				$eventos = $this->paginate('Evento', $condicion);
			}else{
				$this->Session->delete('paginator.condicion');
				$eventos = array();
			}
			
		}
		
		$this->set('eventos', $eventos);
		$tipoEventos = $this->Evento->TipoEvento->find('list');
		$pais = $this->Evento->Paises->find('list');
		$personal = $this->Usuario->find('list', array('fields'=>array('Usuario.id', 'Usuario.name')));
		$this->set('usuarios', $personal);
		$this->set(compact('tipoEventos', 'pais'));
		
		$instituciones = $this->Evento->find(
			'all', 
			array(
				'conditions' => "", //array de condiciones
				'recursive' => -1, //int
		 		'fields' => array('DISTINCT(Evento.institucion)'), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);
		
		$this->set('institucion', $this->_getArrayJson($instituciones));
	}
	
	function _getArrayJson($data){
		
		$var = array();
		//pr($instituciones);
		foreach ($data as $value){
			
			foreach ($value as $valor){
				
				foreach($valor as $index => $val){
					array_push($var, $val);
				}
				
			}
			
		}
		//pr($var);
		return $var;
		
	}
	
	function _getCondiciones($condicion, $model = null){
		
		if(is_null($model)){
			$model = $this->uses[0];
		}
		$condiciones = "";
		$sw = 0;
		foreach ($condicion as $key => $value){
			if(!empty($this->data[$model][$key])){
				if($sw++ != 0){
					$condiciones .= " AND ";
				}
				$condiciones .= $condicion[$key];
			}
		}
		return $condiciones;
	}
	
	
	function graficos_anual(){
		
		if(!empty($this->data)){
			$year = $this->data['Evento']['year'];
			if(empty($year)){
				$year = date('Y');
			}
			$datos = $this->VEventosMesAnio->find(
				'all', 
				array(
					'conditions' => array('year BETWEEN ? AND ?'=>array($year-3 , $year+3)), //array de condiciones
					'recursive' => 1, //int
			 		'fields' => array(), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array(), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			
			$data = array();
			//pr($datos);
			foreach($datos as $dato){
				if(!key_exists($dato['VEventosMesAnio']['year'], $data)){
					$data[$dato['VEventosMesAnio']['year']] = array(1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0, 7=>0, 8=>0, 9=>0, 10=>0, 11=>0, 12=>0);
				}
				$data[$dato['VEventosMesAnio']['year']][$dato['VEventosMesAnio']['mes']] = $dato['VEventosMesAnio']['cant_eventos'];
				
			}
			//pr($data);
			$this->set('datos', $data);
			
			//OBTENIENDO LOS DATOS DEL RESUMEN
			
			$cuadro_resumen = $this->VEventosMesAnio->find(
				'first', 
				array(
					'conditions' => array('VEventosMesAnio.year'=>$year), //array de condiciones
					'recursive' => 1, //int
			 		'fields' => array('SUM(VEventosMesAnio.cant_eventos) AS cant_eventos', 'SUM(VEventosMesAnio.cant_personal) AS cant_personal', 'SUM(VEventosMesAnio.nacional) AS nacional', 'SUM(VEventosMesAnio.internacional) AS internacional'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('VEventosMesAnio.year'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($cuadro_resumen);
			
			$this->set('resumen', $cuadro_resumen);
			
			//OBTENIENDO DATA DE LOS TIPOS DE EVENTOS:
			$data_tipo_eventos = $this->VEventosTipo->find(
				'all', 
				array(
					'conditions' => array('VEventosTipo.year'=>$year), //array de condiciones
					'recursive' => 0, //int
			 		'fields' => array('SUM(cant) AS cant', 'VEventosTipo.tipo_evento_id', 'VEventosTipo.title'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('VEventosTipo.year', 'VEventosTipo.tipo_evento_id', 'VEventosTipo.title'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($data_tipo_eventos);
			$this->set('data_tipo_eventos', $data_tipo_eventos);
		}
		
		$anios = $this->VEventosMesAnio->find(
		'list', 
		array(
			'conditions' => array(), //array de condiciones
		 	'fields' => array('VEventosMesAnio.year', 'VEventosMesAnio.year'), //array de nombres de campos
			'order' => null, //string o array definiendo el orden
		)
		);
		$this->set('year', $anios);
		
		
	}
	
	function generarPdfAnual($year) {
		$this->layout = "pdf";
		$this->set("year", $year);
		$tipo_eventos = $this->VEventosTipo->find(
			'all', 
			array(
				'conditions' => array('VEventosTipo.year' => $year), //array de condiciones
				'recursive' => 1, //int
		 		'fields' => array(), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);
		$cant_eventos = $this->VEventosMesAnio->find(
			'all', 
			array(
				'conditions' => array('VEventosMesAnio.year' => $year), //array de condiciones
				'recursive' => 1, //int
		 		'fields' => array('sum(cant_eventos), sum(cant_personal) as cant_personal'), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);
		
		$niveles = $this->Evento->find(
			'all', 
			array(
				'conditions' => array('year(Evento.fecha_desde)' => $year), //array de condiciones
				'recursive' => -1, //int
		 		'fields' => array('(Select count(*) from eventos where nivel=1) as nacional', '(Select count(*) from eventos where nivel=2) as internacional'), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);
		//pr($niveles);
		$this->set("tipo_eventos", $tipo_eventos);
		$this->set("cant_eventos", $cant_eventos[0][0]['sum']);
		$this->set("cant_personal", $cant_eventos[0][0]['cant_personal']);
		
		//OBTENIENDO DATA POR NACIONALIDAD DEL EVENTO
			$nacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 1, 'year(Evento.fecha_desde)'=>$year), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			$internacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 2, 'year(Evento.fecha_desde)'=>$year), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($internacional);
			if(empty($nacional)) $nacional= array(0=>array(0=>array('count'=>0)));
			if(empty($internacional)) $internacional= array(0=>array(0=>array('count'=>0)));
			$this->set('nacional', $nacional);
			$this->set('internacional', $internacional);
	}
	
	function graficos_semestral(){
		
		if(!empty($this->data)){
			$year = $this->data['Evento']['year'];
			if(empty($year)){
				$year = date('Y');
			}
			$semestre = $this->data['Evento']['semestre'];
			
			switch ($semestre) {
				case 1:
					$cond_semestre = array(1, 6);
				break;
				case 2:
					$cond_semestre = array(7, 12);
				break;
			}
			$datos = $this->VEventosMesAnio->find(
				'all', 
				array(
					'conditions' => array('year'=>$year, 'mes BETWEEN ? AND ?'=>$cond_semestre), //array de condiciones
					'recursive' => 1, //int
			 		'fields' => array(), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array(), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			
			if(empty($datos)){
				$this->Session->setFlash("NO HAY DATOS PARA LA OPCION SELECCIONADA.");
				$this->data = array();
				$anios = $this->VEventosMesAnio->find(
					'list', 
					array(
						'conditions' => array(), //array de condiciones
					 	'fields' => array('VEventosMesAnio.year', 'VEventosMesAnio.year'), //array de nombres de campos
						'order' => null, //string o array definiendo el orden
					)
					);
					$this->set('year', $anios);
				return;
			}
			
			$data = array();
			//pr($datos);
			foreach($datos as $dato){
				if(!key_exists($dato['VEventosMesAnio']['year'], $data)){
					if($semestre == 1){
						$data[$dato['VEventosMesAnio']['year']] = array(1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0);
					}else{
						$data[$dato['VEventosMesAnio']['year']] = array(7=>0, 8=>0, 9=>0, 10=>0, 11=>0, 12=>0);
					}
					
				}
				$data[$dato['VEventosMesAnio']['year']][$dato['VEventosMesAnio']['mes']] = $dato['VEventosMesAnio']['cant_eventos'];
				
			}
			if(empty($data)){
					if($semestre == 1){
						$data[$year] = array(1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0);
					}else{
						$data[$year] = array(7=>0, 8=>0, 9=>0, 10=>0, 11=>0, 12=>0);
					}
			}
			//pr($data);
			$this->set('datos', $data);
			$this->set('cant_eventos', $this->VEventosMesAnio->find('first', array('conditions' => array('year'=>$year, 'mes BETWEEN ? AND ?'=>$cond_semestre), 'fields'=>array("sum(cant_eventos) as cant_eventos"))));
			$this->set('cant_personal', $this->VEventosMesAnio->find('first', array('conditions' => array('year'=>$year, 'mes BETWEEN ? AND ?'=>$cond_semestre), 'fields'=>array("sum(cant_personal) as cant_personal"))));
			//OBTENIENDO DATA DE LOS TIPOS DE EVENTOS:
			$data_tipo_eventos = $this->VEventosTipo->find(
				'all', 
				array(
					'conditions' => array('VEventosTipo.year'=>$year, 'VEventosTipo.month BETWEEN ? AND ?'=>$cond_semestre), //array de condiciones
					'recursive' => 0, //int
			 		'fields' => array('sum(cant) AS count', 'VEventosTipo.tipo_evento_id', 'VEventosTipo.title'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('VEventosTipo.tipo_evento_id', 'VEventosTipo.title'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($data_tipo_eventos);
			$this->set('data_tipo_eventos', $data_tipo_eventos);
			
			//OBTENIENDO DATA POR NACIONALIDAD DEL EVENTO
			$nacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 1, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde) BETWEEN ? AND ?'=>$cond_semestre), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			$internacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 2, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde) BETWEEN ? AND ?'=>$cond_semestre), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($internacional);
			if(empty($nacional)) $nacional= array(0=>array(0=>array('count'=>0)));
			if(empty($internacional)) $internacional= array(0=>array(0=>array('count'=>0)));
			$this->set('nacional', $nacional);
			$this->set('internacional', $internacional);
		}
		
		$anios = $this->VEventosMesAnio->find(
		'list', 
		array(
			'conditions' => array(), //array de condiciones
		 	'fields' => array('VEventosMesAnio.year', 'VEventosMesAnio.year'), //array de nombres de campos
			'order' => null, //string o array definiendo el orden
		)
		);
		$this->set('year', $anios);
		
		
	}
	
	function generarPdfSemestral($year, $semestre) {
		$this->layout = "pdf";
		$this->set("year", $year);
		$this->set("semestre", $semestre);
		switch ($semestre) {
			case 1:
				$cond_semestre = array(1, 6);
			break;
			case 2:
				$cond_semestre = array(7, 12);
			break;
		}
		$tipo_eventos = $this->VEventosTipo->find(
			'all', 
			array(
				'conditions' => array('VEventosTipo.year' => $year, 'VEventosTipo.month BETWEEN ? AND ?'=>$cond_semestre), //array de condiciones
				'recursive' => 1, //int
		 		'fields' => array(), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);
		$this->set('cant_personal', $this->VEventosMesAnio->find('first', array('conditions' => array('year'=>$year, 'mes BETWEEN ? AND ?'=>$cond_semestre), 'fields'=>array("sum(cant_personal) as cant_personal"))));
		$cant_eventos = $this->VEventosMesAnio->find(
			'all', 
			array(
				'conditions' => array('VEventosMesAnio.year' => $year, 'VEventosMesAnio.mes BETWEEN ? AND ?'=>$cond_semestre), //array de condiciones
				'recursive' => 1, //int
		 		'fields' => array('sum(cant_eventos)'), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);

		
		$this->set("tipo_eventos", $tipo_eventos);
		$this->set("cant_eventos", $cant_eventos[0][0]['sum']);
		
		//OBTENIENDO DATA POR NACIONALIDAD DEL EVENTO
			$nacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 1, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde) BETWEEN ? AND ?'=>$cond_semestre), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			$internacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 2, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde) BETWEEN ? AND ?'=>$cond_semestre), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($internacional);
			if(empty($nacional)) $nacional= array(0=>array(0=>array('count'=>0)));
			if(empty($internacional)) $internacional= array(0=>array(0=>array('count'=>0)));
			$this->set('nacional', $nacional);
			$this->set('internacional', $internacional);
	}
	
	function graficos_trimestral(){
		
		if(!empty($this->data)){
			$year = $this->data['Evento']['year'];
			if(empty($year)){
				$year = date('Y');
			}
			$trimestre = $this->data['Evento']['trimestre'];
			
			switch ($trimestre) {
				case 1:
					$cond_trimestre = array(1, 3);
				break;
				case 2:
					$cond_trimestre = array(4, 6);
				break;
				case 3:
					$cond_trimestre = array(7, 9);
				break;
				case 4:
					$cond_trimestre = array(10, 12);
				break;
			}
			$datos = $this->VEventosMesAnio->find(
				'all', 
				array(
					'conditions' => array('year'=>$year, 'mes BETWEEN ? AND ?'=>$cond_trimestre), //array de condiciones
					'recursive' => 1, //int
			 		'fields' => array(), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array(), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			
			if(empty($datos)){
				$this->Session->setFlash("NO HAY DATOS PARA LA OPCION SELECCIONADA.");
				$this->data = array();
				$anios = $this->VEventosMesAnio->find(
					'list', 
					array(
						'conditions' => array(), //array de condiciones
					 	'fields' => array('VEventosMesAnio.year', 'VEventosMesAnio.year'), //array de nombres de campos
						'order' => null, //string o array definiendo el orden
					)
					);
					$this->set('year', $anios);
				return;
			}
			$this->set('cant_eventos', $this->VEventosMesAnio->find('first', array('conditions' => array('year'=>$year, 'mes BETWEEN ? AND ?'=>$cond_trimestre), 'fields'=>array("sum(cant_eventos) as cant_eventos"))));
			$this->set('cant_personal', $this->VEventosMesAnio->find('first', array('conditions' => array('year'=>$year, 'mes BETWEEN ? AND ?'=>$cond_trimestre), 'fields'=>array("sum(cant_personal) as cant_personal"))));
			$data = array();
			//pr($datos);
			foreach($datos as $dato){
				if(!key_exists($dato['VEventosMesAnio']['year'], $data)){
					switch ($trimestre) {
						case 1:
							$data[$year] = array(1=>0, 2=>0, 3=>0);
						break;
						case 2:
							$data[$year] = array(4=>0, 5=>0, 6=>0);
						break;
						case 3:
							$data[$year] = array(7=>0, 8=>0, 9=>0);
						break;
						case 4:
							$data[$year] = array(10=>0, 11=>0, 12=>0);
						break;
					}
					
				}
				$data[$dato['VEventosMesAnio']['year']][$dato['VEventosMesAnio']['mes']] = $dato['VEventosMesAnio']['cant_eventos'];
				
			}
			if(empty($data)){
					switch ($trimestre) {
						case 1:
							$data[$year] = array(1=>0, 2=>0, 3=>0);
						break;
						case 2:
							$data[$year] = array(4=>0, 5=>0, 6=>0);
						break;
						case 3:
							$data[$year] = array(7=>0, 8=>0, 9=>0);
						break;
						case 4:
							$data[$year] = array(10=>0, 11=>0, 12=>0);
						break;
					}
			}
			//pr($data);
			$this->set('datos', $data);
			
			//OBTENIENDO DATA DE LOS TIPOS DE EVENTOS:
			$data_tipo_eventos = $this->VEventosTipo->find(
				'all', 
				array(
					'conditions' => array('VEventosTipo.year'=>$year, 'VEventosTipo.month BETWEEN ? AND ?'=>$cond_trimestre), //array de condiciones
					'recursive' => 0, //int
			 		'fields' => array('sum(cant) AS count', 'VEventosTipo.tipo_evento_id', 'VEventosTipo.title'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('VEventosTipo.tipo_evento_id', 'VEventosTipo.title'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($data_tipo_eventos);
			$this->set('data_tipo_eventos', $data_tipo_eventos);
			
			//OBTENIENDO DATA POR NACIONALIDAD DEL EVENTO
			$nacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 1, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde) BETWEEN ? AND ?'=>$cond_trimestre), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			$internacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 2, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde) BETWEEN ? AND ?'=>$cond_trimestre), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($internacional);
			if(empty($nacional)) $nacional= array(0=>array(0=>array('count'=>0)));
			if(empty($internacional)) $internacional= array(0=>array(0=>array('count'=>0)));
			$this->set('nacional', $nacional);
			$this->set('internacional', $internacional);
		}
		
		$anios = $this->VEventosMesAnio->find(
		'list', 
		array(
			'conditions' => array(), //array de condiciones
		 	'fields' => array('VEventosMesAnio.year', 'VEventosMesAnio.year'), //array de nombres de campos
			'order' => null, //string o array definiendo el orden
		)
		);
		$this->set('year', $anios);
		
		
	}
	
	function generarPdfTrimestral($year, $trimestre) {
		$this->layout = "pdf";
		$this->set("year", $year);
		$this->set("trimestre", $trimestre);
		switch ($trimestre) {
				case 1:
					$cond_trimestre = array(1, 3);
				break;
				case 2:
					$cond_trimestre = array(4, 6);
				break;
				case 3:
					$cond_trimestre = array(7, 9);
				break;
				case 4:
					$cond_trimestre = array(10, 12);
				break;
			}
		$tipo_eventos = $this->VEventosTipo->find(
			'all', 
			array(
				'conditions' => array('VEventosTipo.year' => $year, 'VEventosTipo.month BETWEEN ? AND ?'=>$cond_trimestre), //array de condiciones
				'recursive' => 1, //int
		 		'fields' => array(), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);
		$cant_eventos = $this->VEventosMesAnio->find(
			'all', 
			array(
				'conditions' => array('VEventosMesAnio.year' => $year, 'VEventosMesAnio.mes BETWEEN ? AND ?'=>$cond_trimestre), //array de condiciones
				'recursive' => 1, //int
		 		'fields' => array('sum(cant_eventos), sum(cant_personal) as cant_personal'), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);

		
		$this->set("tipo_eventos", $tipo_eventos);
		$this->set("cant_eventos", $cant_eventos[0][0]['sum']);
		$this->set("cant_personal", $cant_eventos[0][0]['cant_personal']);
		
		//OBTENIENDO DATA POR NACIONALIDAD DEL EVENTO
			$nacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 1, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde) BETWEEN ? AND ?'=>$cond_trimestre), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			$internacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 2, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde) BETWEEN ? AND ?'=>$cond_trimestre), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($internacional);
			if(empty($nacional)) $nacional= array(0=>array(0=>array('count'=>0)));
			if(empty($internacional)) $internacional= array(0=>array(0=>array('count'=>0)));
			$this->set('nacional', $nacional);
			$this->set('internacional', $internacional);
	}
	
function graficos_mensual(){
		
		if(!empty($this->data)){
			$year = $this->data['Evento']['year'];
			if(empty($year)){
				$year = date('Y');
			}
			$mes = $this->data['Evento']['mes'];
			
			$datos = $this->VEventosMesAnio->find(
				'all', 
				array(
					'conditions' => array('year'=>$year, 'mes between ? and ?'=>array($mes-1, $mes+1)), //array de condiciones
					'recursive' => 1, //int
			 		'fields' => array(), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array(), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			
			if(empty($datos)){
				$this->Session->setFlash("NO HAY DATOS PARA LA OPCION SELECCIONADA.");
				$this->data = array();
				$anios = $this->VEventosMesAnio->find(
					'list', 
					array(
						'conditions' => array(), //array de condiciones
					 	'fields' => array('VEventosMesAnio.year', 'VEventosMesAnio.year'), //array de nombres de campos
						'order' => null, //string o array definiendo el orden
					)
					);
					$this->set('year', $anios);
				return;
			}
			
			$maximo = $this->VEventosMesAnio->find(
				'all',
				array(
					'conditions' => array('year'=>$year, 'mes between ? and ?'=>array($mes-1, $mes+1)), //array de condiciones
					'recursive' => 1, //int
			 		'fields' => array('MAX(VEventosMesAnio.cant_eventos)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array(), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($maximo);
			$this->set('maximo', $maximo[0][0]['max']);
			$this->set('cant_eventos', $this->VEventosMesAnio->find('first', array('conditions' => array('year'=>$year, 'mes'=>$mes), 'fields'=>array("sum(cant_eventos) as cant_eventos"))));
			$this->set('cant_personal', $this->VEventosMesAnio->find('first', array('conditions' => array('year'=>$year, 'mes'=>$mes), 'fields'=>array("sum(cant_personal) as cant_personal"))));
			$data = array();
			//pr($datos);
			foreach($datos as $dato){
				$data[$dato['VEventosMesAnio']['year']][$dato['VEventosMesAnio']['mes']] = $dato['VEventosMesAnio']['cant_eventos'];
			}
			//pr($data);
			if(empty($data)){
				$data[$year] = array($mes=>0);	
			}
			//pr($data);
			$this->set('datos', $data);
			
			//OBTENIENDO DATA DE LOS TIPOS DE EVENTOS:
			$data_tipo_eventos = $this->VEventosTipo->find(
				'all', 
				array(
					'conditions' => array('VEventosTipo.year'=>$year, 'VEventosTipo.month'=>$mes), //array de condiciones
					'recursive' => 0, //int
			 		'fields' => array('sum(cant) AS count', 'VEventosTipo.tipo_evento_id', 'VEventosTipo.title'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('VEventosTipo.tipo_evento_id', 'VEventosTipo.title'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($data_tipo_eventos);
			$this->set('data_tipo_eventos', $data_tipo_eventos);
			
			//OBTENIENDO DATA POR NACIONALIDAD DEL EVENTO
			$nacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 1, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde)'=>$mes), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			$internacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 2, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde)'=>$mes), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($internacional);
			if(empty($nacional)) $nacional= array(0=>array(0=>array('count'=>0)));
			if(empty($internacional)) $internacional= array(0=>array(0=>array('count'=>0)));
			$this->set('nacional', $nacional);
			$this->set('internacional', $internacional);
		}
		
		$anios = $this->VEventosMesAnio->find(
		'list', 
		array(
			'conditions' => array(), //array de condiciones
		 	'fields' => array('VEventosMesAnio.year', 'VEventosMesAnio.year'), //array de nombres de campos
			'order' => null, //string o array definiendo el orden
		)
		);
		$this->set('year', $anios);
		
		
	}
	
	function generarPdfMensual($year, $mes) {
		$this->layout = "pdf";
		$this->set("year", $year);
		$this->set("mes", $mes);
		//$cond_trimestre = array(1, 3);
		$tipo_eventos = $this->VEventosTipo->find(
			'all', 
			array(
				'conditions' => array('VEventosTipo.year' => $year, 'VEventosTipo.month'=>$mes), //array de condiciones
				'recursive' => 1, //int
		 		'fields' => array(), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);
		$cant_eventos = $this->VEventosMesAnio->find(
			'all', 
			array(
				'conditions' => array('VEventosMesAnio.year' => $year, 'VEventosMesAnio.mes'=>$mes), //array de condiciones
				'recursive' => 1, //int
		 		'fields' => array('sum(cant_eventos), sum(cant_personal) as cant_personal'), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);

		
		$this->set("tipo_eventos", $tipo_eventos);
		$this->set("cant_eventos", $cant_eventos[0][0]['sum']);
		$this->set("cant_personal", $cant_eventos[0][0]['cant_personal']);
		
		//OBTENIENDO DATA POR NACIONALIDAD DEL EVENTO
			$nacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 1, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde)'=>$mes), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			$internacional = $this->Evento->find(
				'all', 
				array(
					'conditions' => array('Evento.nivel' => 2, 'year(Evento.fecha_desde)'=>$year, 'month(Evento.fecha_desde)'=>$mes), //array de condiciones
					'recursive' => -1, //int
			 		'fields' => array('count(*)', 'year(Evento.fecha_desde)'), //array de nombres de campos
					'order' => null, //string o array definiendo el orden
					'group' => array('year(Evento.fecha_desde)'), //campos para GROUP BY
					'limit' => null, //int
					'page' => null //int
				)
			);
			//pr($internacional);
			if(empty($nacional)) $nacional= array(0=>array(0=>array('count'=>0)));
			if(empty($internacional)) $internacional= array(0=>array(0=>array('count'=>0)));
			$this->set('nacional', $nacional);
			$this->set('internacional', $internacional);
	}
	
	function add_usuario_evento($id=null) {
		//pr($this->data['EventosUsuario']);
		//echo "el id es $id";
		
		if(!empty($this->data['EventosUsuario'])){
			$this->EventosUsuario->create();
			if(!empty($this->data['EventosUsuario']['usuario_id']) && !empty($this->data['EventosUsuario']['evento_id'])){
				if($this->EventosUsuario->save($this->data['EventosUsuario'])){
					$this->set('msg_flash', "El usuario ha sido agregado al evento con exito.");
				}
			}else{
				$this->set('msg_flash', "Por favor seleccione un usuario.");
			}
		}
		if(!is_null($id)) $this->data['EventosUsuario']['evento_id'] = $id;
		else $id = $this->data['EventosUsuario']['evento_id'];
		$eventos_usuarios= $this->EventosUsuario->find(
			'all', 
			array(
				'conditions' => array('EventosUsuario.evento_id' => $id), //array de condiciones
				'recursive' => 1, //int
		 		'fields' => array(), //array de nombres de campos
				'order' => null, //string o array definiendo el orden
				'group' => array(), //campos para GROUP BY
				'limit' => null, //int
				'page' => null //int
			)
		);
		//pr($eventos_usuarios);
		$this->set('eventos_usuarios', $eventos_usuarios);
		$vec = array();
		foreach ($eventos_usuarios as $eu) {
			array_push($vec, $eu['EventosUsuario']['usuario_id']);
		}
		//pr($vec);
		$personal = $this->Usuario->find(
		'list',
		array(
			'conditions' => array('NOT' => array('Usuario.id'=>$vec)), //array de condiciones
		 	'fields' => array('Usuario.id', 'Usuario.name'), //array de nombres de campos
			'order' => null, //string o array definiendo el orden
		)
		);
		$this->set('personal', $personal);
		$this->set('id', $id);
	}
	
	function evento_personal_delete($id) {
		
		if(!is_null($id)){
			$evento_id = $this->EventosUsuario->read('evento_id', $id);
			if($this->EventosUsuario->delete($id)){
				//echo "Eliminado";
				$this->set('msg_flash', "El usuario ha sido eliminado del evento.");
			}else{
				//echo "NO Eliminado";
				$this->set('msg_flash', "El usuario NO ha sido eliminado. Por favor, intente nuevamente.");
			}
		}
		
		//pr($evento_id);
		//echo "evento_id ".$evento_id['EventosUsuario']['evento_id'];
		$this->add_usuario_evento($evento_id['EventosUsuario']['evento_id']);
		$this->render('add_usuario_evento');
	}
	
	function _getCreador($evento_id){
		$evento = $this->Evento->find(
		'first', 
		array(
			'conditions' => array('Evento.id' => $evento_id), //array de condiciones
			'recursive' => -1, //int
		 	'fields' => array('Evento.usuario_id'), //array de nombres de campos
			'order' => null, //string o array definiendo el orden
			'group' => array(), //campos para GROUP BY
			'limit' => null, //int
			'page' => null //int
		)
		);
		return $evento['Evento']['usuario_id'];
	}
	
	function _isCreador($evento_id, $usuario_id=null){
		if(is_null($usuario_id)){
			$usuario_id = $this->Session->read('Auth.Usuario.id');
		}
		
		if($usuario_id == $this->_getCreador($evento_id)){
			return true;
		}else{
			return false;
		}
		
		
	}
	
	
	

}//FIN DEL CONTROLADOR EVENTOS
?>