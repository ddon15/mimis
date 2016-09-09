<?php

class MediaRepository
{   
    /*
     * Variable for getting
     * database connection
     */
    public $conn;
    /*
     * Variable for User Model
     */
    public $model;

    public $id;

    public $name;
    
    public $size;
    
    public $type;

    public $lastModifiedToken;

    public $file;

    public function __construct(){
        include_once '../../conf/connection.php';

        $this->model = "media";
        $db             = new Database();
        $this->conn     = $db->getConnection();  
    }
    public function setId($id){
        $this->id = $id;
        return $this->id;
    }
    public function getId(){
        return $this->id;
    }
    public function setName($name){
        $this->name = $name;
        return $this->name;
    }
    public function getName(){
        return $this->name;
    }
    public function setSize($size){
        $this->size = $size;
        return $this->size;
    }
    public function getSize(){
        return $this->size;
    }
    public function setType($type){
        $this->type = $type;
        return $this->type;
    }
    public function getType(){
        return $this->type;
    }
    public function setFile($file){
        $this->file = $file;
        return $this->file;
    }
    public function getFile(){
        return $this->file;
    }
    public function setLastModifiedToken($lastModifiedToken){
        $this->lastModifiedToken = $lastModifiedToken;
        return $this->lastModifiedToken;
    }
    public function getLastModifiedToken(){
        return $this->lastModifiedToken;
    }
    public function upload(){

        $finalCheck = false;
        $check = $this->findMediaById($this->getId());
        foreach ($check as $key => $value) {
            $finalCheck = (count($value['user_id'])>0) ? true : $finalCheck ;
        }

        if($finalCheck == true){
            $query = "UPDATE ". $this->model." SET name=:name, size=:size, type=:type, lastModified_Token=:lastModified_Token WHERE user_id=:user_id";
        }else{
             $query = "INSERT INTO ".$this->model." SET user_id=:user_id, name=:name, size=:size, type=:type, lastModified_Token=:lastModified_Token";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->getId());
        $stmt->bindParam(":type", $this->getType());
        $stmt->bindParam(":name", $this->getName());
        $stmt->bindParam(":size", $this->getSize());
        $stmt->bindParam(":lastModified_Token", $this->getLastModifiedToken());

        return ($stmt->execute()) ? true : false ;
    }
     public function displayAllMedia(){
        
        $query = "SELECT * FROM " .$this->model;
        $stmt = $this->conn->prepare($query);
         
        return ($stmt->execute()) ? $stmt : false ;
    }
    public function findMediaById($id){
        $query = "SELECT * FROM " . $this->model . " WHERE user_id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
         
        return ($stmt->execute()) ? $stmt : false ;
    }
}