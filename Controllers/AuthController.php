<?php

//This file redirect to the authentification page if no request (at the start)

class AuthController{

public function __construct($url)
{
    if(isset($url) && count($url)>1 )
    {
                //check a potential error if a request arrive here
        throw new \Exception("page introuvable",1);

 
    }
    else {
        $this-> launching();
    }
}

private function launching()
{// Show th authentificaion page
   require_once ('Views/Auth.php');   
}

}

?>