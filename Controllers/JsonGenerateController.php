<?php

// this file generate a json file who contain all files
class JsonGenerateController extends BDD{

    public function __construct()
{
    
        $this-> JsonGenerate();
    
}
    
    
    private function JsonGenerate(){
        $tab=array();
        $x=2;
        $json=$this->getNames('tag_register','Identifier');
//Getting on the database tags and their id's -> array (id's, tag's)
        foreach ($json as $n => $value) {
            $val = (array)$json[$n];

            foreach ($val as $cle => $s) {
                //We use modulo to get only odd numbers and put them on a new array
                if($x%2 == 1){array_push($tab, $val[$cle]);}
                $x++;
            }
        }
//Convert array into json
        $tabjson=json_encode($tab);
        //generate new JSON file
        file_put_contents("Data.json", $tabjson);
    } 
}

?>