<?php

class RequestRepository
{   
    /*
     * Variable for getting
     * database connection
     */
    public $conn;
    /*
     * Variable for Request Model
     */
    public $model;

    public $logData;
    /*
     * Build Dependencies
     */
    public function __construct(){
        include_once '../../Helper/Request.php';
        include_once '../../Helper/User.php';
        include_once '../../Helper/Log.php';
        include_once '../../conf/connection.php';

        $this->model    = new Request();
        $db             = new Database();
        $this->conn     = $db->getConnection();  
    }
    public function sendLeaveRequest($data){
            $table = $this->model->table_names['leave'];
            $query = "INSERT INTO ".$table." SET user_id=:uid, reason=:reason, start_leave=:start_leave, end_leave=:end_leave, leave_type_id=:leave_type_id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":uid", $data[4]['value']);
            $stmt->bindParam(":reason", $data[1]['value']);
            $stmt->bindParam(":start_leave", $startDate);
            $stmt->bindParam(":end_leave", $endDate);
            $stmt->bindParam(":leave_type_id", $data);
    }
    public function sendOvertimeRequest($data){

        if(is_array($data)) {
            $req = $this->model;

            $newDate    = $req->dateDataTransformer($data[3]['value']);
            $startTime  = $req->timeDataTransformer($data[2]['value']);
            $status     = $req::OT_NEWLY_SENT;
      
            $table = $req->table_names['overtime'];

            $query = "INSERT INTO ".$table." SET user_id=:uid, reason_or_project=:reason_or_project, estimate_time=:estimate_time, date=:date, Overtime_start=:Overtime_start, status=:status";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":uid", $data[4]['value']);
            $stmt->bindParam(":reason_or_project", $data[1]['value']);
            $stmt->bindParam(":estimate_time", $data[0]['value']);
            $stmt->bindParam(":date", $newDate);
            $stmt->bindParam(":Overtime_start", $startTime);
            $stmt->bindParam(":status", $status);

            $ret = ($stmt->execute()) ? true : false ;
            
            $user = new User();
            $log = new Log();
            $query2 = "INSERT INTO log SET activity_log_id=:log_id, user_whoCreate_id=:user_whoCreate_id, dateCreated=:dateCreated, description=:description";
            $stmt2 = $this->conn->prepare($query2);

            $logDescription = $log->getOvertime();
            $logId = $log::OVERTIME_LOG;
            $stmt2->bindParam(":log_id", $logId);
            $stmt2->bindParam(":user_whoCreate_id",$data[4]['value']);
            $stmt2->bindParam(":dateCreated",$user->getDateTime());
            $stmt2->bindParam(":description", $logDescription['send']);

            ($stmt2->execute()) ? true : false ;

            return $ret;
        }
    }
    public function getLeaveTypes(){
            $query = "SELECT * FROM " .$this->model->table_names['leave_type'];
            $stmt = $this->conn->prepare($query);

            return ($stmt->execute()) ? $stmt : false ;
    }
}