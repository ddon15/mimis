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
                <ul class = "lackOfReq">
                    <li class = "title">Day-to-day generated report</li>
                </ul>

              <span class = "label label-primary printPage"><span class= "glyphicon glyphicon-print"></span> Print All Lacked of Requirements</span>
              <div class = "empLackOfRequirements">
                  <h5>Employee's lacked of requirements </h5>
                  <table class="lackOfReq">
                      <thead>
                          <tr>
                              <th>Name</th>
                              <th>Requirements lacked</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                              $completeRequirements = 11;

                               foreach ($requirementsRepository->getUserLackReq() as $key => $value) {

                                  $count1 = ($value['sss_id'] != 0) ? 1 : 'SSS ID' ;
                                  $count2 = ($value['pagibig_id'] != 0) ? 1 : 'Pagibig ID' ;
                                  $count3 = ($value['tin_no'] != 0) ? 1 : 'TIN No.';
                                  $count4 = ($value['medical'] != 0) ? 1 : 'Medical Certificate' ;
                                  $count5 = ($value['tor'] != 0) ? 1 : 'Transcript of Record' ;
                                  $count6 = ($value['cert_of_emp'] != 0) ? 1 : 'Certificate of Employment' ;
                                  $count7 = ($value['form2316'] != 0) ? 1 : 'Form 2316' ;
                                  $count8 = ($value['nbi'] != 0) ? 1 : 'NBI Clearance' ;
                                  $count9 = ($value['phil_health_no'] != 0) ? 1 : 'PhilHealt No.' ;
                                  $count10 = ($value['bert_cert'] != 0) ? 1 : 'Birth Certificate' ;
                                  $count11 = ($value['nso'] != 0) ? 1 : 'NSO' ; 


                                  $totalRequirements = $count1 + $count2 + $count3 + $count4 + $count5 + $count6 + $count7 + $count8 + $count9 + $count10 + $count11;

                                  $data = $userRepository->findUserById($value['user_id']);
                                  foreach($data as $row){
                                      $name = $row['firstname']." ".$row['lastname'];
                                      if($totalRequirements < $completeRequirements) {
                                          echo "
                                              <tr>
                                                  <td> " .$name. " </td>
                                                  <td> "
                                                      ."<span class = 'label label-danger'>".$count1."</span> "
                                                      ."<span class = 'label label-danger'>".$count2."</span> "
                                                      ."<span class = 'label label-danger'>".$count3."</span> "
                                                      ."<span class = 'label label-danger'>".$count4."</span> "
                                                      ."<span class = 'label label-danger'>".$count5."</span> "
                                                      ."<span class = 'label label-danger'>".$count6."</span> "
                                                      ."<span class = 'label label-danger'>".$count7."</span> "
                                                      ."<span class = 'label label-danger'>".$count8."</span> "
                                                      ."<span class = 'label label-danger'>".$count9."</span> "
                                                      ."<span class = 'label label-danger'>".$count10."</span> "
                                                      ."<span class = 'label label-danger'>".$count11."</span> ".
                                                  "</td>
                                              </tr>
                                          ";       
                                      }
                                  }

                               }

                          ?>
                          </tbody>
                      </table>
                  </div>
              </div>
            </div>
        </div>     
</div>
