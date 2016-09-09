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
<div class="requirementsContainerAdmin" hidden>
    <div class="headeradmin">
        <div>
              <?php
                    $id = $userRepository->findUserById($_GET['id']);
                    foreach($id as $row){
                        echo "<h4>Welcome ". $row['firstname']." ".$row['lastname']."!</h4>";
                    }
               ?> 
             <div class="bread-crumb">
               Dashboard > Request > <span class="breadCrumd">Request List</span>
             </div>
        </div>
    </div>
    <div class="requestStatistics">
        <div class="top">
            <h1>requirements Management</h1>
            <ul class="nav nav-tabs menu">
                <li class="usersWithReqTabMenu active"><a data-toggle="tab"  href="#">User's list</a></li>
                <li class = "createMessageRequirementsTabMenu"><a data-toggle="tab" href="#">Create Message</a></li>
            </ul>
        </div>
            <div class="main">
                <div class="tab-content page">
                  <div id="usersWithRequirementsContainer" class="tab-pane fade in active">
                    <h4>List of all users with their requirements</h4>
                  <style type="text/css">
                    a.btn-setReqNewUser.btn.btn-info {
    padding: 5 20px;
    padding-top: 7px;
}
select.setReqNewUser.form-control {
    width: 200px;
    display: inline-block;
}
table.table.requirementsList img.loader {
    width: 20px;
    display: none;
}
                  </style>
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Requirements List's</div>
                            <div class="panel-body">
                              <p>
                                  Set requirements fron new user : 
                                  <select class = "setReqNewUser form-control">
                                      <?php
                                          foreach ($requirementsRepository->displayAllUserNotOnRequirementsList() as $key => $value) {
                                               echo "
                                                  <option value = ".$value['id'].">".$value['firstname']." ".$value['lastname']."</option>
                                                ";
                                          }
                                      ?>
                                  </select>
                                  <a href="#" class = "btn-setReqNewUser btn btn-info"><span></span>SET</a>
                              </p>
                            </div>

                            <!-- Table -->
                            <form method= "get" id = "requirements">
                                <table class="table requirementsList">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>SSS</th>
                                            <th>PAG-IBIG</th>
                                            <th>TIN</th>
                                            <th>Medical Certificate</th>
                                            <th>TOR</th>
                                            <th>Certificate of employment</th>
                                            <th>Form 2316</th>
                                            <th>NBI</th>
                                            <th>Phil-Health</th>
                                            <th>Birth Certificate</th>
                                            <th>NSO</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class = "list">
                                    <tr class="reatimeAdd alert alert-success" style="display:none;">
                                       <td colspan="14">New User added to the requirements list. Newly added will be show when page is reloading.</td>
                                    </tr>
                                    <?php

          foreach ($requirementsRepository->displayUsersWithRequirements() as $key => $value) {
        
            $sss = ""; $sssChecked = "";
          if($value['sss_id']==1){ $sss = '<span class = "glyphicon glyphicon-ok"></span>';$sssChecked = "checked"; }
            
            $pagibig = "";$pagibigChecked = '';
          if($value['pagibig_id']==1){ $pagibig = '<span class = "glyphicon glyphicon-ok"></span>'; $pagibigChecked = 'checked';}

            $tin = ""; $tinChecked = '';
          if($value['tin_no']==1){ $tin ='<span class = "glyphicon glyphicon-ok"></span>';$tinChecked = 'checked';}

            $med = "";  $medChecked = "";
          if($value['medical']==1){ $med = '<span class = "glyphicon glyphicon-ok"></span>';$medChecked = "checked";}

            $tor = "";$torChecked = "";
          if($value['tor']==1){ $tor ='<span class = "glyphicon glyphicon-ok"></span>';$torChecked = "checked";}
            
            $coe = "";$coeChecked = "";
          if($value['cert_of_emp']==1){ $coe ='<span class = "glyphicon glyphicon-ok"></span>';$coeChecked = "checked";}
            
            $form2316 = "";$form2316Checked = "";
          if($value['form2316']==1){ $form2316 ='<span class = "glyphicon glyphicon-ok"></span>';$form2316Checked = "checked";}
            
            $nbi = "";$nbiChecked = "";
          if($value['nbi']==1){ $nbi ='<span class = "glyphicon glyphicon-ok"></span>';$nbiChecked = "checked";}
            
            $phealth = "";$phealthChecked = "";
          if($value['phil_health_no']==1){ $phealth ='<span class = "glyphicon glyphicon-ok"></span>';$phealthChecked = "checked";}
            
            $bcert = "";$bcertChecked = "";
          if($value['bert_cert']==1){ $bcert ='<span class = "glyphicon glyphicon-ok"></span>';$bcertChecked = "checked";}
            
            $nso = "";$nsoChecked = "";
            if($value['nso']==1){ $nso ='<span class = "glyphicon glyphicon-ok"></span>';$nsoChecked = "checked";}
            
              echo "

                  <tr class = 'dataRequirementsList ".$value['id']."'>
                        <td>".$value['id']."</td>
                        <td>".$value['firstname']." ".$value['lastname']."</td>
                        <td>".$sss." <input type = 'checkbox' name = 'sss' ". $sssChecked ."></td>
                        <td>".$pagibig." <input type = 'checkbox' name = 'pagibig' ". $pagibigChecked ."></td>
                        <td>".$tin."<input type = 'checkbox' name = 'tin'  ". $tinChecked ."></td>
                        <td>".$med."<input type = 'checkbox' name = 'med'  ". $medChecked ."></td>
                        <td>".$tor."<input type = 'checkbox' name = 'tor'  ". $torChecked ."></td>
                        <td>".$coe."<input type = 'checkbox' name = 'coe'  ". $coeChecked ."></td>
                        <td>".$form2316."<input type = 'checkbox' name = 'form2316' ". $form2316Checked ."></td>
                        <td>".$nbi."<input type = 'checkbox' name = 'nbi'  ". $nbiChecked ."></td>
                        <td>".$phealth."<input type = 'checkbox' name = 'phealth' ". $phealthChecked ."></td>
                        <td>".$bcert."<input type = 'checkbox' name = 'bcert'  ". $bcertChecked ."></td>
                        <td>".$nso."<input type = 'checkbox' name = 'nso' ". $nsoChecked ."></td>
                         <td style = 'display:none;'><input type = 'text' name = 'user_id' value = ".$value['id']." ></td>
                        <td>
                            <div class ='editRequirements".$value['id']."  edit label label-primary'>
                                    <span class = 'glyphicon glyphicon-edit'></span> Edit
                            </div>
                            <img class = 'loader' src = '../../../Public/images/loader.gif'>
                            <div class ='saveRequirements".$value['id']." save label label-success' style='display:none;'>

                                <span class = 'glyphicon glyphicon-saved'></span> Save
                            </div>
                        </td>
                  </tr>
              ";
          }

                                    ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                  </div>
                  <div id="createMessageRequirementsContainer" class="tab-pane fade">
                    <h4>Create Message</h4>
                    <br>
                    <div class = "leaveForm">
                      <form class="form-message" method="post" id="message-form">
                          <div class="auth error-message showError" hidden>
                          </div>
                          <div class="form-group">
                            <div class = "err-email error-message"></div>
                             <label for="estimatedTime">To</label>
                          </div>
                          <div class="form-group">
                              <label for="comment">Message:</label>
                               <input type="text" class="form-control" name="user_id" value="<?php echo $_GET['id'];?>" style = "display:none"/>
                              <textarea class="form-control" rows="5" id="comment" name = "message"></textarea>
                          </div>
                          
                       
                          <div class="form-group submit">
                            <button type="submit" class="btn btn-default" name="btn-leave" id="btn-message">
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Send Message
                            </button>
                          </div>  
                        </form>
                    
                  </div> 
                  </div>
                </div>
            </div>     
    </div>
  </div>
