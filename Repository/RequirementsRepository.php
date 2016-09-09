<?php

class RequirementsRepository
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

        include_once '../../conf/connection.php';
        include_once 'UserRepository.php';

        $this->model = "requirements";

        $db             = new Database();
        $this->conn     = $db->getConnection();  

        $userRepository = new UserRepository();
    }
    public function setUserToRequirementsList($request) {
      $saving = false;
        if(!is_array($request)){
            $query = "INSERT INTO $this->model SET user_id=:user_id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":user_id", $request);
            $saving = ($stmt->execute()) ? true : false ;
        }
       
        return ($saving == true) ? [true, $request] : $saving;
    }
    public function updateRequirements($request){

      if(is_array($request)){
            $query = "UPDATE ".$this->model." 
                  SET sss_id=:sss_id,
                      pagibig_id=:pagibig_id,
                      tin_no=:tin_no,
                      medical=:medical,
                      tor=:tor,
                      cert_of_emp=:cert_of_emp,
                      form2316=:form2316,
                      nbi=:nbi,
                      phil_health_no=:phil_health_no,
                      bert_cert=:bert_cert,
                      nso=:nso
                  WHERE user_id=:user_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":sss_id", $request[0]);
        $stmt->bindParam(":pagibig_id", $request[1]);
        $stmt->bindParam(":tin_no", $request[2]);
        $stmt->bindParam(":medical", $request[3]);
        $stmt->bindParam(":tor", $request[4]);
        $stmt->bindParam(":cert_of_emp", $request[5]);
        $stmt->bindParam(":form2316", $request[6]);
        $stmt->bindParam(":nbi", $request[7]);
        $stmt->bindParam(":phil_health_no", $request[8]);
        $stmt->bindParam(":bert_cert", $request[9]);
        $stmt->bindParam(":nso", $request[10]);
        $stmt->bindParam(":user_id", $request[11]);
        
        return ($stmt->execute()) ? true : false ;
      }
    }
    public function displayAllUserNotOnRequirementsList(){
      $query = "
          SELECT t.*
          FROM user t
         WHERE t.id NOT IN (SELECT tl.user_id
                               FROM requirements tl
                           GROUP BY tl.id)
      ";
       $stmt = $this->conn->prepare($query);
         
        return ($stmt->execute()) ? $stmt : false ;
    }
    public function displayUsersWithRequirements(){
        $query = "SELECT *
                  FROM requirements
                  INNER JOIN user
                  ON requirements.user_id = user.id 
            ";

        $stmt = $this->conn->prepare($query);
         
        return ($stmt->execute()) ? $stmt : false ;
    }
    public function getUserLackReq(){

         $query = "SELECT user_id, sss_id, pagibig_id, tin_no, medical, tor, cert_of_emp, form2316, nbi, phil_health_no, bert_cert, nso
                    FROM requirements 
                ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;

    }
}