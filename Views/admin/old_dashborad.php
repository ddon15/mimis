<?php
  // include_once '../Repository/UserRepository.php';
  // $repository = new UserRepository();
  // $getAllData = $repository->findUserById($_GET['id']);
  // var_dump($getAllData);exit;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <title>Dashboard | Admin </title>
      <script src="../../Lib/js/jquery.js"></script>
      <link href="../../Lib/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet" media="screen">
      <link href="../../Public/lib/dashboard.css" rel="stylesheet">
      <link href="../../public/css/style.css" rel="stylesheet" />
      <link href="../../public/lib/search.css" rel="stylesheet" />
      <link href="../../public/lib/mypopup.css" rel="stylesheet" />
  </head>
  <body class = "admin">
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
            <li><a href="#" class = "glyphicon glyphicon-dashboard">Dashboard</a></li>
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
          <div class = "profile"><img class = "profilePic" src = "../../Public/images/no-image.jpg"></div>
          <ul class="nav nav-sidebar">
            <li class="navDashPage active"><a href="#" ><span class = "glyphicon glyphicon-dashboard"></span> Dashboard <span class="sr-only">(current)</span></a></li>
            <li class = "navNoti"><a href="#"><span class = "glyphicon glyphicon-globe"></span> Notifications <span class="badge">14</span></a></li>
            <li  class = "navReports"><a href="#" ><span class = "glyphicon glyphicon-envelope"></span> Reports</a></li>
            <li><a href="#" ><span class = "glyphicon glyphicon-log-in"></span> Logs</a></li>
          </ul>
          <ul class="nav nav-sidebar manageGroup">
            <li class = "navManageUser"><a href="" ><span class = "glyphicon glyphicon-user"></span> Manage User</a></li>
            <li class = "navManageOT"><a href=""  ><span class = "glyphicon glyphicon-share-alt"></span> Manage Request</a></li>
            <li class = "navManageEmpReq"><a href=""  ><span class = "glyphicon glyphicon-th-list"></span> Manage Employee Requirements</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="" ><span class = "glyphicon glyphicon-off"></span> Logout</a></li>
          </ul>
        </div>  
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="mainContainer">
            <?php
                include_once "manage/user.php";
            ?>
        </div>
        </div>
      </div>
    </div>
  </body>
</html>
