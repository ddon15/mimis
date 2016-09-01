<?php

class Notification
{   
    /*
     * Variable for getting
     * database connection
     */
    public $conn;
    /*
     * Build Dependencies
     */
    public function __construct(){
        include_once '../../conf/connection.php';

        $db             = new Database();
        $this->conn     = $db->getConnection();  
    }
    public function getNotificationCount() {
        $query = "SELECT  (
                        SELECT COUNT(*)
                        FROM   overtime
                        WHERE status=3
                        ) AS count1,
                        (
                        SELECT COUNT(*)
                        FROM   work_leave
                        WHERE status=3
                        ) AS count2
                FROM    dual";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $count = '';
        foreach ($stmt as $key => $value) {
            $count = $value['count1'] + $value['count2'];
        }

        return $count;
    }
    public function getEmployeeNotificationCount($id) {
        $query = "SELECT  (
                        SELECT COUNT(*)
                        FROM   overtime
                        WHERE user_id=:user_id AND status!=3
                        ) AS count1,
                        (
                        SELECT COUNT(*)
                        FROM   work_leave
                        WHERE user_id=:user_id AND status!=3
                        ) AS count2
                FROM    dual";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $id);
        
        $stmt->execute();

        $count = '';
        foreach ($stmt as $key => $value) {
            $count = $value['count1'] + $value['count2'];
        }

        return $count;
    }
     public function getEmployeeNotificationList($current_userID){

         $query = "SELECT user_id, responsed_by, reason, status, dateCreated, 'overtime' as table_name
                    FROM overtime 
                    WHERE user_id=$current_userID 
                    AND responsed_by NOT IN ('')
                    AND status NOT IN (3)

                    UNION ALL
                    SELECT user_id, responsed_by, reason, status, dateCreated, 'Leave' as table_name
                    FROM work_leave 
                    WHERE user_id=$current_userID
                    AND responsed_by NOT IN ('')
                    AND status NOT IN (3)
                ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    public function getNotificationList(){

        $query = "SELECT id, user_id, reason, dateCreated, 'overtime' as table_name, status FROM overtime
                  UNION
                  SELECT id, user_id, reason, dateCreated, 'Leave' as table_name, status  FROM work_leave";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}