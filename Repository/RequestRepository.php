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
        include_once 'LogRepository.php';
        include_once 'UserRepository.php';
        require_once dirname(__FILE__).'\../api/SendSMS.php';

        $this->model    = new Request();
        $db             = new Database();
        $this->conn     = $db->getConnection();  
    }
    public function disapprovedRequest($data){
        $table = ($data[1]['value'] == "Leave") ? "work_leave" : $data[1]['value'] ;
        $id = $data[0]['value'];
        $uid = $data[4]['value'];

        $logName = "";
        if($table == "work_leave") {
            $logName = LOG::LEAVE_LOG;
        }else if($table == "overtime"){
            $logName = LOG::OVERTIME_LOG;
        }else $logName = LOG::USER_LOG;

        foreach ($data as $key => $getNameToProcess) {
            if ($getNameToProcess['name'] == "toProcess") {
               if ($getNameToProcess['value'] == "disapproved") {

                    $req = $this->model;
                    $status = $req::REQUEST_DISAPPROVED;

                    $query = "UPDATE ".$table." SET responsed_by=:responsed_by, status=:status WHERE id=:id";
                    $stmt = $this->conn->prepare($query);

                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":status", $status);
                    $stmt->bindParam(":responsed_by", $uid);
                    
                   if($stmt->execute()){
                        $getUserId = '';
                        foreach ($this->getUserRequestedId($table, $id) as $key => $value) {
                           $getUserId = $value['user_id'];
                        }
                        $user = new UserRepository();
                        $getUserFirstName = '';
                        $getUserMobileNo = '';
                        $getUserResponded = '';
                        foreach ($user->findUserById($uid) as $key => $value) {
                            $getUserResponded = $value['firstname'];
                        }
                        foreach ($user->findUserById($getUserId) as $key => $value) {
                            $getUserFirstName = $value['firstname'];
                            $getUserMobileNo = $value['mobile_no'];
                        }
                        $sms = new SendSMS();
                        $message = "Hello ".$getUserFirstName. " your ".$table." request has been disapproved by ".$getUserResponded;
                        // echo $message;
                        $sms->setNumber($getUserMobileNo);
                        $sms->setMessage($message);
                        $sms->sendSMS();

                        $logArray = [
                            'activity' => $logName,
                            'user_id' => $uid,
                            'log_process' => 'remove'
                        ];
                        $LogRepository = new LogRepository();
                        $LogRepository->createLogs($logArray);

                        return true;
                   }return false;
               }
            }
        }
        return false;
    }
    public function approvedRequest($data){
        $table = ($data[1]['value'] == "Leave") ? "work_leave" : $data[1]['value'] ;
        $id = $data[0]['value'];
        $uid = $data[4]['value'];

        $logName = "";
        if($table == "work_leave") {
            $logName = LOG::LEAVE_LOG;
        }else if($table == "overtime"){
            $logName = LOG::OVERTIME_LOG;
        }else $logName = LOG::USER_LOG;

        foreach ($data as $key => $getNameToProcess) {
            if ($getNameToProcess['name'] == "toProcess") {
               if ($getNameToProcess['value'] == "approved") {

                    $req = $this->model;
                    $status = $req::REQUEST_APPROVED;

                    $query = "UPDATE ".$table." SET responsed_by=:responsed_by, status=:status WHERE id=:id";
                    $stmt = $this->conn->prepare($query);

                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":status", $status);
                    $stmt->bindParam(":responsed_by", $uid);
                    
                    if($stmt->execute()){
                        $getUserId = '';
                        foreach ($this->getUserRequestedId($table, $id) as $key => $value) {
                           $getUserId = $value['user_id'];
                        }
                        $user = new UserRepository();
                        $getUserFirstName = '';
                        $getUserMobileNo = '';
                        $getUserResponded = '';
                        foreach ($user->findUserById($uid) as $key => $value) {
                            $getUserResponded = $value['firstname'];
                        }
                        foreach ($user->findUserById($getUserId) as $key => $value) {
                            $getUserFirstName = $value['firstname'];
                            $getUserMobileNo = $value['mobile_no'];
                        }
                        $sms = new SendSMS();
                        $message = "Hello ".$getUserFirstName. " your ".$table." request has been approved by ".$getUserResponded;
                         $sms->setNumber($getUserMobileNo);
                        $sms->setMessage($message);
                        $sms->sendSMS();

                        $logArray = [
                            'activity' => $logName,
                            'user_id' => $uid,
                            'log_process' => 'approve'
                        ];
                        $LogRepository = new LogRepository();
                        $LogRepository->createLogs($logArray);

                        return true;
                    }else return false;
               }
            }
        }
        return false;
    }
    public function getUserRequestedId($table, $id){
        $query = "SELECT user_id FROM ".$table." WHERE id=:id";
        $getUserId = $this->conn->prepare($query);

        $getUserId->bindParam(":id", $id);

        if ($getUserId->execute()){
            return $getUserId;
        }else return "no user found for that filed request.";
    }
    public function sendLeaveRequest($data){

        foreach ($data as $key => $getNameToProcess) {
            if ($getNameToProcess['name'] == "toProcess") {
               if ($getNameToProcess['value'] == "leave") {

                     # initialize helpers
                    $req = $this->model;
                    $table = $this->model->table_names['leave'];
                    $status = $req::REQUEST_NEWLY_SENT;

                    # transforms
                    $startDate    = $req->dateDataTransformer($data[3]['value']);
                    $endDate      = $req->dateDataTransformer($data[4]['value']);
                    $dateCeated = $req->getDateTime();

                    $query = "INSERT INTO ".$table." SET user_id=:uid, reason=:reason, start_leave=:start_leave, end_leave=:end_leave, dateCreated=:dateCreated, leave_type_id=:leave_type_id, status=:status";
                    $stmt = $this->conn->prepare($query);

                    $stmt->bindParam(":uid", $data[1]['value']);
                    $stmt->bindParam(":reason", $data[2]['value']);
                    $stmt->bindParam(":start_leave", $startDate);
                    $stmt->bindParam(":end_leave", $endDate);
                    $stmt->bindParam(":dateCreated", $dateCeated);
                    $stmt->bindParam(":leave_type_id", $data[0]['value']);
                    $stmt->bindParam(":status", $status);

                    if($stmt->execute()){
                        $logArray = [
                            'activity' => LOG::LEAVE_LOG,
                            'user_id' => $data[1]['value'],
                            'log_process' => 'send'
                        ];
                        $LogRepository = new LogRepository();
                        $LogRepository->createLogs($logArray);

                        return true;
                    }else false;
                }else return false;
            }        
        }
    }
    public function sendOvertimeRequestAdmin($data){
        return false;
    }
    public function sendOvertimeRequest($data){
        
        $transactByAdmin = (isset($data[0]) && $data[0]['name'] == 'empName') ? true : false ;

        foreach ($data as $key => $getNameToProcess) {
            if ($getNameToProcess['name'] == "toProcess") {
               if ($getNameToProcess['value'] == "overtime") {

                        $req = $this->model;

                        if($transactByAdmin == true){
                              $newDate    = $req->dateDataTransformer($data[5]['value']);
                              $startTime  = $req->timeDataTransformer($data[3]['value']);
                        }else{
                                $newDate    = $req->dateDataTransformer($data[4]['value']);
                                $startTime  = $req->timeDataTransformer($data[2]['value']);
                        }

                        $dateCeated = $req->getDateTime();
                        $status     = $req::REQUEST_NEWLY_SENT;
                  
                        $table = $req->table_names['overtime'];

                        $query = "INSERT INTO ".$table." SET user_id=:uid, reason=:reason, estimate_time=:estimate_time, overtime_date=:overtime_date, overtime_start=:overtime_start, dateCreated=:dateCreated, status=:status";
                        $stmt = $this->conn->prepare($query);

                        $uidToLog = '';
                        if($transactByAdmin == true){
                            $stat = $req::REQUEST_APPROVED;
                            $uidToLog = $stmt->bindParam(":uid", $data[0]['value']);
                            $stmt->bindParam(":reason", $data[2]['value']);
                            $stmt->bindParam(":estimate_time", $data[1]['value']);
                            $stmt->bindParam(":status", $stat);
                        }else{
                             $uidToLog = $stmt->bindParam(":uid", $data[5]['value']);
                        $stmt->bindParam(":reason", $data[1]['value']);
                        $stmt->bindParam(":estimate_time", $data[0]['value']);

                        $stmt->bindParam(":status", $status);
                        }

                        $stmt->bindParam(":overtime_date", $newDate);
                        $stmt->bindParam(":overtime_start", $startTime);
                        $stmt->bindParam(":dateCreated", $dateCeated);

                        if($stmt->execute()){
                            if($transactByAdmin == true){
                                    $userRepository = new UserRepository();

                                    $empname='';$number='';$adminname='';
                                    foreach ( $userRepository->findUserById($data[0]['value']) as $key => $emp) {
                                        $empname = $emp['firstname']." ".$emp['lastname'];  
                                        $number = $emp['mobile_no'];
                                        foreach ( $userRepository->findUserById($data[6]['value']) as $key => $admin) {
                                            $adminname = $admin['firstname']." ".$admin['lastname'];   
                                       }
                                    }
                                    $message = "Hello ".$empname. " You have bee required to overtime on this schedule ".$data[5]['value'].". ".$adminname."[admin] already filed for your overtime schedule and automatically approved. Thanks.";
                                    
                                    $sms = new SendSMS();
                                
                                    $sms->setNumber($number);
                                    $sms->setMessage($message);
                                    $sms->sendSMS();
                                }
                            $logArray = [
                                'activity' => LOG::OVERTIME_LOG,
                                'user_id' => $uidToLog,
                                'log_process' => 'admin_send'
                            ];
                            $LogRepository = new LogRepository();
                            $LogRepository->createLogs($logArray);
                        
                            return true;
                        }else return false;

                }else return false;
            }        
        }
    }
    public function getLeaveTypes(){
            $query = "SELECT * FROM " .$this->model->table_names['leave_type'];
            $stmt = $this->conn->prepare($query);

            return ($stmt->execute()) ? $stmt : false ;
    }
}