<?php
App::uses('AppModel', 'Model');
/**
 * Permiso Model
 *
 * @property Usuario $Usuario
 * @property Centro $Centro
 */
class Permiso extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nro';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'nro_dias' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debes seleccionar el número de dias del permiso.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'fecha_solicitud' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'centro_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'fecha_desde' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'tipo_permiso' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'causa' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
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
		),
		'Cargo' => array(
			'className' => 'Cargo',
			'foreignKey' => 'cargo_id',
			'conditions' => 'Cargo.status = 1',
			'fields' => 'name, siglas',
			'order' => ''
		)
	);

	public function afterFind($results, $primary = false) {
	    foreach ($results as $key => $val) {
	        if (isset($val['Permiso']['fecha_solicitud'])) {
	            $results[$key]['Permiso']['fecha_solicitud'] = turnFecha($val['Permiso']['fecha_solicitud']);
	        }
			if (isset($val['Permiso']['fecha_desde'])) {
	            $results[$key]['Permiso']['fecha_desde'] = turnFecha($val['Permiso']['fecha_desde']);
	        }
			if (isset($val['Permiso']['fecha_hasta'])) {
	            $results[$key]['Permiso']['fecha_hasta'] = turnFecha($val['Permiso']['fecha_hasta']);
	        }
			
	    }
	    return $results;
	}

	public function aprobar($id){
		$this->id = $id;
		$this->read(null, $id);
		if($this->saveField('status', 2)) return true;
		else return false;
	}

	public function denegar($id){
		$this->id = $id;
		$this->read(null, $id);
		if($this->saveField('status', 3)) return true;
		else return false;
	}

	public function delete($id = NULL, $cascade = true){
		if($this->saveField('status', 4)) return true;
		else return false;
	}
}
