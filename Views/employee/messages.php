<?php 
    require_once dirname(__FILE__).'\../../Repository/UserRepository.php';
    include_once dirname(__FILE__).'\../../conf/connection.php';

    $db = new Database();
    $conn = $db->getConnection();  
    $userRepository = new UserRepository();

?>
<div class="messagesContainer" hidden>
    <div class="headeradmin">
        <div>
              <?php
                    $id = $userRepository->findUserById($_GET['id']);
                    foreach($id as $row){
                        echo "<h4>Welcome ". $row['firstname']." ".$row['lastname']."!</h4>";
                    }
               ?> 
             <div class="bread-crumb">
               Dashboard > Messages<span class="breadCrumd"></span>
             </div>
        </div>
    </div>
    <div class="requestStatistics">
        <div class="top">
            <h1>Messages</h1>
           <!--  <ul class="nav nav-tabs menu">
                <li class="usersWithReqTabMenu active"><a data-toggle="tab"  href="#">User's list</a></li>
                <li class = "createMessageTabMenu"><a data-toggle="tab" href="#">Create Message</a></li>
            </ul> -->
        </div>
        <div class="main">
            <div class="tab-content page">
                    this is messages
            </div>
        </div>
    </div>     
</div>
