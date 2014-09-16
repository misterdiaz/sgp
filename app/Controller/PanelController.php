<?php
 /*********************************************************************************
*  República Bolivariana de Venezuela                     
*  Ministerio del Poder Popular de Ciencia y Tecnologia
*  Fundación Instituto de Ingenieria                                                                                                                              
*  Centro de Procesamiento Digital de Imagenes - (CPDI)                                    
*                                                                                 
*                                                                                                  
*  Creado por: Ing. Luis Diaz - ldiazj@fii.gob.ve    			                                                                      
*	                                                                              
***********************************************************************************/

//Fecha de Creación:  26/08/2010

class PanelController extends AppController
{

    var $name = 'Panel';
    var $helpers = array ('Html', 'Form');
    var $uses = array ('Actividad', 'Permiso', 'Periodo', 'ImagenPerfil');
    var $components = array ('RequestHandler', 'Auth');

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->mapActions(
			array(
			'create' => array('buildAcl'),
			'read' => array('index'),
			'update' => array('admin_index'),
			//'delete' => array('evento_personal_delete')
			)
		);
		//$this->Auth->allowedActions = array('admin_index');
	}
	
    function index(){
        $usuario_id = AuthComponent::user('id');
        $rol_id = AuthComponent::user('rol_id');
        $act_cond = array('responsable_id'=>$usuario_id, "fecha_culminacion BETWEEN ? AND ?" => array(date('Y-m-d'), date('Y-m-d', strtotime("+2 weeks"))));
		$actividades = $this->Actividad->find('all', array(
            'conditions'=>$act_cond, 'recursive'=>-1
        ));
        $per_cond = array('usuario_id'=>$usuario_id, 'status <'=>4);
        $permisos = $this->Permiso->find('all', array(
            'conditions'=>$per_cond, 'recursive'=>-1, 'order'=>'fecha_desde ASC',
            'fields'=>'Permiso.id, fecha_solicitud, fecha_desde, fecha_hasta, status, nro_dias',
        ));
        $periodos = $this->Periodo->Find('all', array(
                'conditions'=>array('usuario_id'=>$this->Auth->user('id'), 'disponible >'=>0),
                'recursive'=>-1, 'order'=>'year ASC',
            ));
        if($rol_id == 2){
           $per_cond = array('status'=>1);
           $solicitudes = $this->Permiso->find('all', array(
                'conditions'=>$per_cond, 'recursive'=>-1, 'order'=>'fecha_desde ASC',
                'fields'=>'Permiso.id, fecha_solicitud, fecha_desde, fecha_hasta, status, nro_dias',
            )); 
           $this->set(compact('solicitudes'));
           //pr($solicitudes);
        }
        $imagen_perfil = $this->ImagenPerfil->field('imagen', array('usuario_id'=>$usuario_id));
        if(empty($imagen_perfil)) $imagen_perfil = "./img/profile.png";
        $this->set(compact('actividades', 'permisos', 'periodos', 'imagen_perfil'));
    }
	
	function admin_index(){
		
    }
    function buildAcl() {
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
    
}
?>