<?php

class UserRepository
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

    /*
     * Build Dependencies
     */
    public function __construct(){
        include_once '../../Helper/User.php';
        include_once '../../Helper/Log.php';
        include_once '../../conf/connection.php';
       
        $this->model    = new User();
        $db             = new Database();
        $this->conn     = $db->getConnection();  
    }


    public function authenticationProcess($data) {
        if(is_array($data) && sizeof($data)<=2) { 
            $query = "SELECT * FROM " . $this->model->table_name . " WHERE email=:email AND password=:password";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":email", $data[0]);
            $stmt->bindParam(":password", $data[1]);
            $stmt->execute();

            foreach($stmt as $row) {
                if(count($row) > 0) {
                    $_SESSION['username'] = $row['username'];
                    $user = new User();
                    if($row['status'] != $user::INACTIVE){
                        if($row['user_type'] == 1){
                            return [true, 'admin_user', $row['id'], $row['status']];
                        }else{
                            return [true, "anonymous_user", $row['id'], $row['status']];
                        }
                    }else return [false,'',''];                   
                }return [false,'',''];
            }
        }
        return [false,'',''];
    }
    /*=========================*
    *  Check admin user(s)     *
    *-------------------------*/
    public function authorizedAccountToRegister($data, $check = false){

       if(!is_array($data)){
            $stmt = $this->conn->prepare("SELECT * FROM " . $this->model->table_name . " WHERE password=:password");
            $stmt->bindParam(":password", $data);
            $stmt->execute();

            foreach($stmt as $row) {
                $check = (count($row) > 0) ? array($_SESSION['id'] = $row['id'], true)  :'';
            }
       }
       return $check;
    }

    /*=========================*
    *  Creating of User(s)     *
    *-------------------------*/
    public function createNewUser($data){
        if(is_array($data) && is_array($data)){
            $user = $this->model;

            $date = $user->getDateTime();
            $status = $user::REGISTERED;

            $query = "INSERT INTO ".$this->model->table_name." SET firstname=:fname, middlename=:middle, lastname=:lname, email=:email, username=:username, password=:pword, dateCreated=:dateCreated, dateModified=:dateModified, user_type=:user_type, status=:status";
            $stmt = $this->conn->prepare($query);
            
            if(!is_null($data[0]) && (int)$data[0]){
                 $stmt->bindParam(":id", $data[0]);
                 $stmt->bindParam(":fname", $data[1]);$stmt->bindParam(":middle", $data[2]);$stmt->bindParam(":lname", $data[3]);
                $stmt->bindParam(":email", $data[4]); $stmt->bindParam(":username",$data[5]);$stmt->bindParam(":pword", $data[6]);
                $stmt->bindParam(":dateCreated", $date);$stmt->bindParam(":dateModified",$date);$stmt->bindParam(":user_type",$data[9]);
                $stmt->bindParam(":status",$status);
            }else{
                 // $stmt->bindParam(":id", null);
                $stmt->bindParam(":fname", $data[0]);$stmt->bindParam(":middle", $data[1]);$stmt->bindParam(":lname", $data[2]);
                $stmt->bindParam(":email", $data[3]); $stmt->bindParam(":username",$data[4]);$stmt->bindParam(":pword", $data[5]);
                $stmt->bindParam(":dateCreated", $date);$stmt->bindParam(":dateModified",$date);$stmt->bindParam(":user_type",$data[8]);
                $stmt->bindParam(":status",$status);
            }
        // exit;

            $ret = ($stmt->execute()) ? true : false ;
            // $lastId = $this->conn->lastInsertId();

            $log = new Log();
            $query2 = "INSERT INTO log SET activity_log_id=:log_id, user_whoCreate_id=:user_whoCreate_id, dateCreated=:dateCreated, description=:description";
            $stmt2 = $this->conn->prepare($query2);

            $logDescription = $log->getUser();
            $logId = $log::USER_LOG;
            $stmt2->bindParam(":log_id", $logId);
            $stmt2->bindParam(":user_whoCreate_id",$data[7]);
            $stmt2->bindParam(":dateCreated",$date);
            $stmt2->bindParam(":description", $logDescription['create']);

            ($stmt2->execute()) ? true : false ;

            return $ret;
        }
        
        return false;
    }

    /*=========================*
    *  Removing of User(s)     *
    *-------------------------*/
    //Remove user through Id
    public function removeUserById($id){
        if(isset($id) && !is_array($id))  {
            $query = "DELETE FROM ".$this->model->table_name." WHERE id=:id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);

            return ($stmt->execute()) ? true : false ;
        }  
        return false;
    }
    // Custom search removing user
    public function customRemoveUser($custom){

        $query = "DELETE FROM ".$this->model->table_name." WHERE ?=:custom";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(":custom", $custom);

        return ($stmt->execute()) ? true : false ;
    }

   /*=========================*
    *  Retrieving User(s)     *
    *-------------------------*/
    //Retrieve all users
    public function displayAllUser(){
        
        $query = "SELECT * FROM " .$this->model->table_name;
        $stmt = $this->conn->prepare($query);
         
        return ($stmt->execute()) ? $stmt : false ;
    }
    //Search user(s) through id
    public function findUserById($id){
        $query = "SELECT * FROM " . $this->model->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
         
        return ($stmt->execute()) ? $stmt : false ;
    }
    //Search user(s) through email
    public function findUserByEmail($emailData){
        $query = "SELECT * FROM " . $this->model->table_name . " WHERE email=:email";
        $stmt = $user->conn->prepare($query);
        $stmt->bindParam(":email", $emailData);
         
        return ($stmt->execute()) ? $stmt : false ;
    }
    //custom search of User(s)
    public function customSearchUser($custom){
        $query = "SELECT * FROM " . $this->model->table_name . " WHERE ?=:custom";
        $stmt = $user->conn->prepare($query);
        $stmt->bindParam(":custom", $custom);
         
        return ($stmt->execute()) ? $stmt : false ;
    }

    /*========================*
    *  Counting total user    *
    *-------------------------*/
    public function countAllUsers(){
        $query = "SELECT COUNT(*) as totalUsers FROM " .$this->model->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
         
        return $stmt;
    }
    public function countAllVerifiedUsers(){
        $query = "SELECT COUNT(*) as totalVerifiedUsers FROM " .$this->model->table_name. " WHERE status=1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
         
        return $stmt;
        // return $totalUsers;
    }
     public function countAllAdminUsers(){
        $query = "SELECT COUNT(*) as adminUsers FROM " .$this->model->table_name. " WHERE user_type=1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
         
        return $stmt;
        // return $totalUsers;
    }
    public function countAllEmployeeUsers(){
        $query = "SELECT COUNT(*) as employeeUsers FROM " .$this->model->table_name. " WHERE user_type=3";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
         
        return $stmt;
        // return $totalUsers;
    }

}