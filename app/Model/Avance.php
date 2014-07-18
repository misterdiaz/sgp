<?php
App::uses('AppModel', 'Model');
/**
 * AvanceActividad Model
 *
 * @property Actividad $Actividad
 */
class Avance extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'avance';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'actividad_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'mes' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'year' => array(
			'validYear' => array(
				'rule' => array('validYear'),
				'message' => 'Ingrese un año valido',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		
			
		),
		'porcentaje' => array(
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
	
	public function validYear($check) {
        // $check will have value: array('promotion_code' => 'some-value')
        // $limit will have value: 25
        //pr($check);exit;
        if($check['year'] > date('Y')+1) return false;
		if($check['year'] < date('Y')-2) return false;
		return true;
        //return $existingPromoCount < $limit;
    }
	
	public function existe($data) {
		$avance = $this->Find('first', array(
			'conditions'=>array('Avance.actividad_id'=>$data['Actividad']['actividad_id'], 
							'Avance.year'=>$data['Actividad']['year'],
							'Avance.mes'=>$data['Actividad']['mes']),
			'recursive'=>-1,
			'fields'=>'Avance.id',
		));
		//pr($avance);exit;
		if(empty($avance)) return false;
		else { return $avance['Avance']['id'];	}
	    
	    
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Actividad' => array(
			'className' => 'Actividad',
			'foreignKey' => 'actividad_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
