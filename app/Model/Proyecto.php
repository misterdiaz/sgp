<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * Proyecto Model
 *
 */
class Proyecto extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe ingresar un nombre',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'objetivoGeneral' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Ingrese el objetivo general',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cliente' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Debe ingresar un nombre de cliente',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Seleccione un status',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'fecha_inicio' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Ingrese fecha de inicio',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'fecha_culminacion' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Ingrese fecha de culminacion',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'coordinadorName' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Seleccione un coordinador',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	public $belongsTo = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'coordinador_id',
			'conditions' => array('Usuario.status'=>1),
			'fields' => 'id, fullname, email',
			'order' => ''
		)
	);
	/**
 * hasMany associations
 *
 * @var array
 */

	public $hasMany = array(
		'Objetivo' => array(
			'className' => 'Objetivo',
			'foreignKey' => 'proyecto_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Objetivo.id',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	/*public function beforeSave($options = array()) {
	    if (!empty($this->data['Proyecto']['fecha_inicio']) && !empty($this->data['Proyecto']['fecha_culminacion'])) {
	        $this->data['Proyecto']['fecha_inicio'] = turnFecha($this->data['Proyecto']['fecha_inicio'], 2);
	        $this->data['Proyecto']['fecha_culminacion'] = turnFecha($this->data['Proyecto']['fecha_culminacion'], 2);
	    }
		if (!empty($this->data['Proyecto']['presupuesto'])) {
			$this->data['Proyecto']['presupuesto'] = formatoDB($this->data['Proyecto']['presupuesto']);
		}
	
	    return true;
	}*/
	
	public function afterFind($results, $primary = false) {
	    foreach ($results as $key => $val) {
	        if (isset($val['Proyecto']['fecha_inicio'])) {
	            $results[$key]['Proyecto']['fecha_inicio'] = turnFecha($val['Proyecto']['fecha_inicio']);
	        }
			if (isset($val['Proyecto']['fecha_culminacion'])) {
	            $results[$key]['Proyecto']['fecha_culminacion'] = turnFecha($val['Proyecto']['fecha_culminacion']);
	        }
			if (isset($val['Proyecto']['presupuesto'])) {
	            $results[$key]['Proyecto']['presupuesto'] = formato($val['Proyecto']['presupuesto']);
	        }
			
	    }
	    return $results;
	}
}
