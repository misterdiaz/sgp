<?php
class Nivel extends AppModel {

	var $name = 'Nivel';
	var $validate = array(
		'nivel' => array('notempty')
	);

}
?>