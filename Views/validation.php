
<script src="../Lib/js/jquery.js"></script>
<link href="../public/lib/mypopup.css" rel="stylesheet" />
<link href="../public/css/style.css" rel="stylesheet" />
<link href="../Lib/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet" />
<div id='myPopUpDiv' class = 'fade validateAccountPopUpDiv' style = 'display:block'></div>
<div class='popup validateAccount' style ="display:block">
    <span class='glyphicon glyphicon-remove'></span>
    <div class='title'>Validate Account</div>
    <div class='content'>
        <span class='query' hidden></span>
        <div class = 'message' style = "display:none">
            Click here to validate your account.
        </div>
        <div class = 'caption'>
            Click here to validate your account.
        </div>
        <div class = 'validateButton'>
        <img class = 'ajaxLoader' src='../Public/images/loader.gif'/>
            <a class = "validateAccount btn btn-success" href = "#"  data-type = "<?php echo $_GET['type'];?>" data-id = "<?php echo $_GET['id'];?>"><span class = 'glyphicon glyphicon-ok'></span> Validate</a>
        </div>
    </div>
</div>
<script src="../Public/js/app.js"></script>