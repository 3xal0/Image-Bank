<?php 

//The router is the center of the project. Is parsing & redirecting all HTML request.

class Routeur
{

    public function routeReq(){
        

        try {
            //Loading all Models classes which are used in Controllers files
            spl_autoload_register(function($class){
            require_once('Models/'.$class.'.php');});

            $url = [''];
            if(isset($_GET['url'])){ //Check if a request is asked

                $url = explode('/',filter_var($_GET['url'],FILTER_SANITIZE_URL));

// Parse the request. Example -> image/width=500 

                $controller = ucfirst(strtolower($url[0]));  

// Now we have -> $controller = Image.  In fact explode have cut the request at the '/'. Next we have put the first letter upper.

                $controllerClass= $controller."Controller";

//Add the string 'Controller' so -> controllerClass = ImageController
                
                $controllerFile = "Controllers/".$controllerClass.".php";

// Add strings 'Controllers/' and the '.php' so -> controllerFile = Controllers/ImageController.php

                if(file_exists($controllerFile)){

// if the request is existing -> require and call
                    require_once($controllerFile);
                    $this->ctrl=new $controllerClass($url);
                }else {
                    throw new \Exception("page introuvable",1);
                }

            }
            else{
                // if no request are asked (at the launching) -> go to the auth page
               require_once('Controllers/AuthController.php');
                $this->ctrl = new AuthController($url);
            }
            if(!file_exists('Data.json')){
                //check if the json file is generate. If he's not, he's generate.
                require_once('Controllers/JsonGenerateController.php');
                 new JsonGenerateController();
            }

        }catch(\Exception $e){
            throw new \Exception("page introuvable",1);

        }
    }
}

?>