<?php

//this file is an object class with getters and setters to manipulate and communicate with the database

abstract class BDD {

private static $_bdd1;

private static function setBdd1(){
    self::$_bdd1 = new PDO('mysql:host=localhost;dbname=bijoggva_bdd;charset=utf8','bijoggva_user','259AxO436');
    self::$_bdd1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

protected function getBdd1(){
    if(self::$_bdd1==null){
        self::setBdd1();
        return self::$_bdd1;
    }
}

protected function getImage($table,$id){
    $this->getBdd1();
    $var=[];
    $req = self::$_bdd1->prepare(' SELECT*FROM '.$table.' WHERE id ='.$id);
    $var=$req->execute();
    return $var;
    $req->closeCursor();
}

protected function getNames($table,$obj){
    $this->getBdd1();
    $var=[];
    $req = self::$_bdd1->prepare(' SELECT*FROM '.$table.' ORDER BY id desc ');
    $req->execute();

    while($data[] = $req->fetch(PDO::FETCH_ASSOC)){
        
        $var[] =new $obj($data);

    }
    return $var;
    $req->closeCursor();
}

protected function getSelect($table,$obj){
    $this->getBdd1();
    $var=[];
    $req = self::$_bdd1->prepare(' SELECT `etiquette`,`url`FROM '.$table.' ORDER BY id desc ');
    $req->execute();

    while($data[] = $req->fetch(PDO::FETCH_ASSOC)){
        
        $var[] =new $obj($data);

    }
    return $var;
    $req->closeCursor();
}
protected function getetiquette($table,$obj){
    $this->getBdd1();
    $var=[];
    $req = self::$_bdd1->prepare(' SELECT `etiquette`FROM '.$table.' ORDER BY id desc ');
    $req->execute();

    while($data[] = $req->fetch(PDO::FETCH_ASSOC)){
        
        $var[] =new $obj($data);

    }
    return $var;
    $req->closeCursor();
}
protected function geturl($table,$obj){
    $this->getBdd1();
    $var=[];
    $req = self::$_bdd1->prepare(' SELECT `url`FROM '.$table.' ORDER BY id desc ');
    $req->execute();

    while($data[] = $req->fetch(PDO::FETCH_ASSOC)){
        
        $var[] =new $obj($data);

    }
    return $var;
    $req->closeCursor();
}

protected function getET($table){
    $this->getBdd1();
    $req = self::$_bdd1->prepare(' SELECT*FROM '.$table.' ORDER BY id ASC');
    $req->execute();
    $var=$req->fetchAll();
    return $var;
    $req->closeCursor();
}
protected function getTags($table,$offset){
    $this->getBdd1();
    $count=30000;
    $req = self::$_bdd1->prepare(' SELECT*FROM '.$table.' ORDER BY id ASC LIMIT '.$offset.' , '.$count);
    $req->execute();
    $var=$req->fetchAll();
    return $var;
    $req->closeCursor();
}
protected function setNew($table,$tag,$url){
    $this->getBdd1();
    $var=[];
    $req = self::$_bdd1->prepare(" INSERT INTO ".$table."('etiquette','url') VALUES ('$tag','$url')");
    $req->execute();

    $req->closeCursor();
}

protected function createOne($table)
{
    $this->getBdd1();
    $req = self::$_bdd1->prepare(" INSERT INTO ".$table."(etiquette, url) VALUES ('','') ");
    $req->execute();
    $req->closeCursor();

    $lastid=self::$_bdd1->lastInsertId();
    return $lastid;
}


protected function createTag($table,$tag)
{
    $this->getBdd1();
    $req = self::$_bdd1->prepare(" INSERT INTO ".$table."(name) VALUES ('$tag') ");
    $req->execute();
    $req->closeCursor();

    $n=self::$_bdd1->lastInsertId();
    return $n;
}

protected function updateTable($id,$tag,$url,$table){
    $this->getBdd1();
    $sql="UPDATE $table SET `etiquette` = '$tag', `url` ='$url' WHERE `id` = '$id'";
    $req = self::$_bdd1->prepare($sql);
    $req->execute();
    $req->closeCursor();
    
}
protected function deleteUser($url,$table){
    $this->getBdd1();
    $sql = "DELETE FROM ".$table." WHERE `url`= '".$url."'";
    $req = self::$_bdd1->prepare($sql);
    $req->execute();
    $req->closeCursor();

}


}
?>