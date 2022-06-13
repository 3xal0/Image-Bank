<?php
//this file is a class which manipulate informations of 'stockage' table of database
class Tabs
{

    private $id;
    private $etiquette;
    private $url;
    
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }


    public function hydrate(array $data)
    {
    //hydrate is an autonomus function who automatcally call the setters
            foreach ($data as $cle=> $value) {
                
                foreach ($value as $key=>$res) {
                $method = 'set'.ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($res);}}
                
               
            }
        }

    public function setId($id)
    {

            $this->id = $id;
        
    }
    public function setEtiquette($etiquette)
    {
      
            $this->etiquette = $etiquette;
       
    }
    public function setUrl($url)
    {
        if (is_string($url)) {
            $this->url = $url;
        }
    }





    public function id()
    {
    return $this->id;
        }
    
    public function name()
    {
        return $this->etiquette;
    }
    public function url()
    {
        return $this->url;
    }



}