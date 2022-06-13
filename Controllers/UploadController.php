<?php

//this file have to goal to parse the tags of the user and add it if they aren't existing . In the same time this file create an image repository to stcok it  

class UploadController extends BDD
{

    public function __construct()
    {   
        $adresse = $_SERVER['REQUEST_URI'];
        //Parsing URL to get tag's entered and url
        $info = explode('/', $adresse);
        $info = end($info);
        $info = explode('|', $info);
        $tag = explode('=', $info[0]);
        $tag = $tag[1];
       // str_replace(" ","",$tag);
        $link = explode('=', $info[1]);
        $link = basename($link[1]);
    
        if (isset($url) && count($url) < 1) {
            require_once("Views/error.php");
        } else {
            //launch the process

            $this->Uploading($tag, $link, 'stockage');
        }
    }

    function Parser($inData)
    { //this function parse the tag's and add them if they aren't exist.
        $data = $val  =  array();
        if ($inData != null) {
            $tags = explode(',', $inData); //create an array of tag's researched
            $img = $this->getET('tag_register'); // get Database tag's
            for ($n = 0; $n < count($img); $n++) { //Exctract all tag's and id's 
                array_push($val,$img[$n][0]);
                array_push($val,$img[$n][1]);

            }
            
            for($n=0;$n<count($tags);$n++){
                $test=$val;
                if( strpos(" ",$tags[$n])==0){substr($tags[$n],1,null);};
                if (array_search(strtolower($tags[$n]),$test) !== false) { //compare tag's and user search
                    $point=array_search(strtolower($tags[$n]),$test);
                    array_push($data, $test[$point-1]);
                    
                }else{

                        $new = $this->createTag('tag_register', $tags[$n]);
                        array_push($data, $new);
                        //add id of new tag
                        unset($tags[$n]);
                       
                        //security to not create twice a same tag
                
                }
            }

            if ($data == null) {
            } else {

                return $data;
            }
        }
    }




    function createUrl($url, $lastid)
    {
        //this function create a new repository for an image with the following path : public/idofimageindatabse/name.type
        $id = array($lastid);
        if (strstr($url, ".mp3") || strstr($url, ".wav") || strstr($url, ".mp4") || strstr($url, ".ogg") || strstr($url, ".mov")) {
            mkdir('public/video/' . $id[0]);
            $ul = 'public/video/' . $lastid . '/';
            $link = $this->Upload($ul, $url);
            return $link;
        } else {
            mkdir('public/' . $id[0]);
            $ul = 'public/' . $lastid . '/';
            $link = $this->Upload($ul, $url);
            return $link;
        }
    }


    function Upload($dossier, $url)
    { { //try to save the file in the new repository

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $dossier . $url)) {
                echo 'Upload effectué avec succès !';
            } else {
                echo 'Echec de l\'upload !';
            }
            return $url; //return url to the database
        }
    }


    function Uploading($tag, $url, $table1)
    {

        if ($url == null) {
            echo "Aucun Fichier";
            return;
        }
        $newtag = '';

        $newid = $this->createOne($table1);
        //create a new space for the new image in database
        $itag = $this->Parser($tag);
        if (is_null($itag)) {
        } else $newtag = implode(",", $itag);
        $link = $this->createUrl($url, $newid);
        //create the new url
        $finalid = (int)$newid;
        if (strstr($url, ".mp3") || strstr($url, ".wav") || strstr($url, ".mp4") || strstr($url, ".ogg") || strstr($url, ".mov")) {
            $finalurl = 'public/video/' . $finalid . '/' . $link;
        } else {
            $finalurl = 'public/' . $finalid . '/' . $link;
        }
        $this->updateTable($finalid, $newtag, $finalurl, $table1);
        //insert the image and this parameters in the space create 
        require_once("Controllers/JsonGenerateController");
        new JsonGenerateController;
        //update the JSON file to potentially add a new tag 
    }
}
