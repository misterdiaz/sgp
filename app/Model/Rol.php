<?php
class Rol extends AppModel {
	public $name = 'Rol';
	public $displayField = 'nombre';
	public $validate = array(
		'nombre' => array(
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

	public $hasMany = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'rol_id',
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
	
	public $actsAs = array('Acl' => array('type' => 'requester'));
	
	public function parentNode() {
		//pr($this->data);exit;
		return null;
	}
	
	public function afterSave($created, $options = array()){
		
			//pr($this->data);
			$foreign_key = $this->getLastInsertID();
			$aro = $this->Aro->find('first', 
			array(
				'conditions'=>array('foreign_key'=>$foreign_key, 'model'=>'Rol'),
				'recursive'=>-1
			));
			$this->Aro->read(null, $aro['Aro']['id']);
			$this->Aro->set('alias', $this->data['Rol']['nombre']);
			$this->Aro->save();
			//pr($aro);exit;
		
	}
	
	public function beforeDelete($cascade = true) {
	    $count = $this->Aro->find("count", array(
	        "conditions" => array("foreign_key" => $this->id)
	    ));
	    if ($count == 0) {
	    	//echo "borrado";exit;
	        return true;
	    } else {
	    	//echo "NO borrado";exit;
	        return false;
	    }
	}

}
?>