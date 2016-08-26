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
<div class="notificationContainerAdmin" hidden>
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
            <h1>Notifications Management</h1>
            <ul class="nav nav-tabs menu">
                <li class="overTimeTabMenu active"><a data-toggle="tab"  href="#">List of Request</a></li>
                <li class = "leaveTabMenu"><a data-toggle="tab" href="#">Create Message</a></li>
            </ul>
        </div>
            <div class="main">
                <div class="tab-content page">
                  <div id="overTimeContainer" class="tab-pane fade in active">
                    <h4>View all request from employees</h4>
                    <br>
                  <table class="table table-striped">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Request Type</th>
                              <th>Requested By</th>
                              <th>Requested Date</th>
                              <th>Request Status</th>
                              <th style = 'text-align:right'>action</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php 
                           $notification = new Notification();
                           $list = $notification->getNotificationList();
                           
                           foreach ($list as $key => $value) {

                              $name = '';
                              $queryName = $userRepository->findUserById($value['user_id']);
                              foreach($queryName as $row){
                                 $name = $row['firstname']." ".$row['lastname'];
                              }
                              $status = '';
                              if($value['status'] == 3)  {
                                  $status = "<h6 class='label label-default'>New</h6>";
                              }else if($value['status'] == 0) {
                                  $status = "<h6 class='label label-success'>Disappoved</h6>";
                              }else if($value['status'] == 1) {
                                  $status = "<h6 class='label label-danger'>Approved</h6>";
                              }else echo '';

                              echo "
                                  <tr>
                                      <td>".$value['id']."</td>
                                      <td>".$value['table_name']."</td>
                                      <td>".$name."</td>
                                      <td>".$value['dateCreated']."</td>
                                      <td>".$status."</td>
                                      <td style = 'text-align:right'><a href = '#'>approved</a> | <a href = '#'>disapproved</a> | <a href = '#'>View</a></td>
                                  </tr>
                              ";
                           }

                      ?>
                      </tbody>
                  </table>
                  </div>
                  <div id="leaveContainer" class="tab-pane fade">
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
