<?php 
    require_once dirname(__FILE__).'\../../../Repository/RequestRepository.php';
    // include_once dirname(__FILE__).'\../../../Repository/LogRepository.php';
    include_once dirname(__FILE__).'\../../../conf/connection.php';

    $db = new Database();
    $conn = $db->getConnection();  
    $requestRepository = new RequestRepository();
    // $logRepository = new LogRepository();
    $userRepository = new UserRepository();

?>
<div class="reportsContainerAdmin" hidden>
    <div class="headeradmin">
        <div>
              <?php
                    $id = $userRepository->findUserById($_GET['id']);
                    foreach($id as $row){
                        echo "<h4>Welcome ". $row['firstname']." ".$row['lastname']."!</h4>";
                    }
               ?> 
             <div class="bread-crumb">
               Dashboard > Reports<span class="breadCrumd"></span>
             </div>
        </div>
    </div>
    <div class="requestStatistics">
        <div class="top">
            <h1>Reports</h1>
           <!--  <ul class="nav nav-tabs menu">
                <li class="usersWithReqTabMenu active"><a data-toggle="tab"  href="#">User's list</a></li>
                <li class = "createMessageTabMenu"><a data-toggle="tab" href="#">Create Message</a></li>
            </ul> -->
        </div>
        <div class="main">
            <div class="tab-content page">
                <!--   <div id="usersWithRequirementsContainer" class="tab-pane fade in active">
                    <h4>List of all users with their requirements</h4>
                   requirements
                  </div>
                  <div id="createMessageContainer" class="tab-pane fade">
                    <h4>Create Message</h4>
                    <br>
                    
                  </div>  -->
              </div>
            </div>
        </div>     
</div>
