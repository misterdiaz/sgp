<?php
App::uses('AppModel', 'Model');
/**
 * DiasDisponibl Model
 *
 * @property Usuario $Usuario
 */
class DiasDisponibles extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'nro_dias';

	public $useTable = 'dias_disponibles';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nro_dias';


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
