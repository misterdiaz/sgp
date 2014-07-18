<?php

class PdiHelper extends AppHelper {

 var $width = null;
 var $height = null;
 var $newwidth = 600;
 var $newheight = null;
 var $channels = null;
 var $bits = null;
 var $mime = null;
 function redimensionar($filename, $type=null, $w=null, $h=null){
     //captura el ancho y el alto de la imagen
     $this->setAtributos($filename);
     if(!is_null($type)){
         $this->mime = $type;
     }
     $source = $this->createImageByType($filename, $this->mime);
     if(!$source) return false;

     if($this->width > $this->newwidth){
         $this->newheight = ($this->newwidth * $this->height) / $this->width;//tamaño proporcional
     }else{
         $this->newwidth = $this->width;
         $this->newheight = $this->height;
     }

     $newImage = imagecreatetruecolor($this->newwidth, $this->newheight);

     imagecopyresized($newImage, $source, 0, 0, 0, 0, $this->newwidth, $this->newheight, $this->width, $this->height);

     $this->render($newImage, $filename);

     return TRUE;

 }

 function redimensionarXAltura($filename, $h){
     $this->setAtributos($filename);
     $source = $this->createImageByType($filename, $this->mime);
     $this->newheight = $h;
     $this->newwidth = $this->width / ($this->height / $this->newheight);
     $newImage = imagecreatetruecolor($this->newwidth, $this->newheight);
     imagecopyresized($newImage, $source, 0, 0, 0, 0, $this->newwidth, $this->newheight, $this->width, $this->height);
     $this->render($newImage, $filename);

     return TRUE;
 }

 function setPorcentajeAltura($valor){

     $porcentaje = ($valor * 100) / $this->height;
     $this->newheight = $this->height * $porcentaje;
     $this->newwidth = $this->width * $porcentaje;

 }

 function render($image, $filename, $mime="image/jpeg"){
     switch(strtolower($mime)){
         case "jpg":
             $this->mime = "jpeg";
             return imagejpeg($image, $filename);
         break;

         case "image/jpeg":
             $this->mime = "jpeg";
             return imagejpeg($image, $filename);
         break;

         case "image/png":
             $this->mime = "png";
             return imagepng($image, $filename);;
         break;

         case "image/gif":
             $this->mime = "gif";
             return imagegif($image, $filename);
         break;

         case "text":
             $this->mime = "text";
             return imagejpeg($image, $filename);
         break;
        default:
           return false;
     }
 }

 function setAtributos($filename){
     $file = getimagesize($filename);
     $this->width = $file[0];
     $this->height = $file[1];
     $this->mime = $file['mime'];
 }

 function createImageByType($filename, $mime){

     switch(strtolower($mime)){
         case "jpg":
             $this->mime = "jpeg";
             return imagecreatefromjpeg($filename);
         break;

         case "image/jpeg":
             $this->mime = "jpeg";
             return imagecreatefromjpeg($filename);
         break;

         case "image/png":
             $this->mime = "png";
            return imagecreatefrompng($filename);
         break;

         case "image/gif":
             $this->mime = "gif";
             return imagecreatefromgif($filename);
         break;

         case "text":
             $this->mime = "text";
             return imagecreatefromstring($filename);
         break;

         default:
             return false;
         }
     }
}
?>