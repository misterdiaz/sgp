<?php
class TipoEvento extends AppModel {

	var $name = 'TipoEvento';
	var $validate = array(
		'title' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Evento' => array(
			'className' => 'Evento',
			'foreignKey' => 'tipo_evento_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>