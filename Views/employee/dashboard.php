<?php 
    include_once '../../Repository/UserRepository.php';
    include_once '../../Repository/LogRepository.php';
    include_once '../../conf/connection.php';
    $db = new Database();
    $conn = $db->getConnection();  
    $logRepository = new LogRepository();
    $userRepository = new UserRepository();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Dashboard | Employee </title>
      <script src="../../Lib/js/jquery.js"></script>
      <link href="../../Lib/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet" media="screen" />
      <link href="../../Public/lib/dashboard.css" rel="stylesheet">
      <link href="../../public/css/style.css" rel="stylesheet" />
      <link href="../../public/lib/search.css" rel="stylesheet" />

      <link rel="icon" href="../../Public/images/logo.png">
  </head>
  <body class = "empDashboard">
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
              <a class="navbar-brand" href="#"><h1><span>M</span>ango <span>I</span>nteractive <span>M</span>anagement <span>I</span>nformation <span>S</span>ystem </h1></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
              <li><a href="#">Dashboard</a></li>
              <li><a href="#">Settings</a></li>
              <li><a href="#">Profile</a></li>
              <li><a href="#">Help</a></li>
          </ul>

          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <div class = "profile">
                     <img class = "profilePic" src = "../../Public/images/no-image.jpg">
                </div>
                  <ul class="nav nav-sidebar">
                    <li class="navEmpDashPage active"><a href="#"><span class = "glyphicon glyphicon-dashboard"></span> Dashboard <span class="sr-only">(current)</span></a></li>
                    <li class = "navReq"><a href="#"><span class = "glyphicon glyphicon-share-alt"></span> Manage Request</a></li>
                   <!--  <li class = "navRequirements"><a href="#"><span class = "glyphicon glyphicon-check"></span> Manage Requirements</a></li> -->
                    <li class = "navMessages"><a href="" ><span class = "glyphicon glyphicon-envelope"></span> Messages</a></li>
                    <li class = "navNoti"><a href="#"><span class = "glyphicon glyphicon-globe"></span> Notification </a></li>
                    <li class = "navMyAccount"><a href="" ><span class = "glyphicon glyphicon-user"></span> My Account</a></li>
                  </ul>
                  <ul class="nav nav-sidebar manageGroup">
                    <!-- <li class = "navReports"><a href="" ><span class = "glyphicon glyphicon-envelope"></span> Reports</a></li> -->
                    <!-- <li class = "navMessages"><a href="" ><span class = "glyphicon glyphicon-envelope"></span> Messages</a></li> -->
                    
                    <li class = "navLogout"><a href="" ><span class = "glyphicon glyphicon-off"></span> Logout</a></li>
                  </ul>
            </div>  
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <div class="mainContainer employee">
                    <div class="dashboardContainer">
                        <div class="headeremployee">
                            <div>
                                 <?php
                                      $id = $userRepository->findUserById($_GET['id']);
                                      foreach($id as $row){
                                          echo "<h4>Welcome ". $row['firstname']." ".$row['lastname']."!</h4>";
                                      }
                                 ?> 
                                 <div class="bread-crumb">
                                   Employee Dashboard > Home 
                                 </div>
                            </div>
                        </div>
                        <div class="dashboardStatistics">
                            <div class="top">
                                <h1>Employee Dashboard</h1>
                            </div>
                                <div class="main">
                                    <div>
                                        <div class="count">154</div>
                                        <div class="name">Organizations</div>
                                        <div class="footer">
                                          More info <span class = "glyphicon glyphicon-circle-arrow-right"></span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="count">
                                          <?php 
                                              $count = $userRepository->countAllUsers();
                                              foreach($count as $row){ echo $row['totalUsers']; }
                                          ?> 
                                        </div>
                                        <div class="name">Registered Employees</div>
                                        <div class="footer">
                                          More info <span class = "glyphicon glyphicon-circle-arrow-right"></span>
                                        </div>
                                    </div>
                                    <div>
                                       <div class="count">
                                         <?php 
                                              $count = $userRepository->countAllVerifiedUsers();
                                              foreach($count as $row){ echo $row['totalVerifiedUsers']; }
                                          ?> 
                                        </div>
                                        <div class="name">Verified Users</div>
                                        <div class="footer">
                                           More info <span class = "glyphicon glyphicon-circle-arrow-right"></span>
                                        </div>
                                    </div>  
                                    <div>
                                       <div class="count">
                                          <span> 
                                          <?php
                                              $count = $userRepository->countAllAdminUsers();
                                              foreach($count as $row){ echo $row['adminUsers']; }
                                          ?></span>
                                          <span>
                                          <?php
                                              $count = $userRepository->countAllEmployeeUsers();
                                              foreach($count as $row){ echo $row['employeeUsers']; }
                                          ?>
                                          </span>
                                        </div>
                                        <div class="name"><span>Admin Users </span><span> Employee Users</span></div>
                                        <div class="footer">
                                          More info <span class = "glyphicon glyphicon-circle-arrow-right"></span>
                                        </div>
                                   </div>
                                </div>      
                                <div class="mainBottom">
                                    <div class="recentActivities">
                                        <ul class="list-group">
                                          <li class="list-group-item headerAct">Recent Activities</li>
                                          <?php
                                               $userLogs = $logRepository->getAllUserLogs();
                                                foreach ($userLogs as $key => $value) {
                                                    $queryId = $userRepository->findUserById($value['user_whoCreate_id']);
                                                    foreach ($queryId as $key => $user) {
                                                       $fullName =  $user['firstname']." ".$user['lastname'];
                                                       echo ' <li class="list-group-item">
                                                                  <div><b>'.$fullName.'</b></div><div>'.$value['description'].'<span>'.$value['dateCreated'].'</span></div>
                                                              </li>';
                                                    }
                                                }
                                          ?>
                                        </ul>
                                    </div>
                                    <div class="sampl">
                                      test
                                    </div>
                                </div>
                        </div>
                    </div>
                     <?php
                          include_once "logs.php";
                          include_once "messages.php";
                          include_once "notification.php";
                          include_once "manage/request.php";
                          include_once "manage/account.php";
                      ?>
                </div>
            </div>
        </div>
    </div>   
    <script src="../../Public/js/app.dashboard.js"></script>
  </body>
</html>
