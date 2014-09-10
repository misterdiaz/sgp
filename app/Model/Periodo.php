<?php
App::uses('AppModel', 'Model');
/**
 * Periodo Model
 *
 * @property Usuario $Usuario
 * @property Vacacion $Vacacion
 */
class Periodo extends AppModel {


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
		)
	);

}
