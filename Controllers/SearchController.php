<?php

//this file have to goal to parse the search of the user and compare it with existing tag's. Next the images with the good tag will spawned

class SearchController extends BDD
{
    public function __construct($params)
    {   

        session_start();
        if(isset($_SESSION['offset'])){
        foreach($_SESSION['offset'] as $n){
        unset($_SESSION['offset']);}}
      $_SESSION['offset']=array('0');
        $adresse = $_SERVER['REQUEST_URI'];
        //Parsing URL to get tag's entered
        $tag = explode('/', $adresse);
        $tag = end($tag);
        $tag = explode('&', $tag);
        $page = $tag[1];
        $tag = explode('=', $tag[0]);
        $tag = end($tag);
        if (isset($url) && count($url) < 1) {
            require_once("Views/error.php");
        } else {
            //launching the SearchControl system with the function Research
            if(!isset($set)){$set=0;}
            $search = $this->Research($tag);
            if ($search == null) {
                return;
            }
            $this->Affichage($search);
            return ;
        }
    }

    function Parser($inData)
    { //this function get all tag's and compare them
        $data = $val  =  array();
        if ($inData != null) {
            $tags = explode(',', $inData); //create an array of tag's researched
            $img = $this->getET('tag_register'); // get Database tag's
            for ($n = 0; $n < count($img); $n++) { //Exctract all tag's and id's 
                $val = $img[$n];
                if (array_search($val[1], $tags) !== false) { //compare tag's and user search
                    array_push($data, $val[0]);
                }
            }

            if ($data == null) {
                echo ("error");
            } else {
                return $data; // data is the array of id
                echo "hye";
            }
        }
    }


function Selector($id){
    $i=0;
    $tab = array();

        $img = $this->getET('stockage'); //get images and they parameters (id's,tag id's,url )
        $length = count($img);
        for ($n = 0; $n < $length; $n++) {
            $val = $img[$n];
            $cursor=$val[0];
            $IDIMG = $val[1];
            $ParseTag = explode(',', $IDIMG);
            foreach ($id as $nbr) {
                if (array_search($nbr, $ParseTag) !== false) { //compare tag's and user search
                    $URLIMG = $val[2];
                    array_push($tab, $URLIMG);
                    $i++;
                    if($i>=6){
                    array_push($_SESSION['offset'],$cursor);
                   
                    return $tab;}
                }
            }
        }
        return $tab;
    // on retourne un tableau avec les id correspondant
}





    function Affichage($URL)
    {            

        //this function will return a div who containg all images corresponding and a bouton to Dl it
        echo "<div class=articles >";
        foreach ($URL as $n) {
            if (strstr($n, ".mp3") || strstr($n, ".wav") || strstr($n, ".mp4") || strstr($n, ".ogg") || strstr($n, ".mov")) {
                $type = explode('.', $n);
                echo "<li class=vfile><video class =video width=500  controls><source src=../$n type=video/$type[1]></video></li>";
            } else {
                $sizeinfo = getimagesize($n);
                $tabimg = array();
                array_push($tabimg, $sizeinfo[0], $sizeinfo['mime']);
                $info = implode(',', $tabimg);
                echo "   <li class=vfile><div class=picture><input type=image src=../$n id=Select class=image onclick=trueimg(src) ><button class=parameters type=button id=$n name=$info onclick=spawn(id,name)><img src=../public/1.png class=screw></button></input></div></li> ";
            }
        }
        echo "</div>";
    }


    function Research($data)
    {
        //this function manage the research
        $parse = $this->Parser($data);
        if ($parse == null) {
            return;
        }
        $select = $this->Selector($parse);
        return $select;
    }
}
