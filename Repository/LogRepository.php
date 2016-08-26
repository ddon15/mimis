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
    public function createLogs(array $logDetails){
        $log = new Log();
        
        $query2 = "INSERT INTO log SET activity_log_id=:log_id, user_whoCreate_id=:user_whoCreate_id, dateCreated=:dateCreated, description=:description";
        $stmt2 = $this->conn->prepare($query2);

        $logGetFunction = '';
        switch($logDetails['activity']){
            case $logDetails['activity'] == $log::USER_LOG :
                $logGetFunction = $log->getUser();
            break;
            case $logDetails['activity'] == $log::OVERTIME_LOG :
                 $logGetFunction = $log->getOvertime();
            break;
            case $logDetails['activity'] == $log::LEAVE_LOG :
                 $logGetFunction = $log->getLeave();
            break;
        }
        $logDescription = $logGetFunction;

        $stmt2->bindParam(":log_id", $logDetails['activity']);
        $stmt2->bindParam(":user_whoCreate_id",$logDetails['user_id']);
        $stmt2->bindParam(":dateCreated",$log->getDateTime());
        $stmt2->bindParam(":description", $logDescription[$logDetails['log_process']]);

        ($stmt2->execute()) ? true : false ;
    }
}