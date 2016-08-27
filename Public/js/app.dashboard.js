
var baseUriDomain = window.location.origin;
    uriStructure = baseUriDomain.split('/');

    if(uriStructure[2] != "localhost") {
        baseUriDomain = baseUriDomain;
    }else{
        baseUriDomain = baseUriDomain+'/Capstone';
    }
    console.log(baseUriDomain);

// $('.navManageUser')
/** USER MANAGEMENT **/

//show/hides of createnewuser, logs and listuser
  $('.userLogsContainer').hide();
  $('.createNewUserContainer').hide(); 
var tab_createNewUser = $('a.label.label-primary.createNewUser');
    tab_createNewUser.on("click", function(e){
        e.preventDefault();
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        $('.userListContainer').hide();
        $('.userLogsContainer').hide();
        $('.createNewUserContainer').show(); 

    });
var tab_userLogs = $('li.tab.userLogs');
    tab_userLogs.on("click", function(e){
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        $('.userListContainer').hide();
        $('.createNewUserContainer').hide(); 
        $('.userLogsContainer').show();
    });
 var tab_userList = $('li.tab.userList');
    tab_userList.on("click", function(e){
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        $('.userLogsContainer').hide();
        $('.createNewUserContainer').hide(); 
        $('.userListContainer').show();
    });

$('.editUser ').each(function(){
    $(this).click(function(e){
        e.preventDefault();
        $('#personalDetails').toggle('show');
        $('#employmentDetails').toggle('hide');

        var _update = $('.update');
        var data = $(this).parent().siblings();
           console.log(data);

        _update.find("input#user_id").val(data[0].innerText);
        _update.find("input#user_firstname").val(data[3].innerText);
        _update.find("input#user_middlename").val(data[4].innerText);
        _update.find("input#user_lastname").val(data[5].innerText);
        _update.find("input#user_username").val(data[6].innerText);
        _update.find("input#user_email").val(data[7].innerText);
        // $('.update').find("input#user_password").val(data[8].innerText);
        // $('.update').find("input#user_rep_password").val(data[9].innerText);

        showModal();

      
    });
});
$('.popup span.glyphicon.glyphicon-remove').on('click', function(e){
        hideModal();
})

var _remove = $('a.removeUser.glyphicon.glyphicon-trash');
	_remove.on('click',function(e){
        e.preventDefault();
		if (!confirm("Do you want to delete")){
	      return false;
	    }

        var _id = $(this).data("id");
        $.ajax({
                url: baseUriDomain+'/conf/doctrine/user.crud_Interaction.php',
                type: 'GET',
                data: {userData: _id},
                dataType: 'json',
                success: function(response){
                    for(var data in response) {
                        if(response[data].user_removeBy_Id == true) {
                              $('tr.id-'+_id).remove();
                        }
                    }
                }
            });
	    
	});
function hideModal(){
      $('div#myPopUpDiv').hide();
    $('.popup').hide();
}
function showModal(){
       $('div#myPopUpDiv').show();
        $('.popup').show();
}

var _requestLeaveForm = $('form#leave-form');
    _requestLeaveForm.on("submit", function(e){
        e.preventDefault();
            console.log("submit is working!");
        var formDataArray = $(this).serializeArray();
        console.log(formDataArray);
        $.ajax({
                    url: baseUriDomain+'/conf/doctrine/request.repositoryManager.php',
                    type: 'GET',
                    data: {requestData: formDataArray},
                    dataType: 'json',
                    success: function(response){
                        console.log(response);
                    }
                });
});
var _requestOTForm = $('form#ot-form');
_requestOTForm.on("submit", function(e){
    e.preventDefault();
    var doctrineConfigurationPath = '/conf/doctrine/';
    var _loader = $(this).find('.ajaxLoader');
        _loader.show();
    var formDataArray = $(this).serializeArray();

    $.ajax({
        url: baseUriDomain+doctrineConfigurationPath+'request.repositoryManager.php',
        type: 'GET',
        data: {requestData: formDataArray},
        dataType: 'json',
        success: function(response){
            console.log(response);
            _loader.hide();
        }
    });
});

/// EMPLOYEE
$('.navReq').on("click", function(e){
    e.preventDefault();
    processNavigationOnClick(this);
    });
$('.navEmpDashPage').on("click", function(e){
    e.preventDefault();
    processNavigationOnClick(this);
    });
$('.navRequirements').on("click", function(e){
    e.preventDefault();
     processNavigationOnClick(this);
    });

$('.navNoti').on("click", function(e){
    e.preventDefault();
    processNavigationOnClick(this);
    });

$('.navReports').on("click", function(e){
    e.preventDefault();
    processNavigationOnClick(this);
    });

$('.navMyAccount').on("click", function(e){
    e.preventDefault();
    processNavigationOnClick(this);
    });


$('.overTimeTabMenu').on("click", function(e){
    e.preventDefault();
    requestTabMenu(this);
    });
$('.leaveTabMenu').on("click", function(e){
    e.preventDefault();
    requestTabMenu(this);
    });
$('.excuseToAbsentTabMenu').on("click", function(e){
    e.preventDefault();
    requestTabMenu(this);
    });
function requestTabMenu(element){
    var menuClass = ["overTimeTabMenu", "leaveTabMenu", "excuseToAbsentTabMenu" ];
    var tabMenuPages = ["overTimeContainer", "leaveContainer", "responseContainer"];

    var _convertToArrayElement = $(element);
    var getClassName = _convertToArrayElement[0]['className'];

    var getIndex = menuClass.indexOf(getClassName);

    for (i = 0; i < tabMenuPages.length; i++) {
        if(i != getIndex){
            $('#'+tabMenuPages[i]).hide();
            $('#'+tabMenuPages[i]).removeClass('in active');
        }else{
             $('span.breadCrumd').html(getClassName); 
             $('#'+tabMenuPages[i]).show(); 
             $('#'+tabMenuPages[i]).addClass('in active');

        }
    }
     for (i = 0; i < menuClass.length; i++) { 
         if(menuClass[i] != getClassName){
               $('.'+menuClass[i]).removeClass("in active");  
         }else $('.'+menuClass[i]).addClass("in active");  
    }
}
function processNavigationOnClick(element) {
    var clickElements = ["navEmpDashPage", "navReq", "navRequirements", "navNoti", "navReports", "navMyAccount", "navLogout", "navMessages"];
    var pageContainer = ["dashboardContainer", "requestContainer", "requirementsContainer", "notificationContainer", "reportContainer", "accountContainer", "logoutContainer", "messagesContainer"];

    var _convertToArrayElement = $(element);
    var getClassName = _convertToArrayElement[0]['className'];

    var getIndex = clickElements.indexOf(getClassName);
    // var checkIfExist = (getIndex != -1) ? true : false ;

    for (i = 0; i < pageContainer.length; i++) {
        if(i != getIndex){
            $('.'+pageContainer[i]).hide();
        }else $('.'+pageContainer[i]).show();
    }
    for (i = 0; i < clickElements.length; i++) { 
         if(clickElements[i] != getClassName){
               $('.'+clickElements[i]).removeClass("active");  
         }else $('.'+clickElements[i]).addClass("active");  
    }
}

//ADmin
$('.navAdminDashPage').on("click", function(e){
    e.preventDefault();
    processAdminNavigationOnClick(this);
    });
$('.navAdminRequirements').on("click", function(e){
    e.preventDefault();
    processAdminNavigationOnClick(this);
    });
$('.navAdminReq').on("click", function(e){
    e.preventDefault();
     processAdminNavigationOnClick(this);
    });

$('.navAdminUsers').on("click", function(e){
    e.preventDefault();
    processAdminNavigationOnClick(this);
    });

$('.navAdminNoti').on("click", function(e){
    e.preventDefault();
    processAdminNavigationOnClick(this);
    });

$('.navAdminReports').on("click", function(e){
    e.preventDefault();
    processAdminNavigationOnClick(this);
    }); 
$('.navAdminMyAccount').on("click", function(e){
    e.preventDefault();
    processAdminNavigationOnClick(this);
    });

function processAdminNavigationOnClick(element) {
    var clickElements = [
                            "navAdminDashPage", 
                            "navAdminRequirements", 
                            "navAdminReq", 
                            "navAdminUsers", 
                            "navAdminNoti", 
                            "navAdminReports", 
                            "navAdminMyAccount"
                        ];
    var pageContainer = [
                            "dashboardContainerAdmin", 
                            "requirementsContainerAdmin", 
                            "requestContainerAdmin", 
                            "userContainerAdmin", 
                            "notificationContainerAdmin", 
                            "reportsContainerAdmin", 
                            "myAccountContainerAdmin"
                        ];

    var _convertToArrayElement = $(element);
    var getClassName = _convertToArrayElement[0]['className'];

    var getIndex = clickElements.indexOf(getClassName);
    // var checkIfExist = (getIndex != -1) ? true : false ;

    for (i = 0; i < pageContainer.length; i++) {
        if(i != getIndex){
            $('.'+pageContainer[i]).hide();
        }else $('.'+pageContainer[i]).show();
    }
    for (i = 0; i < clickElements.length; i++) { 
         if(clickElements[i] != getClassName){
               $('.'+clickElements[i]).removeClass("active");  
         }else $('.'+clickElements[i]).addClass("active");  
    }
}

// Approved submit
$('table.requestview tr td.action a').on("click",function(e){
    var doctrineConfigurationPath = '/conf/doctrine/';
    e.preventDefault();
    var _getId = $(this).data('id');
    var _getTable = $(this).data('table');

    var data = [];
        data['id'] = _getId;
        data['table'] = _getTable;
        data['toProcess'] = "approved";

console.log("this is data ",data);
    $.ajax({
        url: baseUriDomain+doctrineConfigurationPath+'request.repositoryManager.php',
        type: 'GET',
        data: {requestData: data},
        // dataType: 'json',
        success: function(response){
            console.log(response);
        }
    });
});