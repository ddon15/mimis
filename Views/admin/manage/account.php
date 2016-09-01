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
<div class="myAccountContainerAdmin" hidden>
    <div class="headeradmin">
        <div>
              <?php
                    $id = $userRepository->findUserById($_GET['id']);
                    foreach($id as $row){
                        echo "<h4>Welcome ". $row['firstname']." ".$row['lastname']."!</h4>";
                    }
               ?> 
             <div class="bread-crumb">
               Dashboard > Account<span class="breadCrumd"></span>
             </div>
        </div>
    </div>
    <div class="requestStatistics">
        <div class="top">
            <h1>Account</h1>
           <!--  <ul class="nav nav-tabs menu">
                <li class="usersWithReqTabMenu active"><a data-toggle="tab"  href="#">User's list</a></li>
                <li class = "createMessageTabMenu"><a data-toggle="tab" href="#">Create Message</a></li>
            </ul> -->
        </div>
        <div class="main">
            <div class="tab-content page">
                <form method = 'get' id = 'accountedit-form'>
                    <?php
                        $user = $userRepository->findUserById($_GET['id']);
                        foreach($user as $row){
                          $type = ($row['user_type'] == 1) ? "Admin" : "Employee";
                            echo "
                            <div class = 'pic'>
                                <img class='profilePic' src='../../Public/images/no-image.jpg'><br><br>
                            </div>
                            <div class ='details'>
                                <span class = 'message'></span>
                                <input type = 'text' name='id' value = '".$row['id']."' hidden>
                                <span class = 'label'>Name :</span> <input type = 'text' name='firstName' value = '".$row['firstname']."'>
                                <span class = 'glyphicon glyphicon-pencil'></span>

                                <input type = 'text' name='lastName' value = '".$row['lastname']."'>
                                <span class = 'glyphicon glyphicon-pencil name'></span>
                                <br>
                                <span class = 'label'>Email Address :</span><input type = 'text' name='email' value = '".$row['email']."'>
                                <span class = 'glyphicon glyphicon-pencil email'></span>
                                <br>
                                <span class = 'label'>Username :</span><input type = 'text' name='username' value = '".$row['username']."'>
                                <span class = 'glyphicon glyphicon-pencil username'></span> 
                                <br>
                                <span class = 'label'>Mobile No. :</span><input type = 'text' name='mobileNo' value = '".$row['mobile_no']."'>
                                <div class ='changePass'>
                                    <span class = 'glyphicon glyphicon-pencil moblieno'></span>
                                    <span class = 'glyphicon glyphicon-cog'></span><a class = 'changepass-show-link' href = '#'>Change Password</a>
                                    <div class = 'changepass-show'>
                                       <input type = 'password' placeholder = 'Old Password' name = 'old'><br>
                                       <input type = 'password' name = 'new' placeholder = 'New Password'><br>
                                       <input type = 'password' name = 'confirm' placeholder = 'Confirm Password'><br>
                                    </div>
                                </div>
                               
                                <div class = 'btn'><img class = 'loader' src = '../../../Public/images/loader.gif'><input class ='btn btn-primary accountedit' type = 'submit' value ='Save'></div> 

                              <br>
                              <div class = 'accounttype'> <p>Your account type is ".$type."</p></div>
                            </div>
                            ";
                        }
                   ?> 
                </form>
            </div>
        </div>
    </div>     
</div>
