<?php
App::uses('AppModel', 'Model');
/**
 * VActividad Model
 *
 */
class VActividad extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'actividad_id';
	
	
	
	public function afterFind($results, $primary = false) {
	    foreach ($results as $key => $val) {
	        if (isset($val['VActividad']['fecha_inicio'])) {
	            $results[$key]['VActividad']['fecha_inicio'] = turnFecha($val['VActividad']['fecha_inicio']);
	        }
			if (isset($val['VActividad']['fecha_culminacion'])) {
	            $results[$key]['VActividad']['fecha_culminacion'] = turnFecha($val['VActividad']['fecha_culminacion']);
	        }
			
	    }
	    return $results;
	}

}
