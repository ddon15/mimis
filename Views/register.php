<?php 
    include_once '../conf/connection.php';
    $db = new Database();
    $conn = $db->getConnection();    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>

        <link href="../Lib/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet" media="screen" />
        <link href="../public/css/style.css" rel="stylesheet" />
        <link href="../public/lib/search.css" rel="stylesheet" />

    </head>
    <body class = "register">
        <div class="header">
            <div class="content">
                <h1><span>M</span>ango <span>I</span>nteractive <span>M</span>anagement <span>I</span>nformation <span>S</span>ystem </h1>
            </div>
             <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="  search-query form-control" placeholder="Search" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="button">
                            <span class=" glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div id="mainContainer">
            <div class="logo">
                <img src="../Public/images/logo.png"/>
            </div>
            <div class="loginForm">
            <div class = "formContent">
             <p><a href = "login.php" class = "glyphicon glyphicon-level-up back"><span> Back to login</span> </a></p>
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
        <div id="footer">
            <div class="content">
                - copyright &copy; 2016 - 2017, Churva's Capstone Group -
            </div>
        </div>
        <script src="../Lib/js/jquery.js"></script>
        <!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->
        <script src="../Public/js/app.js"></script>
    </body>
</html>