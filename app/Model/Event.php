<?php
class Event extends AppModel {

	var $name = 'Event';
	var $useTable = 'events';
	var $validate = array(
		
		'name' => array(
											'rule' => array('minLength', 2),
											'message' => 'Name must be at least 2 characters long',
											'required' => true 
										),
		'notes' => array(
											'rule' => array('minLength', 2),
											'message' => 'Please add some notes',
											'required' => true 
										),
		
	);

}
?>