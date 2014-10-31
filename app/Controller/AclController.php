<?php

class AclController extends AppController
{

    public $name = 'Acl';
    public $uses = array ('Aro', 'Aco', 'Usuario', 'Rol');
	public $helpers = array('Js');
    public $components = array ('RequestHandler', 'Auth', 'Acl');
	public $paginate = array(
        'Aro' => array ('limit' => 10, 'order' => array('Aro.id' => 'asc')),
    );
	

	function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->authorize = 'crud';
		$this->Auth->mapActions(
			array(
			'create' => array('admin_aco_add', 'admin_aro_add'),
			'read' => array('admin_aro_view', 'admin_aco_view', 'admin_acos', 'admin_aros'),
			'update' => array('admin_permisos', 'admin_aro_view_miembros', 'admin_aro_miembro_add', 'admin_grupo_permiso', 'admin_aro_miembro_add_permiso', '_setPermisos', 'buildAcl'),
			//'delete' => array('evento_personal_delete')
			)
		);
		//$this->Auth->allowedActions = array('*');
	}
    
	function admin_index() {
		//$this->layout = "admin";
	}
	
	function admin_aro_view($id=null){
		
		if(is_null($id) && !empty($this->data)){
			
			$id = $this->data['Aro']['parent_id'];
		}
		
		$this->set('aro', $this->Aro->read(null, $id));
		
		$listado = $this->Aro->find(
		'all',
			array (
			'conditions'=> array ('Aro.parent_id'=>$id), //array de condiciones
			'recursive'=>1, //int
			'fields'=> array ('Aro.alias', 'Aro.foreign_key'), //array de nombres de campos
			'order'=>null, //string o array definiendo el orden
			'group'=> array (), //campos para GROUP BY
			'limit'=>null, //int
			'page'=>null //int
			)
		);
		
		//pr($listado);
		
		$this->set('listado', $listado);
		
		$usuarios = $this->Usuario->find(
			'list',
			array (
			'conditions'=> array ('Usuario.id NOT IN(SELECT foreign_key FROM aros)'), //array de condiciones
			'fields'=> array ('Usuario.id', 'Usuario.login'), //array de nombres de campos
			'order'=>null, //string o array definiendo el orden
			)
		);
		$this->set('foreing_key', $usuarios);
		
		if(!empty($this->data)){
			$aro = new Aro();
			$aro->create();
			if($aro->save($this->data['Aro'])){
				$this->redirect('admin_aro_view/'.$id);
			}
		}
		
	}
	
	function admin_aros() {
		//$this->layout = "admin";
		$this->Aro->recursive = 0;
		$this->set('aros', $this->paginate('Aro', array('parent_id'=>NULL), array('order'=>'Aro.id')));
	}
	
	function admin_acos() {
		//$this->layout = "admin";
		$this->Aco->recursive = 0;
		$this->set('acos', $this->paginate('Aco', 'parent_id=2 OR parent_id=null'));
	}

	public function admin_aro_add() {
		//$this->layout = "admin";
		if($this->request->is("post")){
			//pr($this->data);
			$aro = new Aro();
			$aro->create();
			if($aro->save($this->request->data)){
				$this->redirect(array('action'=>'aros', 'admin'=>'true'));
			}
		}

	}
	
	function aco_define(){
		$aros = $this->Aro->find(
		'list',
		array (
		'conditions'=> array (), //array de condiciones
		'fields'=> array ('Aro.id', 'Aro.alias'), //array de nombres de campos
		'order'=>null, //string o array definiendo el orden
		)
		);
		$this->set('aros', $aros);
	}
	
	function admin_aco_add(){
		//$this->layout = "admin";
		if(!empty($this->data)){
			
			if (isset($this->data['parent_id']) &&  !$this->data['parent_id']) {
				$this->data['AclAco']['parent_id'] = null;
			}
			//pr($this->data);exit;
			$aco = new Aco();
			$aco->create();
			
			if($aco->save($this->data['Aro'])){
				$this->redirect('admin_acos');	
			}
		}
		
	}
	
	function admin_permisos(){
		//$this->layout = "admin";
		//pr($this->Auth->user());
		$aros = $this->Rol->find('list',
			array (
				'fields'=> array('Rol.id', 'Rol.nombre'), //array de nombres de campos
				//'conditions'=>array(''=>null),
				'order'=>array('Rol.id'), //string o array definiendo el orden
			)
		);
		//pr($aros);
		$this->set('aros', $aros);
	}
	
	function admin_aro_view_miembros(){
		//pr($this->data);
		if(!empty($this->data) && $this->data['Acl']['aro']){
			$aro_id = $this->data['Acl']['aro'];
			$miembros = $this->Aro->find('all',
				array (
					'conditions'=> array ('Aro.parent_id'=>$aro_id), //array de condiciones
					'recursive'=>1, //int
					'fields'=> array ('Aro.id', 'Aro.alias'), //array de nombres de campos
					'order'=>null, //string o array definiendo el orden
					'group'=> array (), //campos para GROUP BY
					'limit'=>null, //int
					'page'=>null //int
				)
			);
			$grupo = $this->Aro->find('all',
				array (
					'conditions'=> array ('Aro.id'=>$aro_id), //array de condiciones
					'recursive'=>1, //int
					'fields'=> array ('Aro.id'), //array de nombres de campos
					'order'=>null, //string o array definiendo el orden
					'group'=> array(), //campos para GROUP BY
					'limit'=>null, //int
					'page'=>null //int
				)
			);
			//echo $aro_id;
			
			$objetos = $this->Aco->find('list',
				array (
					'conditions'=> array ('parent_id=1'), //array de condiciones
					'recursive'=>1, //int
					'fields'=> array ('Aco.id', 'Aco.alias'), //array de nombres de campos
					'order'=>null, //string o array definiendo el orden
					'group'=> array (), //campos para GROUP BY
					'limit'=>null, //int
					'page'=>null //int
				)
			);
			$this->set('aro_id', $aro_id);
			
		}else{
			$grupo = $miembros = $objetos =array();
		}
		//pr($miembros);
		//pr($grupo);
		$this->set('grupo', $grupo);
		$this->set('miembros', $miembros);
		$this->set('objetos', $objetos);
		
		
	}

	public function admin_procesar_permiso() {

	}
	
	function admin_grupo_permiso($aro_id) {
		$this->request->data['Acl']['aro'] = $aro_id;
		$aco_id = $this->request->data['Acl']['aco'];
		$aro_alias = $this->Aro->read('alias', $aro_id);
		$aro_alias = $aro_alias['Aro']['alias'];
		$aco_alias = $this->Aco->read('alias', $aco_id);
		$aco = $aco_alias['Aco']['alias'];
		$fk = $this->Aro->read('foreign_key', $aro_id);
		//pr($this->request->data['Acl']['permisos']);exit;
		//pr($fk);
		$aro= array('model'=>'Rol', 'foreign_key'=>$fk['Aro']['foreign_key']);
		$tipo = $this->request->data['Acl']['tipo'];
		if($this->_setPermisos($aro, $aco, $tipo, $this->request->data['Acl']['permisos'])){
			$this->Session->setFlash(__('Los permisos han sido asignados con exito'));
		}else{
			$this->Session->setFlash(__('Los permisos no han sido asignados. Por favor, verifique los datos he intente nuevamente'));
		}
		$aro_id = $this->request->data['Acl']['aro'];
			$miembros = $this->Aro->find(
			'all',
				array (
				'conditions'=> array ('Aro.parent_id'=>$aro_id), //array de condiciones
				'recursive'=>1, //int
				'fields'=> array ('Aro.id', 'Aro.alias'), //array de nombres de campos
				'order'=>null, //string o array definiendo el orden
				'group'=> array (), //campos para GROUP BY
				'limit'=>null, //int
				'page'=>null //int
				)
			);
			$grupo = $this->Aro->find(
			'all',
				array (
				'conditions'=> array ('Aro.id'=>$aro_id), //array de condiciones
				'recursive'=>1, //int
				'fields'=> array ('Aro.id', 'Aro.alias'), //array de nombres de campos
				'order'=>null, //string o array definiendo el orden
				'group'=> array (), //campos para GROUP BY
				'limit'=>null, //int
				'page'=>null //int
				)
			);
			
			$objetos = $this->Aco->find(
			'list',
				array (
				'conditions'=> array ("parent_id=1"), //array de condiciones
				'recursive'=>1, //int
				'fields'=> array ('Aco.id', 'Aco.alias'), //array de nombres de campos
				'order'=>null, //string o array definiendo el orden
				'group'=> array (), //campos para GROUP BY
				'limit'=>null, //int
				'page'=>null //int
				)
			);
			
		
		$this->set('grupo', $grupo);
		$this->set('miembros', $miembros);
		$this->set('objetos', $objetos);
		$this->redirect(array('controller'=>'Acl', 'action' => 'permisos', 'admin'=>true));
		//$this->render('admin_aro_view_miembros');
		
	}
	
	function _setPermisos($aro=null, $aco=null, $tipo=-1, $permisos= array()){
		
		if(is_null($aco) || is_null($aro)){
			return false;
		}
		
		switch($tipo){
			case 1:
				if(isset($permisos['all'])){
					$this->Acl->allow($aro, $aco);
				}else{
					foreach($permisos as $key=>$value){
						//echo "$key => $value";
						$this->Acl->allow($aro, $aco, $value);
					}
				}
						
			break;
			case -1:
				if(isset($permisos['all'])){
					$this->Acl->deny($aro, $aco);
				}else{
					foreach($permisos as $key=>$value){
						//echo "$key => $value";
						$this->Acl->deny($aro, $aco, $value);
					}
				}
			break;
				
		}
		//exit;
		return true;
	}
	
	function _setPermisosMiembros($foreign_key=null, $aco, $tipo=-1, $permisos= array(), $model='Usuario'){
		
		if(is_null($aco) || is_null($foreign_key)){
			return false;
		}
		
		switch($tipo){
			case 1:
				if(isset($permisos['all'])){
					$this->Acl->allow(array('model'=>$model, 'foreign_key'=>$foreign_key), $aco);
				}else{
					foreach($permisos as $key=>$value){
						//echo "$key => $value";
						$this->Acl->allow(array('model'=>$model, 'foreign_key'=>$foreign_key), $aco, $key);
					}
				}
						
			break;
			case -1:
				if(isset($permisos['all'])){
					$this->Acl->deny(array('model'=>$model, 'foreign_key'=>$foreign_key), $aco);
				}else{
					foreach($permisos as $key=>$value){
						//echo "$key => $value";
						$this->Acl->deny(array('model'=>$model, 'foreign_key'=>$foreign_key), $aco, $key);
					}
				}
			break;
				
		}
		return true;
	}
	
	function admin_aro_miembro_add($aro_id) {
		//$this->layout= "ajax";
		$usuarios = $this->Usuario->find(
		'list', 
		array(
			'conditions' => array('Usuario.rol_id' => $aro_id), //array de condiciones
		 	'fields' => array('Usuario.id', 'Usuario.login'), //array de nombres de campos
			'order' => 'Usuario.login', //string o array definiendo el orden
		)
		);
		$this->set('usuarios', $usuarios);
		$objetos = $this->Aco->find(
			'list',
				array (
				'conditions'=> array ('parent_id=1'), //array de condiciones
				'recursive'=>1, //int
				'fields'=> array ('Aco.id', 'Aco.alias'), //array de nombres de campos
				'order'=>null, //string o array definiendo el orden
				'group'=> array (), //campos para GROUP BY
				'limit'=>null, //int
				'page'=>null //int
				)
		);
		$this->set('objetos', $objetos);
		$this->set('aro_id', $aro_id);
		
		if ($this->request->is('post')) {
			$this->admin_aro_miembro_add_permiso($aro_id);
			$this->redirect(array('controller'=>'Acl', 'action' => 'permisos', 'admin'=>true));
		}
	}
	
	function admin_aro_miembro_add_permiso($aro_id){
		
		//pr($this->data);
		$aco_id = $this->data['Acl']['aco_id'];
		$usuario_id = $this->data['Acl']['usuario_id'];
		$aro_alias = $this->Aro->read('alias', $aro_id);
		$aro_alias = $aro_alias['Aro']['alias'];
		$aco_alias = $this->Aco->read('alias', $aco_id);
		$aco = $aco_alias['Aco']['alias'];
		$tipo = $this->data['Acl']['tipo'];
		
		if($this->_setPermisosMiembros($usuario_id, $aco, $tipo, $this->data['Acl']['permisos'])){
			//$this->set('msg_flash', "Los permisos han sido asignados con exito.");
			$this->Session->setFlash("Los permisos han sido asignados con exito.");
		}else{
			//$this->set('msg_flash', "Los permisos no han sido asignados. Por favor, verifique los datos he intente nuevamente");
			$this->Session->setFlash("Los permisos no han sido asignados. Por favor, verifique los datos he intente nuevamente");
		}
		$miembros = $this->Aro->find(
		'all',
			array (
			'conditions'=> array ('Aro.parent_id'=>$aro_id), //array de condiciones
			'recursive'=>1, //int
			'fields'=> array ('Aro.id', 'Aro.alias'), //array de nombres de campos
			'order'=>null, //string o array definiendo el orden
			'group'=> array (), //campos para GROUP BY
			'limit'=>null, //int
			'page'=>null //int
			)
		);
		$grupo = $this->Aro->find(
		'all',
			array (
			'conditions'=> array ('Aro.id'=>$aro_id), //array de condiciones
			'recursive'=>1, //int
			'fields'=> array ('Aro.id', 'Aro.alias'), //array de nombres de campos
			'order'=>null, //string o array definiendo el orden
			'group'=> array (), //campos para GROUP BY
			'limit'=>null, //int
			'page'=>null //int
			)
		);
		
		$objetos = $this->Aco->find(
		'list',
			array (
			'conditions'=> array ('parent_id'=>'2'), //array de condiciones
			'recursive'=>1, //int
			'fields'=> array ('Aco.id', 'Aco.alias'), //array de nombres de campos
			'order'=>null, //string o array definiendo el orden
			'group'=> array (), //campos para GROUP BY
			'limit'=>null, //int
			'page'=>null //int
			)
		);
			
		$this->request->data['Aro']['aro'] = $aro_id;
		$this->set('grupo', $grupo);
		$this->set('miembros', $miembros);
		$this->set('objetos', $objetos);
		$this->redirect(array('controller'=>'Acl', 'action' => 'permisos', 'admin'=>true));
	}
	
	function admin_buildAcl() {
        $log = array();
 
        $aco =& $this->Acl->Aco;
        $root = $aco->node('controllers');
        if (!$root) {
            $aco->create(array('parent_id' => null, 'model' => null, 'alias' => 'controllers'));
            $root = $aco->save();
            $root['Aco']['id'] = $aco->id; 
            $log[] = 'Creado el nodo Aco para los controladores';
        } else {
            $root = $root[0];
        }   
 
        App::import('Core', 'File');
        $Controllers = Configure::listObjects('controller');
        $appIndex = array_search('App', $Controllers);
        if ($appIndex !== false ) {
            unset($Controllers[$appIndex]);
        }
        $baseMethods = get_class_methods('Controller');
        $baseMethods[] = 'buildAcl';
 
        // miramos en cada controlador en app/controllers
        foreach ($Controllers as $ctrlName) {
            App::import('Controller', $ctrlName);
            $ctrlclass = $ctrlName . 'Controller';
            $methods = get_class_methods($ctrlclass);
 
            //buscar / crear nodo de controlador
            $controllerNode = $aco->node('controllers/'.$ctrlName);
            if (!$controllerNode) {
                $aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $ctrlName));
                $controllerNode = $aco->save();
                $controllerNode['Aco']['id'] = $aco->id;
                $log[] = 'Creado el nodo Aco del controlador '.$ctrlName;
            } else {
                $controllerNode = $controllerNode[0];
            }
 
            //Limpieza de los metodos, para eliminar aquellos en el controlador 
            //y en las acciones privadas
            foreach ($methods as $k => $method) {
                if (strpos($method, '_', 0) === 0) {
                    unset($methods[$k]);
                    continue;
                }
                if (in_array($method, $baseMethods)) {
                    unset($methods[$k]);
                    continue;
                }
                $methodNode = $aco->node('controllers/'.$ctrlName.'/'.$method);
                if (!$methodNode) {
                    $aco->create(array('parent_id' => $controllerNode['Aco']['id'], 'model' => null, 'alias' => $method));
                    $methodNode = $aco->save();
                    $log[] = 'Creado el nodo Aco para '. $method;
                }
            }
        }
        debug($log);
    }

	
	

}//FIN DEL CONTROLADOR ACL
?>