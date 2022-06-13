<?php

class SupprController extends BDD{
    function __construct()
    {
        $adresse = $_SERVER['REQUEST_URI'];
        $adresse =  explode('/',$adresse);
        $adresse = end($adresse);
        var_dump($adresse);
        $adresse= "public/photo_upload/".$adresse;
        var_dump($adresse);
        $this->deleteUser($adresse,'stockage');
        
echo "<script language='javascript'>window.close()</script>";

    }
}