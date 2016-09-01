<?php 
    require_once dirname(__FILE__).'\../../../Repository/RequestRepository.php';
    include_once dirname(__FILE__).'\../../../conf/connection.php';
    include_once dirname(__FILE__).'\../../../Helper/Notification.php';

    $db = new Database();
    $conn = $db->getConnection();  
    $requestRepository = new RequestRepository();
    // $logRepository = new LogRepository();
    $userRepository = new UserRepository();

?>
<div class="notificationContainer" hidden>
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
            <h1>Notifications</h1>
            <ul class="nav nav-tabs menu">
                <li class="notificationTabMenu active"><a data-toggle="tab"  href="#">List of notifications</a></li>
                <li class = "createMessageTabMenu"><a data-toggle="tab" href="#">Create Message</a></li>
            </ul>
        </div>
            <div class="main">
                <div class="tab-content page">
                  <div id="empListOfNotificationsContainer" class="tab-pane fade in active">
                    <h4>View all notifications from employees</h4>
                    <br>
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
                  <div id="empCreateMessageNotificationsContainer" class="tab-pane fade">
                    <h4>Create Message</h4>
                    <br>

                    <!-- <div class = "leaveForm">
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
                    </div> -->
                  </div> 
                  </div>
                </div>
            </div>     
    </div>
