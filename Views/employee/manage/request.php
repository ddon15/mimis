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
<link rel="stylesheet" href="../../../Public/lib/wickedpicker.css">
<link rel="stylesheet" href="../../../Public/lib/datepicker.css">
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
                <li class = "excuseToAbsentTabMenu"><a data-toggle="tab" href="#">Request Response</a></li>
            </ul>
        </div>
            <div class="main">
                <div class="tab-content page">
                  <div id="overTimeContainer" class="tab-pane fade in active">
                    <h4>Create Overtime Schedule</h4>
                    <br>
                    <div class = "otForm">
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
                            <!-- <input type="text" class="form-control timepicker" name="endTime" placeholder="0" id="endTime" />   -->
                            <span> -- </span>
                            <input type="text" class="form-control datepicker" data-toggle="datepicker" name="otdate" placeholder="mm/dd/YY" id="otdate" />
                          </div>
                       
                          <div class="form-group submit">
                              <input type="text" name="user_id" value = "<?php echo $_GET['id']; ?>" hidden/>
                            <button type="submit" class="btn btn-default btn-ot" name="btn-ot" id="btn-ot">
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Send Request
                            </button>
                          </div>  
                        </form>
                    </div>
                  </div>
                  <div id="leaveContainer" class="tab-pane fade">
                    <h4>Create Leave Schedule</h4>
                    <br>
                    <div class = "otForm">
                      <form class="form-ot" method="post" id="ot-form">
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
                              <textarea class="form-control" rows="5" id="comment"></textarea>
                          </div>
                           <label for="starttime">Leave Start Date: &nbsp;&nbsp;&nbsp;Leave End Date</label>
                           <div class="form-group dates">
                               <input type="text" class="form-control datepicker" data-toggle="datepicker" name="leavestartdate" placeholder="mm/dd/YY" id="leavestartdate" />
                            <input type="text" class="form-control datepicker" data-toggle="datepicker" name="leaveenddate" placeholder="mm/dd/YY" id="leaveenddate" />
                          </div>
                       
                          <div class="form-group submit">
                            <button type="submit" class="btn btn-default" name="btn-leave" id="btn-leave">
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Send Request
                            </button>
                          </div>  
                        </form>
                    </div>
                  </div> 
                  </div>
                  <div id="excuseToAbsentContainer" class="tab-pane fade">
                    <h3>List of response</h3>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                  </div>
                </div>
            </div>     
    </div>
</div>      
<script src="../../../Public/lib/wickedpicker.js"></script>    
<script src="../../../Public/lib/datepicker.js"></script>    
<script type="text/javascript">
     function date_time(id)
                            {
                                date = new Date;
                                year = date.getFullYear();
                                month = date.getMonth();
                                months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
                                d = date.getDate();
                                day = date.getDay();
                                days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
                                h = date.getHours();
                                if(h<10)
                                {
                                        h = "0"+h;
                                }
                                m = date.getMinutes();
                                if(m<10)
                                {
                                        m = "0"+m;
                                }
                                s = date.getSeconds();
                                if(s<10)
                                {
                                        s = "0"+s;
                                }
                                result = ''+days[day]+' '+months[month]+' '+d+' '+year+' <span class = "time">'+h+':'+m+':'+s+'</span>';
                                document.getElementById(id).innerHTML = result;
                                setTimeout('date_time("'+id+'");','1000');
                                return true;
                            }
                            window.onload = date_time('date_time');

        $('#startTime').wickedpicker({now: '4:00', twentyFour: false, title:
            'Set Time', showSeconds: true});
        $('#endTime').wickedpicker({now: '8:16', twentyFour: false, title:
            'Set Time', showSeconds: true});

        $('[data-toggle="datepicker"]').datepicker();
</script>         