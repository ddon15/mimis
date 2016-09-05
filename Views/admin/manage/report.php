<?php 
    require_once dirname(__FILE__).'\../../../Repository/RequestRepository.php';
    include_once dirname(__FILE__).'\../../../Repository/RequirementsRepository.php';
    include_once dirname(__FILE__).'\../../../conf/connection.php';

    $db = new Database();
    $conn = $db->getConnection();  
    $requestRepository = new RequestRepository();
    $requirementsRepository = new RequirementsRepository();
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
              <ul class="lackOfReq">

                  <li class = "title">Lack of Requirements Report</li>
                      <?php
                          $completeRequirements = 11;

                           foreach ($requirementsRepository->getUserLackReq() as $key => $value) {

                              $count1 = ($value['sss_id'] != 0) ? 1 : 0 ;
                              $count2 = ($value['pagibig_id'] != 0) ? 1 : 0 ;
                              $count3 = ($value['tin_no'] != 0) ? 1 : 0 ;
                              $count4 = ($value['medical'] != 0) ? 1 : 0 ;
                              $count5 = ($value['tor'] != 0) ? 1 : 0 ;
                              $count6 = ($value['cert_of_emp'] != 0) ? 1 : 0 ;
                              $count7 = ($value['form2316'] != 0) ? 1 : 0 ;
                             $count8 = ($value['nbi'] != 0) ? 1 : 0 ;
                             $count9 = ($value['phil_health_no'] != 0) ? 1 : 0 ;
                             $count10 = ($value['bert_cert'] != 0) ? 1 : 0 ;
                             $count11 = ($value['nso'] != 0) ? 1 : 0 ; 


                              $totalRequirements = $count1 + $count2 + $count3 + $count4 + $count5 + $count6 + $count7 + $count8 + $count9 + $count10 + $count11;


                              $data = $userRepository->findUserById($value['user_id']);
                              foreach($data as $row){
                                  $name = $row['firstname']." ".$row['lastname'];
                                  if($totalRequirements < $completeRequirements) {
                                      echo "

                                              <li> " .$name. " </li>

                                      ";       
                                  }
                              }

                           }

                      ?>
                  </ul>
              </div>
            </div>
        </div>     
</div>
