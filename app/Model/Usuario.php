<?php
App::uses('AuthComponent', 'Controller/Component');
class Usuario extends AppModel {
	public $name = 'Usuario';
	public $displayField = 'id';
    public $actsAs = array('Acl' => array('type' => 'requester'));
	public $virtualFields = array(
    'fullname' => "(Usuario.nombre || ' ' || Usuario.apellido)"
	);
	//public $actsAs = array('Acl' => array('type' => 'requester', 'enabled'=>false)); 
	public $validate = array(
		'login' => array(
			'between' => array(
				'rule' => array('between',4,20),
				'message' => 'Escriba entre 4 y 20 caracteres',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		/*'clave' => array(
			'between' => array(
				'rule' => array('between',6,10),
				'message' => 'Escriba entre 6 y 15 caracteres',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),*/
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	//public $hasOne = "DiasDisponibles";

	public $belongsTo = array(
		'Rol' => array(
			'className' => 'Rol',
			'foreignKey' => 'rol_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cargo' => array(
			'className' => 'Cargo',
			'foreignKey' => 'cargo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Centro' => array(
			'className' => 'Centro',
			'foreignKey' => 'centro_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
    public function beforeSave($options = array()) {
    	if(!empty($this->data['Usuario']['clave'])) $this->data['Usuario']['clave'] = AuthComponent::password($this->data['Usuario']['clave']);
        return true;
    }
	
	public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['Usuario']['rol_id'])) {
            $groupId = $this->data['Usuario']['rol_id'];
        } else {
            $groupId = $this->field('rol_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array('Rol' => array('id' => $groupId));
        }
    }
	
	public function delete($id = null, $cascade = true){
		if (!$this->id && is_null($id)) {
            return null;
        }
		$this->id = $id;
		$data['Usuario']['status'] = 3;
		if($this->save($data)){
			return true;
		}else{
			return false;
		}
		
	}

	/**
	* hasMany associations
	*
	* @var array
 	*/
	/*public $hasMany = array(
		'VActividad' => array(
			'className' => 'VActividad',
			'foreignKey' => 'responsable_id',
			'dependent' => false,
			//'conditions' => 'status_proyecto=1',
			'fields' => 'DISTINCT VActividad.actividad_id, VActividad.proyecto_id, VActividad.proyecto, VActividad.actividad, VActividad.fecha_inicio, VActividad.fecha_culminacion',
			'order' => 'VActividad.fecha_inicio',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => '',
			'recursive'=>''
		)
	);*/

	/*function hashPasswords($data) {
		if (isset($data['Usuario']['clave'])) {
			$data['Usuario']['clave'] = md5($data['Usuario']['clave']);
			//echo $data['Usuario']['clave'];
			return $data;
		}
		return $data;
	}*/

}
?>