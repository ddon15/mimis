<?php 
    require_once dirname(__FILE__).'\../../../Repository/RequestRepository.php';
    include_once dirname(__FILE__).'\../../../Helper/Notification.php';
    include_once dirname(__FILE__).'\../../../conf/connection.php';

    $db = new Database();
    $conn = $db->getConnection();  
    $requestRepository = new RequestRepository();
    // $logRepository = new LogRepository();
    $userRepository = new UserRepository();

?>

<div class="requestContainer" hidden>
    <div class="headeremployee">
        <div>
              <?php
                    $id = $userRepository->findUserById($_GET['id']);
                    foreach($id as $row){
                        echo "<h4>Welcome ". $row['firstname']." ".$row['lastname']."!</h4>";
                    }
               ?> 
             <div class="bread-crumb">
               Dashboard > Request > <span class="breadCrumd">Over Time</span>
             </div>
        </div>
    </div>
    <div class="requestStatistics">
        <div class="top">
            <h1>Request</h1>
            <ul class="nav nav-tabs menu">
                <li class="overTimeTabMenu active"><a data-toggle="tab"  href="#">Over Time</a></li>
                <li class = "leaveTabMenu"><a data-toggle="tab" href="#">Leave</a></li>
                <li class = "requestResponseTabMenu"><a data-toggle="tab" href="#">Request Response</a></li>
            </ul>
        </div>
            <div class="main">
                <div class="tab-content page">
                    <div id="overTimeContainer" class="tab-pane fade in active">
                    <h4>Create Overtime Schedule</h4>
                    <br>
                    <div class = "otForm">
                      <div class="message"></div>
                      <form class="form-ot" method="post" id="ot-form">
                          <div class="auth error-message showError" hidden>
                          </div>
                          <div class="form-group">
                            <div class = "err-email error-message"></div>
                             <label for="estimatedTime">Estimated Time Hours:</label>
                            <input type="text" class="form-control" name="estimatedTime" placeholder="0" id="estimatedTime" /><b><span id="date_time"></span></b>
                          </div>
                          <div class="form-group">
                              <label for="comment">Reason:</label>
                              <textarea class="form-control"  name = "reason" rows="5" id="reason"></textarea>
                          </div>
                           <label for="starttime">Start Time: &nbsp;&nbsp;&nbsp;End Time: &nbsp;&nbsp;&nbsp;OT Date:</label>
                           <div class="form-group">
                            <input type="text" class="form-control timepicker" name="startTime" placeholder="0" id="startTime" />  
                            <input type="text" class="form-control" name="toProcess" value = "overtime" style = "display:none;" id="toProcess" />  
                            <span> -- </span>
                            <input type="text" class="form-control datepicker" data-toggle="datepicker" name="otdate" placeholder="mm/dd/YY" id="otdate" />
                          </div>
                       
                          <div class="form-group submit">
                              <input type="text" name="user_id" value = "<?php echo $_GET['id']; ?>" hidden/>
                            <button type="submit" class="btn btn-default btn-ot" name="btn-ot" id="btn-ot">
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Send Request
                            </button><img class = "ajaxLoader" src="../../../Public/images/loader.gif"/>
                          </div>  
                        </form>
                    </div>
                  </div>
                  <div id="leaveContainer" class="tab-pane fade">
                    <h4>Create Leave Schedule</h4>
                    <br>
                    <div class = "leaveForm">
                      <div class="message"></div>
                      <form class="form-leave" method="post" id="leave-form">
                          <div class="auth error-message showError" hidden>
                          </div>
                          <div class="form-group">
                            <div class = "err-email error-message"></div>
                             <label for="estimatedTime">Choose Leave:</label>
                             <select class="form-control" name="leaveTypes" placeholder = 'choose leave types' id = "leave">
                                <?php 
                                    $leaves = $requestRepository->getLeaveTypes();

                                    foreach ($leaves as $key => $value) {
                                        echo "
                                            <option value = ".$value['id'].">".$value['type']."</option>
                                        ";
                                    }
                                 ?>
                             </select>
                          </div>
                          <div class="form-group">
                              <label for="comment">Reason:</label>
                               <input type="text" class="form-control" name="user_id" value="<?php echo $_GET['id'];?>" style = "display:none"/>
                              <textarea class="form-control" rows="5" id="comment" name = "reasonForLeave"></textarea>
                          </div>
                           <label for="starttime">Leave Start Date: &nbsp;&nbsp;&nbsp;Leave End Date</label>
                           <div class="form-group dates">
                               <input type="text" class="form-control datepicker" data-toggle="datepicker" name="leavestartdate" placeholder="mm/dd/YY" id="leavestartdate" />
                            <input type="text" class="form-control datepicker" data-toggle="datepicker" name="leaveenddate" placeholder="mm/dd/YY" id="leaveenddate" />
                            <input type="text" class="form-control" name="toProcess" value = "leave" id="toProcess" style = "display:none"/>  
                          </div>
                       
                          <div class="form-group submit">
                            <button type="submit" class="btn btn-default" name="btn-leave" id="btn-leave">
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Send Request
                            </button><img class = "ajaxLoader" src="../../../Public/images/loader.gif"/>
                          </div>  
                        </form>
                    </div>
                  </div> 
                  <div id="responseContainer" class="tab-pane fade">
                     <br>
                     <h4>View all response</h4>
                        <div class="responseRequest">
                        <?php
                            $notification = new Notification();
                            $data = $notification->getEmployeeNotificationList($_GET['id']);
                            foreach ($data as $key => $value) {
                            
                            $name = '';
                            $res = '';

                            if($value['status'] == 1){
                              $res = "<span class = 'label label-primary'>Approved</span>";
                            }else{
                              $res = "<span class = 'label label-danger'>Dispproved</span>";
                            }
                                foreach($userRepository->findUserById($value['responsed_by']) as $row){
                                   $name = $row['firstname']." ".$row['lastname'];
                                }

                                echo '
                                     <div class="media">
                                        <div class="media-left">
                                          <a href="#">
                                            <img class="media-object" src="../../Public/images/no-image.jpg" style = "width:64px;height:64px;" alt="...">
                                          </a>
                                        </div>
                                        <div class="media-body">
                                          <h4 class="media-heading">'.$res." ".$value['table_name'].'</h4>
                                              You have filed this request on '.$value['dateCreated'].' for the reason of "'.$value['reason'].'", So '.$name.' responded it '.$res.'.

                                        </div>
                                      </div>
                                ';
                            }

                        ?>
                         
                        </div>  
                  </div>
                </div>
            </div>     
    </div>  
</div>