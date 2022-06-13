<?php 

//This file is automatically launch at the start. Is redirecting to the router.

require_once('Controllers/Routeur.php');

$Routeur = new Routeur();

$Routeur->routeReq();


?>