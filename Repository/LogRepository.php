<?php

class LogRepository
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

    public $logData;
    /*
     * Build Dependencies
     */
    public function __construct(){
        include_once '../../Helper/Log.php';
        include_once '../../conf/connection.php';

        $this->model = new Log();
        $db             = new Database();
        $this->conn     = $db->getConnection();  

        $this->logData = $this->getIdOfLogNameUser();
    }
    public function getIdOfLogNameUser(){

        $query = "SELECT * FROM " .$this->model->activity_table_name;
        $stmt = $this->conn->prepare($query);
        $exec = ($stmt->execute()) ? $stmt : false ;

        $getLogId = '';
        if($exec != false) {
            foreach($exec as $key => $row) {
                if($row['name'] == 'user') { 
                    $getLogId = $row['id'];
                }
            }
        }
        return $getLogId;
    }
    public function getAllUserLogs(){

        // $query = "SELECT * FROM " .$this->model->table_name." WHERE activity_log_id=:id";
        $query = "SELECT * FROM " .$this->model->table_name." ORDER BY dateCreated DESC";
        
        $stmt = $this->conn->prepare($query);

        // $stmt->bindParam(":id", $this->logData);
      
        return ($stmt->execute()) ? $stmt : false ;
    }
}