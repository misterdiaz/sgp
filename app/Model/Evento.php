<?php
class Evento extends AppModel {

	var $name = 'Evento';
	var $validate = array(
		'name' => array('notempty'),
		'descripcion' => array('notempty'),
		'institucion' => array('notempty'),
		'tipo_evento_id' => array('numeric'),
		'pais_id' => array('numeric'),
		'estado_id' => array('numeric'),
		'direccion' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'TipoEvento' => array(
			'className' => 'TipoEvento',
			'foreignKey' => 'tipo_evento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Paises' => array(
			'className' => 'Paises',
			'foreignKey' => 'pais_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Estado' => array(
			'className' => 'Estado',
			'foreignKey' => 'estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	var $hasMany = array(
		'Material' => array(
			'className' => 'Material',
			'foreignKey' => 'evento_id',
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
	
	function afterFind($resultados){
		
		//echo "entro al foreach";
		if(key_exists('Evento', $resultados)){
			foreach($resultados as $resultado){
				$resultado['Evento']['fecha_desde']= turnFecha($resultado['Evento']['fecha_desde']);
				$resultado['Evento']['fecha_hasta']= turnFecha($resultado['Evento']['fecha_hasta']);
			}
		}
		//pr($resultados);
		//echo "salgo del foreach";
		return $resultados;
	}

}
?>