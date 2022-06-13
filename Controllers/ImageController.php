<?php

// This class DON'T DO CONTAINING VAR_DUMP: that write in the image file
//ImageController generate an image in terms of parameters and force the DL

class ImageController {

    function __construct()
    {
    $adresse = $_SERVER['REQUEST_URI'];
    //Geting the URL and parse them.
    $inf=substr($adresse,12);
    $tabinfo=explode(',',$inf);
    $file=$tabinfo[2];
    $filename=$file;
    // filename is the file direction
    $size=$tabinfo[0];
    $size=explode('=',$size);
    $size=$size[1];
    //Size is the width entered by the user
    $format=$tabinfo[1];
    // Format : JPG,PNJ,WEBP
    $name= explode('.',basename($file));
    //Name is to rename after converting
    $image= new SimpleImage;
    //Loading image in the object SimpleImage (SimpleImage get the type of the original file, the size ,etc...)
    $image->load($filename);
    $image->resizeToWidth($size);
    //resizing to width using a ratio between original and asked width and put the ratio on height
    $newlocation=sys_get_temp_dir()."/".$name[0];
    //temporary file wich contain the new image
    $loc=$image->save($newlocation,$format);
    
//force the download and clean the buffer
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');    
            header('Content-Disposition: attachment; filename="'.basename($loc));
            header('Expires: 0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($loc));
            // Clear output buffer 
            flush();
            readfile($loc);

            exit();

    }

}
?>