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

	public function update($data){
		try {
			$result = $this->query('UPDATE periodos SET disponible = ? WHERE usuario_id = ? AND year = ?', array($data['Periodo']['disponible'], $data['Periodo']['usuario_id'], $data['Periodo']['year']));
		} catch (Exception $e) {
			return false;
		}
		return true;

	}

	public function existe($data){
		$cond = array('usuario_id'=>$data['Periodo']['usuario_id'], 'year'=>$data['Periodo']['year']);
		if($this->find('count', array('conditions'=>$cond)) > 0){
			return true;
		}
		return false;	
	}


}
