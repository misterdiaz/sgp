<?php
 /*********************************************************************************
*  República Bolivariana de Venezuela                     
*  Ministerio del Poder Popular de Ciencia y Tecnologia
*  Fundación Instituto de Ingenieria                                                                                                                              
*  Centro de Procesamiento Digital de Imagenes - (CPDI)                                    
*                                                                                 
*                                                                                                  
*  Creado por: Ing. Luis Diaz - ldiazj@fii.gob.ve    			                                                                      
*	                                                                              
***********************************************************************************/
ini_set('session.cache_limiter', '');
header('Content-Description: File Transfer');
header('Content-Transfer-Encoding: binary');
header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: no-cache');
//header("Content-Type: application/octet-stream");
echo $content_for_layout;
?>
