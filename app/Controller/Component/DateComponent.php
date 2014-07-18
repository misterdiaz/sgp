<?php
App::uses('Component', 'Controller');

class DateComponent extends Component {
     
 
    public static function get_fecha_actual() {
 
        return substr(DateComponent::get_fecha_hora_actual(), 0, 10);
 
    }
 
    public static function get_fecha_hora_actual() {        
 
        return date('Y-m-d H:i:s');
 
    }
 
    public static function get_dia_semana_actual_numero() {
 
        return date("w", time());
 
    }
 
    public static function get_dia_semana_numero($date_as_string) {
 
        return date("w", strtotime($date_as_string));
 
    }
 
    public static function restar_dias_a_fecha_actual($days) {
 
        $operation = "-";

        if ($days < 0) {
            $operation = "+";
            $days = abs($days);
        }   
 
        $newdate = strtotime ( $operation. $days .' day' ,strtotime ( date('Y-m-d') )) ;

        return date ( 'd-m-Y' , $newdate );

    }

    public static function restar_dias_a_fecha($date_as_string, $days) {     
 
        $operation = "-";

        if ($days < 0) {
 
            $operation = "+";
 
            $days = abs($days);
 
        }       
 
        $newdate = strtotime ( $operation . $days .' day' , strtotime ( $date_as_string) ) ;
 
        $newdate = date ( 'd-m-Y' , $newdate );
 
        return $newdate;
 
    }
 
    public static function get_dia_inicio_semana_laboral_actual() {
 
        $monday_delta = 0;
 
        $current_day_of_week = DateComponent::get_dia_semana_actual_numero();

        if($current_day_of_week > 1) {
 
            $monday_delta = $current_day_of_week-1;
 
        } else if($current_day_of_week == 0){
 
            $monday_delta = -1;
 
        }
 
        return DateComponent::restar_dias_a_fecha_actual($monday_delta);
 
    }

    public static function get_dia_inicial_semana_laboral($date_as_string) {        
 
        $monday_delta = 0;      
 
        $day_of_week = DateComponent::get_dia_semana_numero($date_as_string);

        if($day_of_week > 1) {           
 
            $monday_delta = $day_of_week-1;
 
        } else if($day_of_week == 0){
 
            $monday_delta = -1;
 
        }       
 
        return DateComponent::restar_dias_a_fecha($date_as_string, $monday_delta);
 
    }

    public static function get_delta_for_end_day_of_work_week($current_day_of_week) {
 
        $friday_delta = 0;      

        switch ($current_day_of_week) {
 
            case 0: // Sunday.
                $friday_delta=-5;
                break;
 
            case 1: // Monday.
                $friday_delta=-4;
                break;
 
            case 2: // Tuesday.
                $friday_delta=-3;
                break;
 
            case 3: // Wednesday.
                $friday_delta=-2;
                break;
 
            case 4: // Thursday.
                $friday_delta=-1;
                break;
 
            case 5: // Friday.
                $friday_delta=0;
                break;
 
            case 6: // Saturday.
                $friday_delta=1;
                break;          
 
        }       
 
        return $friday_delta;
 
    }

    public static function get_dia_final_semana_laboral_actual() {
 
        $friday_delta = 0;

		$current_day_of_week = DateComponent::get_dia_semana_actual_numero();      
		
        return DateComponent::restar_dias_a_fecha_actual(DateComponent::get_delta_for_end_day_of_work_week($current_day_of_week ));

    }

    public static function get_dia_final_semana_laboral($date_as_string) {
 
        $friday_delta = 0;
 
        $current_day_of_week = DateComponent::get_dia_semana_numero($date_as_string);
 
        return DateComponent::restar_dias_a_fecha($date_as_string, DateComponent::get_delta_for_end_day_of_work_week($current_day_of_week));
 
    }

    public static function get_rango_semana_laboral_actual() {
 		
		$week=array();
		$week['desde'] = DateComponent::get_dia_inicio_semana_laboral_actual();
		$week['hasta'] = DateComponent::get_dia_final_semana_laboral_actual();
        return $week;
 
    }
	
	public static function get_rango_semana_laboral($semana=null) {
 		if(is_null($semana)) $semana = date('W');
		$semana_actual = date('W');
		$semanas = $semana_actual - $semana;
		$fecha = date('Y/m/d', strtotime ("-$semanas week") );
		$week=array();
		$week['desde'] = DateComponent::get_dia_inicial_semana_laboral($fecha);
		$week['hasta'] = DateComponent::get_dia_final_semana_laboral($fecha);
		//pr($week);
        return $week;
 
    }

}
 
?>