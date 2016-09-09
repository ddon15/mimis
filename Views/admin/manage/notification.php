<?php 
    require_once dirname(__FILE__).'\../../../Repository/RequestRepository.php';
    require_once dirname(__FILE__).'\../../../Repository/MediaRepository.php';
    include_once dirname(__FILE__).'\../../../conf/connection.php';
    include_once dirname(__FILE__).'\../../../Helper/Notification.php';

    $db = new Database();
    $conn = $db->getConnection();  
    $requestRepository = new RequestRepository();
    $MediaRepository = new MediaRepository();
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
                <li class="notificationListTabMenu active"><a data-toggle="tab"  href="#">List of notifications</a></li>
                <li class = "createMessageNotificationTabMenu"><a data-toggle="tab" href="#">Create Message</a></li>
            </ul>
        </div>
            <div class="main">
                <div class="tab-content page">
                  <div id="notificationListContainer" class="tab-pane fade in active">
                    <h4>View all notifications from employees</h4>
                    <br>
                      <?php
                          $notification = new Notification();
                          $list = $notification->getNotificationList();
                       
                          foreach ($list as $key => $value) {
                              //query of names
                              $name = '';
                              $queryName = $userRepository->findUserById($value['user_id']);
                              foreach($queryName as $row){
                                 $name = $row['firstname']." ".$row['lastname'];
                              }
                              //Profile Pic image query
                              $image = "<img class='profilePicPreview' style = 'width:75px;height:75px;border-radius: 50px;' src='../../Public/images/no-image.jpg'>";
                              $mid = $mediaRepository->findMediaById($value['user_id']);
                              foreach ($mid as $key => $data) {
                                  if(count($data['user_id'])>0){
                                      $image = "<img class='profilePicPreview' style = 'width:75px;height:75px;border-radius: 50px;' src='../../Uploads/".$data['name']."'> ";
                                  }else{$image = $image;}
                              }

                          $status = '';
                          if($value['status'] == 3)  {
                              $status = "<h6 class='label label-default'>New</h6>";
                          }else if($value['status'] == 0) {
                              $status = "<h6 class='label label-success'>Disappoved</h6>";
                          }else if($value['status'] == 1) {
                              $status = "<h6 class='label label-danger'>Approved</h6>";
                          }else echo '';
                           echo '
                            <div class="media notification">
                                <div class="media-left">
                                        <a href="#"> '.$image.'</a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">'.$name.'</h4>
                                       <p class = "desc"> Wants to file '.$value['table_name'].' for the reason of "'.$value['reason'].'" . <span class = "label label-danger btn-remove" data-id ='.$value['id'].' data-table ='.$value['table_name'].'><span class = "glyphicon glyphicon-remove"></span></span></p>
                                    <p class = "timelogs">'.$value['dateCreated'].'</p>
                                </div>
                            </div>
                           ';
                        }
    
                      ?>
                  </div>
                  <div id="createMessageNotificationContainer" class="tab-pane fade">
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
