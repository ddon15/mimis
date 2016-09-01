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
<div class="requestContainerAdmin" hidden>
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
            <h1>Request Management</h1>
            <ul class="nav nav-tabs menu">
                <li class="requestListTabMenu active"><a data-toggle="tab"  href="#">List of Request</a></li>
                <li class = "fileOttoEmpTabMenu"><a data-toggle="tab" href="#">File OT to Employee</a></li>
            </ul>
        </div>
        <div class="main">
            <div class="tab-content page">
                <div id="requestListContainer" class="tab-pane fade in active">
                    <h4>View all request from employees</h4>
                    <br>

                    <table class="table table-striped requestview">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Request Type</th>
                            <th>Requested By</th>
                            <th>Requested Date</th>
                            <th>Request Status</th>
                            <th>action</th>
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
                    // var_dump($row['firstname']);
                    $name = $row['firstname']." ".$row['lastname'];

                    }

                    $status = '';
                    if($value['status'] == 3)  {
                    $status = "<h6 class='label label-success'>New</h6>";
                    }else if($value['status'] == 0) {
                    $status = "<h6 class='label label-danger'>Disappoved</h6>";
                    }else if($value['status'] == 1) {
                    $status = "<h6 class='label label-primary'>Approved</h6>";
                    }else echo '';

                    echo "
                    <tr>
                      <td>".$value['id']."</td>
                      <td>".$value['table_name']."</td>
                      <td>".$name."</td>
                      <td>".$value['dateCreated']."</td>
                      <td class = 'reqStatus ".$value['table_name'].$value['id']."'>".$status."</td>
                      <td style = 'text-align:right;' class = 'action'>
                      <img class = 'ajaxLoader ".$value['table_name'].$value['id']."' src='../../../Public/images/loader.gif'/>
                    <a class = 'approved' data-uid = '".$_GET['id']."' data-id = '".$value['id']."' data-table = '".$value['table_name']."'  href = '#'> 
                    <h6 class = 'glyphicon glyphicon-ok'></h6> approved</a> | 
                    <a class = 'disapproved' data-id = '".$value['id']."' data-table = '".$value['table_name']."' data-uid = '".$_GET['id']."' href = '#'>
                    <h6 class = 'glyphicon glyphicon-remove'></h6> disapproved</a> | 
                    <a class = 'view' data-id = '".$value['id']."' data-uid = '".$_GET['id']."' data-table = '".$value['table_name']."' href = '#'>
                    <h6 class = 'glyphicon glyphicon-eye-open'></h6> view</a>

                    <div id='myPopUpDiv' class = 'fade singleViewRequestPopUpDiv' style = 'display:none'></div>
                    <div class='popup singleViewRequest'>
                    <span class='glyphicon glyphicon-remove'></span>
                    <div class='title'>".$name." ".$value['table_name']." Request</div>
                    <div class='content'>
                    <span class='query' hidden></span>
                    <div class = 'id'>
                    <b># ".$value['id']."</b>
                    </div>
                    <div class = 'requested'>
                    <b>Requested :</b>  ".$value['table_name']."
                    </div>
                    <div class = 'dateReq'>
                    <b>Date Requested :</b> ".$value['dateCreated']."
                    </div>
                    <div class = 'reason'>
                    <b>Reason for requested ".$value['table_name']." :</b> ".$value['reason']."
                    </div>
                    <div class = 'action'>
                    <img class = 'ajaxLoader ".$value['table_name'].$value['id']."' src='../../../Public/images/loader.gif'/>
                    <a class = 'singleviewApproved' data-uid = '".$_GET['id']."' data-id = '".$value['id']."' data-table = '".$value['table_name']."'  href = '#'> 
                    <h6 class = 'glyphicon glyphicon-ok'></h6> approved</a> | 
                    <a class = 'singleviewDisapproved' data-id = '".$value['id']."' data-table = '".$value['table_name']."' data-uid = '".$_GET['id']."' href = '#'>
                    <h6 class = 'glyphicon glyphicon-remove'></h6> disapproved</a>
                    </div>
                    </div>
                    </div>
                    </td>
                    </tr>
                    ";
                    }

                    ?>
                    </tbody>
                    </table>
                </div>
                <div id="fileOttoEmpContainer" class="tab-pane fade">
                    <h4>Create Overtime Schedule</h4>
                    <br>
                    <div class = "otFormAdmin">
                     <div class="message" hidden>
                            </div>
                        <form class="form-ot-admin" method="post" id="ot-admin-form">
                           
                            <div class="form-group">
                            <div class = "err-empName error-message"></div>
                             <label for="empName">Choose Employee:</label>
                             <select class="form-control" name="empName" placeholder = 'choose employee' id = "empName">
                                <?php 

                                    foreach ($userRepository->displayAllUser() as $key => $value) {
                                        echo "
                                            <option value = ".$value['id'].">".$value['firstname']." ".$value['lastname']."</option>
                                        ";
                                    }
                                 ?>
                             </select>
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
                              <button type="submit" class="btn btn-default btn-ot" name="btn-ot-admin" id="btn-ot-admin">
                              <span class="glyphicon glyphicon-log-in"></span> &nbsp; Send Request
                              </button><img class = "ajaxLoader" src="../../../Public/images/loader.gif"/>
                            </div>  
                          </form>
                      </div>
                </div>
            </div> 
        </div>
    </div> 
</div>
