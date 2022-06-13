<?php

//This file redirect to the main page if no request (at the start)

class HomeController extends Pass{

public function __construct()
{   $username=$this->getUser();
     $password=$this->getPass();
    //parse to get account informations and allow the access
    $adresse = $_SERVER['REQUEST_URI'];
    $tag=explode('/',$adresse);
    $tag=end($tag);
    $tag=explode(',',$tag);
    $user=explode('=',$tag[0]);
    $user=$user[1];
    $pass=explode('=',$tag[1]);
    $pass=$pass[1];

    if($user==$username && $pass==$password){ //Compare between user input and authentification password
       $this-> launchprocess();
    }
    else {
        echo("ERROR");
    }
    

}

private function launchprocess()
{//redirect to the main page 
   require_once ('Views/Testpage.php');   
}

}

?>