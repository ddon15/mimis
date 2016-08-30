var baseUriDomain = window.location.origin;
	uriStructure = baseUriDomain.split('/');

	if(uriStructure[2] != "localhost") {
		baseUriDomain = baseUriDomain;
	}else{
		baseUriDomain = baseUriDomain+'/Capstone';
	}
	console.log(baseUriDomain);


var _loginForm = $('form#login-form');
var _registrationForm = $('form#register-form');
//modal
var _modalAskAdminPassword = $('.linkSetModalAdminPassword');
var _btnContinue = $('#btn-adminPassword');

_btnContinue.on("click", function(e) {
	e.preventDefault();
	var $this = $('#modalAdminPassword');
	txt = $this.find('.adminPassword');
	$.ajax({
		url: baseUriDomain+'/conf/doctrine/user.crud_Interaction.php',
		type: 'GET',
		data: {userData: txt.val()},
		dataType: 'json',
		success: function(response) {
			var errorElement = $this.find('.adminPasswordError');
			// console.log(response);
			for(var data in response) {
				if(response[data].user_check_adminPassword == false) {
					errorElement.html("Invalid admin password.");
					errorElement.show();
				}else if(response[data].user_check_adminPassword[1] == true){
					errorElement.hide();
					window.location.href = 'register.php?id='+response[data].user_check_adminPassword[0];
				}
			}
		}
	});

});
//This is for login form validation
_loginForm.on("submit", function(e){
	e.preventDefault();

	//get form name
	var formDOM = $(this).context.id.split('-');
	    formName = formDOM[0];

	var getDataValidated = validateForm(this, formName);
		getError = getDataValidated[0];
		if(getError < 1){
			var _data = [];
			$(getDataValidated[1]).each(function(e){
				_data.push(this.value);
			});

			$.ajax({
				url: baseUriDomain+'/conf/doctrine/user.crud_Interaction.php',
				type: 'GET',
				data: {userData: _data},
				dataType: 'json',
				success: function(response){
					var errEl = $('.loginForm').find('.auth.error-message.showError');
					var _return = response[1].user_auth_process;

					if(_return[0] == false) {
						errEl.html("Invalid username or password.");
						errEl.show();
					}else if(_return[1] == "anonymous_user"){
						errEl.hide();
						var userId = _return[2];

						//checking the status if not verified
						if(_return[3] == 2){
							if (!confirm("Your account was not verified yet, Do you want to verify your account now?")){
						      return false;
						      window.location.href = "employee/dashboard.php?id="+_return[2];
						    }
							window.location.href = "validation.php?type=employee&&id="+_return[2];
						}
						window.location.href = "employee/dashboard.php?id="+_return[2];
					}else{
						errEl.hide();
						var userId = _return[2];
						
						//checking the status if not verified
						if(_return[3] == 2){
							if (!confirm("Your account was not verified yet, Do you want to verify your account now?")){
						      return false;
						      window.location.href = "admin/dashboard.php?id="+_return[2];
						    }
							window.location.href = "validation.php?type=admin&&id="+_return[2];
						}
						window.location.href = "admin/dashboard.php?id="+_return[2];
					}
				}
			});

		}else{
			console.log("naa error");
		}

});

// This is for registration form validation
_registrationForm.on("submit", function(e){
	e.preventDefault();

	var getDataValidated = validateForm(this);
		getError = getDataValidated[0];
		if(getError < 1){
			var _data = [];
			$(getDataValidated[1]).each(function(e){
				_data.push(this.value);
			});
			$.ajax({
				url: baseUriDomain+'/conf/doctrine/user.crud_Interaction.php',
				type: 'GET',
				data: {userData: _data},
				dataType: 'json',
				success: function(response){
					console.log(response);
					for(var data in response) {
						if(response[data].user_creating_new == false) {
							showFailed();
						}else if(response[data].user_creating_new == true){
							showSuccess();
						}
					}
				}
			});

		}else{
			console.log("naa error");
		}
});
function showSuccess(){
	_registrationForm.find('input').val("");
}
function showFailed(){
	return false;
}

function validateForm(form, formType){
	var err = 0;
	var data = $(form).serializeArray();

	for (i = 0; i < data.length; i++) { 

		_data = data[i];
		var el = $('.err-'+_data.name);

		//required fields
		if(_data.value == ""){
			el.html("Please input this field, Required.");
			el.addClass("showError");
			el.show();

			err = err + 1;
		}else if(_data.name == "email" && _data.value.search("@") < 0){
			el.html("This field missing '@', Please input @ on the field.");
			el.addClass("showError");
			el.show();

			err = err + 1;
		}else el.hide();
	}

	if(formType != "login" && formType == "register"){
		//confirmation password
		_getPassword = (typeof data[4]['value'] != "") ? data[4]['value'] : '' ;
		_getRepeatedPassword = (typeof data[5]['value'] != "") ? data[5]['value'] : '' ;

		if(_getPassword != _getRepeatedPassword) {
			$('.err-password').html("Password did not match.");
			$('#user_password').val("");
			$('#user_rep_password').val("");
			$('.err-password').show();

			err = err + 1;
		}
		// terms and conidtions
		if(!form.term_accpt.checked) {
	    	$('.err-terms_accpt').html("Please indicate that you accept the terms and conditions.");
	     	$('.err-terms_accpt').show();

	     	err = err + 1;
	    }else $('.err-terms_accpt').hide();
	}

    return validate = [ err, data ];
}
var personalInformationElement = $('.glyphicon.glyphicon-user.personal');
    _this = personalInformationElement.find('.forPersonalDetails');
    _this.on('click', function(e){
    
    var parent = $(this).parent();
    parent.find("#personalDetails").toggle(1000);
    console.log(parent.siblings());
    parent.siblings().find("#employmentDetails").toggle(1000);
});
var employmentInformationElement = $('.glyphicon.glyphicon-object-align-horizontal.employment');
    _this = employmentInformationElement.find('.forEmploymentDetails');
    _this.on('click', function(e){
    
    var parent = $(this).parent();
    parent.find("#employmentDetails").toggle(1000);
    console.log(parent.siblings());
    parent.siblings().find("#personalDetails").toggle(1000);
});
$('a.validateAccount').on('click',function(e){
	
	var element = $(this);
	var loader = element.siblings('.ajaxLoader');

	loader.show();	
	var data = {
		0: 'validateAccount',
		1: element.data('id'),
		2: element.data('type')
	};
	$.ajax({
		url: baseUriDomain+'/conf/doctrine/user.crud_Interaction.php',
		type: 'GET',
		data: {userData: data},
		dataType: 'json',
		success: function(response){
			if(response[4].user_verify_account == true){
				loader.hide();
				$('.validateAccount .message').html("<span class = 'list-group-item list-group-item-success'>Your account was successfully validated!</span>");
				$('.validateAccount .message').show();
				setTimeout(function(){
					loader.show();
					$('.validateAccount .message').html("<span class = 'list-group-item list-group-item-success'>We are now redirecting you to your home page dashboard.</span>");
				}, 3000);
				setTimeout(function(){	
					 window.location.href = element.data('type')+"/dashboard.php?id="+element.data('id');
				}, 7000);
			}
		}
	});

});