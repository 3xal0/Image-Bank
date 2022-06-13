<?php
class SimpleImage {
    //http://www.white-hat-web-design.co.uk/blog/resizing-images-with-php/
       var $image;
       var $image_type;
     
// This file is a pictures modifier. I get all function we need to get save and modifie them.

       function load($filename) {
     
          $image_info = getimagesize($filename);
          $this->image_type = $image_info[2];
          if( $this->image_type == IMAGETYPE_JPEG ) {
     
             $this->image = imagecreatefromjpeg($filename);
          } elseif( $this->image_type == IMAGETYPE_WEBP ) {
     
             $this->image = imagecreatefromwebp($filename);
          } elseif( $this->image_type == IMAGETYPE_PNG ) {
     
             $this->image = imagecreatefrompng($filename);
          }
       }
       function save($filename, $type, $compression=75, $permissions=null) {

     
          if( $type == "jpeg" || $type == "jpg") {
             $name=$filename.'.jpg';
             imagejpeg($this->image,$name,$compression);
          } elseif( $type == "webp" ) {
            $name=$filename.'.webp';
             imagewebp($this->image,$name);
          } elseif( $type == "png" ) {
            $name=$filename.'.png';
             imagepng($this->image,$name);
          }
          if( $permissions != null) {
     
             chmod($filename,$permissions);
          }
          return $name;
       }
       function output($image_type=IMAGETYPE_JPEG) {
     
          if( $image_type == IMAGETYPE_JPEG ) {
             imagejpeg($this->image);
          } elseif( $image_type == IMAGETYPE_GIF ) {
     
             imagegif($this->image);
          } elseif( $image_type == IMAGETYPE_PNG ) {
     
             imagepng($this->image);
          }
       }
       function getWidth() {
     
          return imagesx($this->image);
       }
       function getHeight() {
     
          return imagesy($this->image);
       }
       function resizeToHeight($height) {
     
          $ratio = $height / $this->getHeight();
          $width = $this->getWidth() * $ratio;
          $this->resize($width,$height);
       }
     
       function resizeToWidth($width) {
          $ratio = $width / $this->getWidth();
          $height = $this->getheight() * $ratio;
          $this->resize($width,$height);
       }
     
       function scale($scale) {
          $width = $this->getWidth() * $scale/100;
          $height = $this->getheight() * $scale/100;
          $this->resize($width,$height);
       }
     
       function resize($width,$height) {
          $new_image = imagecreatetruecolor($width, $height);
          imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
          $this->image = $new_image;
       }     
    
    
   
    function addWaterMark($filename){
          //$filename = '../../upload/3.jpg';
          $stamp = imagecreatefrompng('stamp.png');
          $im = imagecreatefromjpeg($filename);
    
          // Set the margins for the stamp and get the height/width of the stamp image
          $marge_right = 10;
          $marge_bottom = 10;
          $sx = imagesx($stamp);
          $sy = imagesy($stamp);
    
          // Copy the stamp image onto our photo using the margin offsets and the photo 
          // width to calculate positioning of the stamp. 
          imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
    
          // Output and free memory
          //header('Content-type: image/png');
          header('Content-Type: image/jpeg');
          imagejpeg($im, $filename);
          imagedestroy($im);
       }


      }