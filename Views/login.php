<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link href="../Lib/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet" media="screen" />

		<link href="../public/css/style.css" rel="stylesheet" />
		<link href="../public/lib/search.css" rel="stylesheet" />
	</head>
	<body class = "login">
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
				<h1>Login</h1>
				<p class = "regLink"> Want to add new employee quickly? Click here to <a href = "#" data-toggle="modal" data-target=".bs-example-modal-lg" class = "linkSetModalAdminPassword"> register. </a></p>
				<form class="form-login" method="post" id="login-form">
					<div class="auth error-message showError" hidden>
					</div>
					<div class="form-group">
						<div class = "err-email error-message"></div>
						<input type="text" class="form-control" placeholder="Email address" name="email" id="user_email" />
						<!-- <span id="check-e"></span> -->
					</div>
					<div class="form-group">
						<div class = "err-password error-message"></div>	
						<input type="password" class="form-control" placeholder="Password" name="password" id="password" />
					</div>
					<div class="form-group submit">
						<button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
						<span class="glyphicon glyphicon-log-in"></span> &nbsp; Login
						</button>
						 <a href = "#">Forgot password</a>. 
					</div>  
				</form>
			</div>
		</div>
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg" id = "modalAdminPassword" role="document">
				<div class="modal-content">
					<div class="form-group">
						<label class= "adminPasswordLabel">Registering new account needs credentials from management.</label><br>
						<div class="adminPasswordError"></div>
						<input class="form-control adminPassword" type = "password" placeholder = "Enter admin password" value = ""/>						
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="btn-adminPassword" id="btn-adminPassword">
							<span class="glyphicon glyphicon-log-in"></span> &nbsp; Continue
						</button>
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
			<div class="content">
				- copyright &copy; 2016 - 2017, Churva's Capstone Group -
			</div>
		</div>
		<!-- All Js Script down here -->
		<script src="../Lib/js/jquery.js"></script>
		<script src="../Lib/js/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->
        <script src="../Public/js/app.js"></script>
	</body>
</html>