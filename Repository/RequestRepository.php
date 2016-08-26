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

        $this->model    = new Request();
        $db             = new Database();
        $this->conn     = $db->getConnection();  
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

                    $query = "INSERT INTO ".$table." SET user_id=:uid, reason=:reason, start_leave=:start_leave, end_leave=:end_leave, leave_type_id=:leave_type_id, status=:status";
                    $stmt = $this->conn->prepare($query);

                    $stmt->bindParam(":uid", $data[1]['value']);
                    $stmt->bindParam(":reason", $data[2]['value']);
                    $stmt->bindParam(":start_leave", $startDate);
                    $stmt->bindParam(":end_leave", $endDate);
                    $stmt->bindParam(":leave_type_id", $data[0]['value']);
                    $stmt->bindParam(":status", $status);

                    $ret = ($stmt->execute()) ? true : false ;

                    $logArray = [
                            'activity' => LOG::LEAVE_LOG,
                            'user_id' => $data[1]['value'],
                            'log_process' => 'send'
                        ];
                    $LogRepository = new LogRepository();
                    $LogRepository->createLogs($logArray);

                    return $ret;

                }else return false;
            }        
        }
    }
    public function sendOvertimeRequest($data){
            
        foreach ($data as $key => $getNameToProcess) {
            if ($getNameToProcess['name'] == "toProcess") {
               if ($getNameToProcess['value'] == "overtime") {

                        $req = $this->model;

                        $newDate    = $req->dateDataTransformer($data[4]['value']);
                        $startTime  = $req->timeDataTransformer($data[2]['value']);
                        $status     = $req::OT_NEWLY_SENT;
                  
                        $table = $req->table_names['overtime'];

                        $query = "INSERT INTO ".$table." SET user_id=:uid, reason_or_project=:reason_or_project, estimate_time=:estimate_time, date=:date, Overtime_start=:Overtime_start, status=:status";
                        $stmt = $this->conn->prepare($query);

                        $stmt->bindParam(":uid", $data[5]['value']);
                        $stmt->bindParam(":reason_or_project", $data[1]['value']);
                        $stmt->bindParam(":estimate_time", $data[0]['value']);
                        $stmt->bindParam(":date", $newDate);
                        $stmt->bindParam(":Overtime_start", $startTime);
                        $stmt->bindParam(":status", $status);

                        $ret = ($stmt->execute()) ? true : false ;

                        $logArray = [
                                'activity' => LOG::OVERTIME_LOG,
                                'user_id' => $data[5]['value'],
                                'log_process' => 'send'
                            ];
                        $LogRepository = new LogRepository();
                        $LogRepository->createLogs($logArray);
                        
                   return $ret;

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