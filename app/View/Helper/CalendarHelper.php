<?php

/**
* Calendar Helper for CakePHP
*
*	Copyright 2008 John Elliott
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
*
* @author John Elliott
* @copyright 2008 John Elliott
* @link http://www.flipflops.org More Information
* @license			http://www.opensource.org/licenses/mit-license.php The MIT License
*
*/

class CalendarHelper extends Helper
{

	var $helpers = array('Html', 'Form', 'Js'=> array('Jquery'));
   
/**
* Generates a Calendar for the specified by the month and year params and populates it with the content of the data array
*
* @param $year string
* @param $month string
* @param $data array
* @param $base_url
* @return string HTML code to display calendar in view
*
*/
	
	function calendar($year = '', $month = '', $data = '', $base_url ='')
		{
			$str = '';
			$month_list = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
			$day_list = array('Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom');
			$day = 1;
			$today = 0;
			
			if($year == '' || $month == '')// just use current yeear & month
				{
					$year = date('Y');
					$month = date('M');
				}
				
		
			
			$flag = 0;
			
			for($i = 0; $i < 12; $i++)
				{
					if(strtolower($month) == $month_list[$i])
						{
							if(intval($year) != 0)
								{
									$flag = 1;
									$month_num = $i + 1;
									break;
								}
						}
				}
			
			
			if($flag == 0)
				{
					$year = date('Y');
					$month = date('F');
					$month_num = date('m');
				}
				
				
			
			$next_year = $year;
			$prev_year = $year;
			
			$next_month = intval($month_num) + 1;
			$prev_month = intval($month_num) - 1;
			
			if($next_month == 13)
				{
					$next_month = 'enero';
					$next_year = intval($year) + 1;
				}
			else
				{
					$next_month = $month_list[$next_month -1];
					
				}
				
			if($prev_month == 0)
				{
					$prev_month = 'diciembre';
					$prev_year = intval($year) - 1;
				}
			else
				{
					$prev_month = $month_list[$prev_month - 1];
				}
				
			
			//echo $year." == ".date('Y')." | ".strtolower($month)." == ".strtolower(mes2letras(date('m')));
			if($year == date('Y') && strtolower($month) == strtolower(mes2letras(date('m'))))
				{	// set the flag that shows todays date but only in the current month - not past or future...
					$today = date('j');
				}
				
			$days_in_month = date("t", mktime(0, 0, 0, $month_num, 1, $year));
						
			$first_day_in_month = date('D', mktime(0,0,0, $month_num, 1, $year));
			
			//echo $first_day_in_month;exit;
			
			$first_day_in_month= $this->traducir_dia($first_day_in_month);
				
			$str .= '<table class="calendar">';
			
			$str .= '<thead>';
			
			$str .= '<tr><th class="cell-prev">';
			
			//$str .= $this->Html->link(__('<<', true), 'calendar/' . $prev_year . '/' . $prev_month);

			$str .= $this->Js->link($this->Html->image("prev.png", array("width"=>"18")), array( "controller"=>"Events", "action"=>"calendar", $prev_year, $prev_month), array( "update" => "#calendar_div", "confirm" =>null, "indicator"=>null, "escape"=>false));
			$str .= $this->Js->writeBuffer();
			
			$str .= '</th><th colspan="5" align="center">' . ucfirst($month) . ' ' . $year . '</th><th class="cell-next">';
			
			$str .= $this->Js->link($this->Html->image('next.png', array('width'=>'18')), array( 'controller'=>'Events', 'action'=>'calendar', $next_year, $next_month), array( 'update' =>'#calendar_div', 'confirm' =>null, 'indicator'=>null, 'escape'=>false ) );
			//$str .= $this->Html->link(__('>>', true), 'calendar/' . $next_year . '/' . $next_month);
			$str .= $this->Js->writeBuffer(); 
			
			$str .= '</th></tr>';
			
			
			
			$str .= '<tr>';
			
				for($i = 0; $i < 7;$i++) {
						$str .= '<th id="calendar_th" class="cell-header">' . $day_list[$i] . '</th>';
				}
				
			$str .= '</tr>';
			
			$str .= '</thead>';
			
			
			$str .= '<tbody>';
		
			
				//echo "day: $day | days_in_month: $days_in_month";exit;
				while($day <= $days_in_month)
					{
						$str .= '<tr>';
						
						
								
								for($i = 0; $i < 7; $i ++)
									{
									
										$cell = '&nbsp;';
										$class = '';
										$link = false;
										if(isset($data[$day]))
											{
												$link = true;
												$cell = $data[$day];
												$class = ' class="date_has_event" ';
											}
											
										
										
										if($i > 4)
											{
												$class = ' class="cell-weekend" ';
											}
											
										
										if($today != 0 && $day == $today)
											{
												$class = ' class="cell-today" ';
											}
										//echo "$first_day_in_month == ".$day_list[$i];exit;
										if(($first_day_in_month == $day_list[$i] || $day > 1) && ($day <= $days_in_month))
											{
												if($link){
													$url = $this->Html->url(array('controller'=>'Events', 'action'=>'view', $year, $month_num, $day));
													$str .= "<td id=\"calendar_td\" $class > <a class='calendar_link' href=\"$url\"> $day</a></td>";
												}else{
													$str .= "<td id=\"calendar_td\" $class >$day</td>";
												}
												
												$day++;
											}
										else
											{
												
														$str .= '<td id="td_blank"' . $class . '>&nbsp;</td>';
											}
									}
								
						$str .= '</tr>';
					}
				
		
			$str .= '</tbody>';
			
			$str .= '</table>';
			
			return $str;
		}
		
		function traducir_dia($dia){
			switch ($dia) {
				case "Mon":
				 return "Lun";
				break;
				case "Tue":
				 return "Mar";
				break;
				case "Wed":
				 return "Mie";
				break;
				case "Thu":
				 return "Jue";
				break;
				case "Fri":
				 return "Vie";
				break;
				case "Sat":
				 return "Sab";
				break;
				case "Sun":
				 return "Dom";
				break;
				
			}
		}
		
	



}

?>
