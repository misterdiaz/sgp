<?php
App::uses('AppModel', 'Model');
/**
 * ReporteActividad Model
 *
 */
class ReporteActividad extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'actividad_id';
	
	public function afterFind($results, $primary = false) {
	    foreach ($results as $key => $val) {
	        if (isset($val['ReporteActividad']['fecha_inicio'])) {
	            $results[$key]['ReporteActividad']['fecha_inicio'] = turnFecha($val['ReporteActividad']['fecha_inicio']);
	        }
			if (isset($val['ReporteActividad']['fecha_culminacion'])) {
	            $results[$key]['ReporteActividad']['fecha_culminacion'] = turnFecha($val['ReporteActividad']['fecha_culminacion']);
	        }
			
	    }
	    return $results;
	}
	

}
