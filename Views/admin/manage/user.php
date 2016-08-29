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
 <link href="../../Public/lib/mypopup.css" rel="stylesheet" />
<div class="userContainerAdmin" hidden>
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
            <h1 class="pageTitle">User Management</h1>
            <ul class="nav nav-tabs menu">
                <li role="presentation" class="tab userList active"><a href="#">User list</a></li>
                <li role="presentation" class = "tab userLogs"><a href="#">User logs</a></li>
                <li role="presentation" class = ""><a href="#">Messages</a></li>
            </ul>
        </div>
            <div class="main">
                    <!-- POP DIV -->
    <div id="myPopUpDiv" class = "fade updatePopUpDiv" style = "display:none"></div>
    <div class="popup updateForm">
        <span class="glyphicon glyphicon-remove"></span>
        <div class="title">Update</div>
        <div class="content">
            <span class="query" hidden></span>
            <form class="form-registration update" method="post" id="register-form"><br>
                <div class="glyphicon glyphicon-user personal">
                    <span class = "forPersonalDetails">Personal Information</span>
                    <br><br>
                    <div id="personalDetails">
                     <div id="error">
                    </div>
                    <input type="text" class="form-control" name="id" id="user_id" style="display:none" />
                    <div class="form-group">
                        <div class = "err-firstname error-message"></div>
                        <span>First Name</span>
                        <input type="text" class="form-control" placeholder="First Name" name="firstname" id="user_firstname" />
                    </div>
                    <div class="form-group">
                        <div class = "err-middlename error-message"></div>
                        <span>Middle Name</span>
                        <input type="text" class="form-control" placeholder="Middle Name" name="middlename" id="user_middlename" />
                    </div>
                    <div class="form-group">
                        
                        <div class = "err-lastname error-message"></div>
                        <span>Last Name</span>
                        <input type="text" class="form-control" placeholder="Last Name" name="lastname" id="user_lastname" />
                    </div>
                    <div class="form-group">
                        <div class = "err-email error-message"></div>
                        <span>Email</span>
                        <input type="text" class="form-control" placeholder="Email" name="email" id="user_email" />
                    </div>
                    <div class="form-group">
                        <div class = "err-mobileno error-message"></div>
                        <span>Mobile No.</span>
                        <input type="text" class="form-control" placeholder="Mobile" name="mobileno" id="user_mobileno" />
                    </div>
                    <div class="form-group">
                        <div class = "err-username error-message"></div>
                        <span>Username</span>
                        <input type="text" class="form-control" placeholder="Username" name="username" id="user_username" />
                    </div>
                    <div class="form-group">
                        <div class = "err-password error-message"></div>
                        <span>Password</span>
                        <input type="password" class="form-control" placeholder="Password" name="password" id="user_password" />
                    </div>
                    <div class="form-group">
                        <div class = "err-rep_password error-message"></div>
                        <span>Repeat Password</span>
                        <input type="password" class="form-control" placeholder="Repeat Password" name="rep_password" id="user_rep_password" />
                         <input type="text" class="form-control" name="userWhoCreateId" value = <?php echo $_GET['id']; ?> style = "display:none;"/>
                    </div>
                </div>

                </div>
                <div class="glyphicon glyphicon-object-align-horizontal employment">
                    <span class = "forEmploymentDetails">Employment Information</span>
                    <div class="fields">
                        <div id="employmentDetails">
                            <div class="form-group userType">
                            <br><br>
                                <span>This new user is </span>
                                <div class="styled-select slate">
                                    <select name = "userType">
                                        <?php 
                                            $query = "SELECT * FROM user_type";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();

                                            foreach ($stmt as $key => $value) { 
                                            echo "<option value =".$value['id'].">".$value['role_name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group department">
                                <span>Department : </span>
                                <div class="styled-select slate">
                                     <select name = "department">
                                    <?php 
                                        $query = "SELECT * FROM departments";
                                        $stmt = $conn->prepare($query);
                                        $stmt->execute();

                                        foreach ($stmt as $key => $value) {
                                        echo "<option value =".$value['id'].">".$value['name']."</option>";
                                        }
                                    ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group position">
                                <span>Position : </span>
                                <div class="styled-select slate">
                                    <select name = "empPosition">
                                        <?php 
                                            $query = "SELECT * FROM employee_position";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();

                                            foreach ($stmt as $key => $value) {
                                            echo "<option value =".$value['id'].">".$value['name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                              <div class="form-group position">
                                <span>Contract : </span>
                                <div class="styled-select slate">
                                    <select name = "empType">
                                        <?php 
                                            $query = "SELECT * FROM employment_type";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();

                                            foreach ($stmt as $key => $value) {
                                            echo "<option value =".$value['id'].">".$value['name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- <div class="form-group">
                        <div class = "err-terms_accpt error-message"></div>
                        <span>Terms Accepted</span>
                            <input type="checkbox" name="term_accpt" id= "termAccp" value = 1 />    
                            I agree and accept the <a href = "#">terms</a> and <a href = "#">policy</a> based on stated facts.
                    </div> -->
                    <div class="form-group submit">
                        <button type="submit" class="btn btn-default" name="btn-register" id="btn-register">
                        <span class="glyphicon glyphicon-save"></span> &nbsp; Save
                        </button> 
                    </div> 
                </form>
        </div>
        <div class="footer">
            <div class="btns">
                <button class = "btn btn-success save"><span class = "glyphicon glyphicon-download-alt"></span><span>Update</span></button>
                <button class = "btn btn-danger cancelorclose"><span class = "glyphicon glyphicon-remove"></span><span>Close</span></button>
            </div>
        </div>
   </div>
   <!-- end of popup -->
    <!-- user logs -->
    <div class="userLogsContainer">
        <?php

            $userLogs = $logRepository->getAllUserLogs();
            foreach ($userLogs as $key => $value) {
                $queryId = $userRepository->findUserById($value['user_whoCreate_id']);
                foreach ($queryId as $key => $user) {
                   $fullName =  $user['firstname']." ".$user['lastname'];
                   echo '
                    <div class="media">
                        <div class="media-left">
                                <a href="#">
                                     <img class="media-object" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTY4MmEyYmYyZiB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1NjgyYTJiZjJmIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxNC41IiB5PSIzNi41Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" alt="...">
                                </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">'.$fullName.'</h4>
                               <p class = "desc"> '.$value['description'].'. Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
                            </p>
                            <p class = "timelogs">'.$value['dateCreated'].'</p>
                        </div>
                    </div>
                   ';
                }
            }
        ?>
    </div>
    <!-- list of user -->
    <div class="userListContainer">
        <div class="table-responsive">
            <a href = "" class = "label label-primary createNewUser"><span class = "glyphicon glyphicon-plus"> </span> Create New User</a>
            <input type = "text" placeholder = "Search user" class="searchUser">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>role</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Status</th>
                        <th style = 'text-align:right'>action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    foreach($userRepository->displayAllUser() as $key => $value) {
                        $status = '';
                        $role = ($value['user_type'] != 3) ? " <span class='glyphicon glyphicon-eye-open' title = 'admin'></span>" : " <span class='glyphicon glyphicon-eye-close' title = 'employee' style = 'display:none'></span>";
                        if($value['status'] == 2)  {
                            $status = "<span class='label label-default'>Non verified</span>";
                        }else if($value['status'] == 1) {
                            $status = "<span class='label label-success'>Verified</span>";
                        }else if($value['status'] == 0) {
                            $status = "<span class='label label-danger'>Inactive</span>";
                        }else echo '';
                        
                        //random string
                         $email = $value['email'];
                        $charactersLength = strlen($email);
                        $randomString = '';
                        for ($i = 0; $i < 10; $i++) {
                            $randomString .= $email[rand(0, $charactersLength - 1)];
                        }
                        //end of random string
                        if($value['id'] != $_GET['id']){
                            $update = "<a href = '' class = 'editUser glyphicon glyphicon-edit' data-id=".$value['id']."  title = 'Update this user.' ></a> | ";
                            $remove = "<a class = 'removeUser glyphicon glyphicon-trash' data-id=".$value['id']." data-fname=".$value['firstname']." href = '#' title = 'Delete this user.'></a>";
                        }else{
                            $update = "<span class = 'label label-primary'>Logged In";
                            $remove = " authority</span>";
                        }
                        echo "
                            <tr class = 'id-".$value['id']."'>
                                <td class = 'id'>".$value['id']."</td>
                                <td class = 'role'>".$role."</td>
                                <td class = 'complete'>".$value['firstname']." ".$value['middlename']." ".$value['lastname']." </td>
                                <td class = 'firstname' style = 'display:none'>".$value['firstname']." </td>
                                <td class = 'middlename' style = 'display:none'>".$value['middlename']." </td>
                                <td class = 'lastname' style = 'display:none'>".$value['lastname']." </td>
                                <td class = 'usermane'>".$value['username']." </td>
                                <td class = 'email'>".$value['email']." </td>
                                <td class = 'password'>".$value['password']." </td>
                                <td class = 'status'>".$status." </td>
                                <td style = 'text-align:right;'>
                                ".$update."
                                ".$remove."
                                </td>
                            </tr>
                        ";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- create new user -->
    <div class="createNewUserContainer">
        <h1>Register</h1>
                <form class="form-registration" method="post" id="register-form"><br>
                <div class="glyphicon glyphicon-user personal">
                    <span class = "forPersonalDetails">Personal Information</span>
                    <br><br>
                    <div id="personalDetails">
                     <div id="error">
                    </div>
                    <div class="form-group">
                        <div class = "err-firstname error-message"></div>
                        <span>First Name</span>
                        <input type="text" class="form-control" placeholder="First Name" name="firstname" id="user_firstname" />
                    </div>
                    <div class="form-group">
                        <div class = "err-middlename error-message"></div>
                        <span>Middle Name</span>
                        <input type="text" class="form-control" placeholder="Middle Name" name="middlename" id="user_middlename" />
                    </div>
                    <div class="form-group">
                        
                        <div class = "err-lastname error-message"></div>
                        <span>Last Name</span>
                        <input type="text" class="form-control" placeholder="Last Name" name="lastname" id="user_lastname" />
                    </div>
                     <div class="form-group">
                        <div class = "err-email error-message"></div>
                        <span>Email</span>
                        <input type="text" class="form-control" placeholder="Email" name="email" id="user_email" />
                    </div>
                    <div class="form-group">
                        <div class = "err-mobileno error-message"></div>
                        <span>Mobile No.</span>
                        <input type="text" class="form-control" placeholder="Mobile" name="mobileno" id="user_mobileno" />
                    </div>
                    <div class="form-group">
                        <div class = "err-username error-message"></div>
                        <span>Username</span>
                        <input type="text" class="form-control" placeholder="Username" name="username" id="user_username" />
                    </div>
                    <div class="form-group">
                        <div class = "err-password error-message"></div>
                        <span>Password</span>
                        <input type="password" class="form-control" placeholder="Password" name="password" id="user_password" />
                    </div>
                    <div class="form-group">
                        <div class = "err-rep_password error-message"></div>
                        <span>Repeat Password</span>
                        <input type="password" class="form-control" placeholder="Repeat Password" name="rep_password" id="user_rep_password" />
                         <input type="text" class="form-control" name="userWhoCreateId" value = <?php echo $_GET['id']; ?> style = "display:none;"/>
                    </div>
                </div>

                </div>
                <div class="glyphicon glyphicon-object-align-horizontal employment">
                    <span class = "forEmploymentDetails">Employment Information</span>
                    <div class="fields">
                        <div id="employmentDetails">
                            <div class="form-group userType">
                            <br><br>
                                <span>This new user is </span>
                                <div class="styled-select slate">
                                    <select name = "userType">
                                        <?php 
                                            $query = "SELECT * FROM user_type";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();

                                            foreach ($stmt as $key => $value) { 
                                            echo "<option value =".$value['id'].">".$value['role_name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group department">
                                <span>Department : </span>
                                <div class="styled-select slate">
                                     <select name = "department">
                                    <?php 
                                        $query = "SELECT * FROM departments";
                                        $stmt = $conn->prepare($query);
                                        $stmt->execute();

                                        foreach ($stmt as $key => $value) {
                                        echo "<option value =".$value['id'].">".$value['name']."</option>";
                                        }
                                    ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group position">
                                <span>Position : </span>
                                <div class="styled-select slate">
                                    <select name = "empPosition">
                                        <?php 
                                            $query = "SELECT * FROM employee_position";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();

                                            foreach ($stmt as $key => $value) {
                                            echo "<option value =".$value['id'].">".$value['name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                              <div class="form-group position">
                                <span>Contract : </span>
                                <div class="styled-select slate">
                                    <select name = "empType">
                                        <?php 
                                            $query = "SELECT * FROM employment_type";
                                            $stmt = $conn->prepare($query);
                                            $stmt->execute();

                                            foreach ($stmt as $key => $value) {
                                            echo "<option value =".$value['id'].">".$value['name']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- <div class="form-group">
                        <div class = "err-terms_accpt error-message"></div>
                        <span>Terms Accepted</span>
                            <input type="checkbox" name="term_accpt" id= "termAccp" value = 1 />    
                            I agree and accept the <a href = "#">terms</a> and <a href = "#">policy</a> based on stated facts.
                    </div> -->
                    <div class="form-group submit">
                        <button type="submit" class="btn btn-default" name="btn-register" id="btn-register">
                        <span class="glyphicon glyphicon-save"></span> &nbsp; Save
                        </button> 
                    </div> 
                </form>
    </div>
            </div>
      </div>     
</div>

 <script src="../../Public/js/app.js"></script>