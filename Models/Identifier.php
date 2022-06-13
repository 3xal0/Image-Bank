<?php

//this file is a class which manipulate informations of 'tag_register' table of database

class Identifier
{

    private $id;
    private $name;

    
    public function __construct(array $data)
    {
        $this->hydrate($data);

    }


    public function hydrate(array $data)
    //hydrate is an autonomus function who automatcally call the setters
    {
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
    public function setName($name)
    {

            $this->name = $name;
        
    }





    public function id()
    {
    return $this->id;
        }
    
    public function name()
    {
        return $this->name
;
    }
}