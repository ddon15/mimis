
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
  $('.createMessageToUserContainer').hide(); 
var tab_createNewUser = $('a.label.label-primary.createNewUser');
    tab_createNewUser.on("click", function(e){
        e.preventDefault();
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        $('.userListContainer').hide();
        $('.userLogsContainer').hide();
          $('.createMessageToUserContainer').hide(); 
        $('.createNewUserContainer').show(); 

    });
var tab_userLogs = $('li.tab.userLogs');
    tab_userLogs.on("click", function(e){
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        $('.userListContainer').hide();
        $('.createNewUserContainer').hide(); 
        $('.createMessageToUserContainer').hide(); 
        $('.userLogsContainer').show();
    });
 var tab_userList = $('li.tab.userList');
    tab_userList.on("click", function(e){
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        $('.userLogsContainer').hide();
        $('.createNewUserContainer').hide(); 
          $('.createMessageToUserContainer').hide(); 
        $('.userListContainer').show();
    });
 var tab_createMessageToUser = $('li.tab.createMessageToUserTabMenu');
    tab_createMessageToUser.on("click", function(e){
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        $('.userLogsContainer').hide();
        $('.createNewUserContainer').hide(); 
        $('.userListContainer').hide();
          $('.createMessageToUserContainer').show(); 
        
    });
    // 

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
            
        var formDataArray = $(this).serializeArray();
       
       var _loader = $(this).find('.ajaxLoader');
        _loader.show();
        $.ajax({
                    url: baseUriDomain+'/conf/doctrine/request.repositoryManager.php',
                    type: 'GET',
                    data: {requestData: formDataArray},
                    dataType: 'json',
                    success: function(response){
                         var msg = $('.leaveForm .message');
                            for(var key in response){
                                if(response[key].request_leave != true){
                                     msg.html('<div class="alert alert-danger" role="alert">Sending leave request to admin, failed!</div>');
                                }
                                 msg.html('<div class="alert alert-success" role="alert">Sending leave request to admin, success!</div>');
                                 _loader.hide();
                                  msg.show();
                            }
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
            var msg = $('.otForm .message');
            for(var key in response){
                if(response[key].request_ot != true){
                     msg.html('<div class="alert alert-danger" role="alert">Sending overtime request to admin, failed!</div>');
                }
                 msg.html('<div class="alert alert-success" role="alert">Sending overtime request to admin, success!</div>');
                 _loader.hide();
                  msg.show();
            }
        }
    });
});
var _requestOTFormAdmin = $('form#ot-admin-form');
_requestOTFormAdmin.on("submit", function(e){
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
            var msg = $('.otFormAdmin .message');
            for(var key in response){
                if(response[key].request_ot != true){
                     msg.html('<div class="alert alert-danger" role="alert">Filing overtime to employee failed.</div>');
                }
                 msg.html('<div class="alert alert-success" role="alert">You have successfully filed overtime to employee.</div>');
                 _loader.hide();
                  msg.show();
            }
        }
    });
});


/* FUNCTION FOR APPROVED OR DISAPPROVED */
// View
$('a.view').on("click",function(e){
    e.preventDefault();
    var element = $(this);
        element.siblings('div#myPopUpDiv').show();
        element.siblings('.popup').show();


});
// notification
var _notification = $('li.navAdminNoti span.badge');
var notificationCount = _notification.html();
if(notificationCount < 1){
    _notification.hide();
}
// Approved submit
$('table.requestview tr td.action a.approved').on("click",function(e){
    e.preventDefault();
    var element = $(this);
    var response = element.attr('class');

     //compose
    var loaderElement = element.siblings('img');
    var loader = loaderElement[0].className.replace(" ",".");
    var statusElement = element.parent().siblings('.reqStatus');
    var status = statusElement[0].className.replace(" ",".");

    runAdminResponse(response, element, statusElement, status, loader);

});
$('.popup.singleViewRequest a.singleviewApproved').on("click",function(e){
    e.preventDefault();

    var element = $(this);
    var response = 'approved';

     //compose
    var loaderElement = element.siblings('img');
    var loader = loaderElement[0].className.replace(" ",".");
    
    var getSymLink = element.parents('.popup.singleViewRequest').siblings('a.approved');
    var statusElement = getSymLink.parent().siblings('.reqStatus');
    var status = statusElement[0].className.replace(" ",".");

    runAdminResponse(response, element, statusElement, status, loader);

});
//DISAPPROVED  submit
$('table.requestview tr td.action a.disapproved').on("click",function(e){
    e.preventDefault();
    var element = $(this);
    var response = element.attr('class');

    //compose
    var loaderElement = element.siblings('img');
    var loader = loaderElement[0].className.replace(" ",".");
    var statusElement = element.parent().siblings('.reqStatus');
    var status = statusElement[0].className.replace(" ",".");

    runAdminResponse(response, element, statusElement, status, loader);
});
$('.popup.singleViewRequest a.singleviewDisapproved').on("click",function(e){
    e.preventDefault();

    var element = $(this);
    var response = 'disapproved';

     //compose
    var loaderElement = element.siblings('img');
    var loader = loaderElement[0].className.replace(" ",".");
    
    var getSymLink = element.parents('.popup.singleViewRequest').siblings('a.disapproved');
    var statusElement = getSymLink.parent().siblings('.reqStatus');
    var status = statusElement[0].className.replace(" ",".");

    runAdminResponse(response, element, statusElement, status, loader);

});
function runAdminResponse(_response, _element, statusElement, status, loader){
    //initialize
    status = $("."+status);
    loader = $("."+loader);

    loader.show();

    var doctrineFilePath = '/conf/doctrine/request.repositoryManager.php';
    var data = { 
        0 : {'name': 'id','value': _element.data('id')},
        1 : {'name': 'table','value': _element.data('table')},
        3 : {'name': 'toProcess','value': _response},
        4 : {'name': 'user_id','value': _element.data('uid')}
    };
    $.ajax({
        url: baseUriDomain+doctrineFilePath,
        type: 'GET',
        data: {requestData: data},
        dataType: 'json',
        success: function(response){
            getLastStatus = statusElement.find('h6').html();

            loader.hide();

            if(_response == "approved" && response[2].approved_request == true) {
                status.html("<h6 class='label label-primary'>Approved</h6>"); 
            }else if(_response == "disapproved" && response[3].disapproved_request == true){
                status.html("<h6 class='label label-danger'>Disappoved</h6>"); 
            }else{
                console.log("Something did not work properly");
            }

            if(getLastStatus == "New"){
                notificationCount = notificationCount - 1;
                if(notificationCount < 1){
                    _notification.hide();
                }
                _notification.html(notificationCount);
            }
        }
    });
}
/* DONE APPROVED OR DISAPPROVED */

/// EMPLOYEE
//sidebar
$('.navEmpDashPage').on("click", function(e){ e.preventDefault(); processNavigationOnClick(this); });
$('.navReq').on("click", function(e){ e.preventDefault(); processNavigationOnClick(this); });
$('.navMessages').on("click", function(e){ e.preventDefault(); processNavigationOnClick(this); });
$('.navNoti').on("click", function(e){ e.preventDefault(); processNavigationOnClick(this); });
$('.navMyAccount').on("click", function(e){ e.preventDefault(); processNavigationOnClick(this); });

// $('.navRequirements').on("click", function(e){ e.preventDefault(); processNavigationOnClick(this); });
// $('.navReports').on("click", function(e){ e.preventDefault(); processNavigationOnClick(this); });

//tab menu
$('.usersWithReqTabMenu').on("click", function(e){ e.preventDefault(); tabMenus(this); });
$('.createMessageRequirementsTabMenu').on("click", function(e){ e.preventDefault(); tabMenus(this); });

$('.overTimeTabMenu').on("click", function(e){ e.preventDefault(); tabMenus(this); });
$('.leaveTabMenu').on("click", function(e){ e.preventDefault(); tabMenus(this); });
$('.requestResponseTabMenu').on("click", function(e){ e.preventDefault(); tabMenus(this); });

$('.notificationListTabMenu').on("click", function(e){ e.preventDefault(); tabMenus(this); });
$('.createMessageNotificationTabMenu').on("click", function(e){ e.preventDefault(); tabMenus(this); });
$('.fileOttoEmpTabMenu').on("click", function(e){ e.preventDefault(); tabMenus(this); });
$('.requestListTabMenu').on("click", function(e){ e.preventDefault(); tabMenus(this); });

function tabMenus(element){
    var menuClass = [
               "usersWithReqTabMenu", "createMessageRequirementsTabMenu", //requirements
               "overTimeTabMenu", "leaveTabMenu", "requestResponseTabMenu", //request
               // this field is reserve for uer
                "notificationListTabMenu", "createMessageNotificationTabMenu", //notification
                //  this is for reports
                //  this is for account
                /*some tab menu on admin */
                 "requestListTabMenu", "fileOttoEmpTabMenu"
            ];
    var tabMenuPages = [
                "usersWithRequirementsContainer", "createMessageRequirementsContainer",
                "overTimeContainer", "leaveContainer", "responseContainer",
               // this field is reserve for user
                "notificationListContainer", "createMessageNotificationContainer",
                // this is for reports
                //  this is for account
                "requestListContainer", "fileOttoEmpContainer"

            ];

    var _convertToArrayElement = $(element);
    var getClassName = _convertToArrayElement[0]['className'];

    var getIndex = menuClass.indexOf(getClassName);

    for (i = 0; i < tabMenuPages.length; i++) {
        if(i == getIndex){
            $('span.breadCrumd').html(getClassName); 
            $('#'+tabMenuPages[i]).show(); 
            $('#'+tabMenuPages[i]).addClass('in active');

            $('#'+tabMenuPages[i]).siblings().hide();
            $('#'+tabMenuPages[i]).siblings().removeClass('in active');
        }
        // }else{
        //       $('#'+tabMenuPages[i]).hide();
        //     $('#'+tabMenuPages[i]).removeClass('in active');
        // }
        // if(i != getIndex){
        //     $('#'+tabMenuPages[i]).hide();
        //     // console.log("hide pages : "+tabMenuPages[i]);
        //     // $('#'+tabMenuPages[i]).removeClass('in active');
        // }else{
        //      $('span.breadCrumd').html(getClassName); 
        //      // $('#'+tabMenuPages[i]).addClass('in active');
        //      $('#'+tabMenuPages[i]).show(); 
        //     console.log("show menu pages : "+tabMenuPages[i]);
        // }
    }
     for (i = 0; i < menuClass.length; i++) { 
         if(menuClass[i] == getClassName){
                $('.'+menuClass[i]).addClass("in active");  
                $('.'+menuClass[i]).siblings().removeClass("in active");  
         }
         // if(menuClass[i] != getClassName){
         //       $('.'+menuClass[i]).removeClass("in active");  
         // }else{
         //    $('.'+menuClass[i]).addClass("in active");  
         // }
    }
}
function processNavigationOnClick(element) {
    console.log(element);
    var clickElements = [
            "navEmpDashPage", "navReq", "navMessages", 
            "navNoti", "navMyAccount"
        ];
    var pageContainer = [
            "dashboardContainer", "requestContainer", "messagesContainer",
            "notificationContainer", "myAccountContainer"
        ];

    var _convertToArrayElement = $(element);
    var getClassName = _convertToArrayElement[0]['className'];

    var getIndex = clickElements.indexOf(getClassName);
    // var checkIfExist = (getIndex != -1) ? true : false ;

    for (i = 0; i < pageContainer.length; i++) {
        // if(i == getIndex){
        //      $('.'+pageContainer[i]).show();
        //      $('.'+pageContainer[i]).siblings().hide();
        // }
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
$('.navAdminDashPage').on("click", function(e){ e.preventDefault(); processAdminNavigationOnClick(this); });
$('.navAdminRequirements').on("click", function(e){ e.preventDefault(); processAdminNavigationOnClick(this); });
$('.navAdminReq').on("click", function(e){ e.preventDefault(); processAdminNavigationOnClick(this); });
$('.navAdminUsers').on("click", function(e){ e.preventDefault(); processAdminNavigationOnClick(this); });
$('.navAdminNoti').on("click", function(e){ e.preventDefault(); processAdminNavigationOnClick(this); });
$('.navAdminReports').on("click", function(e){ e.preventDefault(); processAdminNavigationOnClick(this); });
$('.navAdminMyAccount').on("click", function(e){ e.preventDefault(); processAdminNavigationOnClick(this); });

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
console.log("class name : "+getClassName);
// console.log(getIndex);
    var getIndex = clickElements.indexOf(getClassName);
    // var checkIfExist = (getIndex != -1) ? true : false ;

    for (i = 0; i < pageContainer.length; i++) {   
        if(i != getIndex){
            $('.'+pageContainer[i]).hide();
            console.log("hide page : "+pageContainer[i]);
        }else{
            $('.'+pageContainer[i]).show(); console.log("show page : "+pageContainer[i]);
        } 
    }
    for (i = 0; i < clickElements.length; i++) { 
         if(clickElements[i] != getClassName){
               $('.'+clickElements[i]).removeClass("active");  
         }else{
            $('.'+clickElements[i]).addClass("active");  
         } 
    }
}
// //custom
 var tab_empOT = $('li.overTimeTabMenu');
    tab_empOT.on("click", function(e){
        $(this).siblings().removeClass("in active");
        $(this).addClass("in active");
          $('div#overTimeContainer').addClass("in active"); 
          $('div#overTimeContainer').siblings().removeClass("in active"); 
          $('div#overTimeContainer').show(); 
    });
 var tab_empLeave = $('li.leaveTabMenu');
    tab_empLeave.on("click", function(e){
        $(this).siblings().removeClass("in active");
        $(this).addClass("in active");
          $('div#leaveContainer').addClass("in active"); 
          $('div#leaveContainer').siblings().removeClass("in active"); 
          $('div#leaveContainer').show(); 
    });
//done


$('#accountedit-form').on('submit',function(e){
     e.preventDefault(); 

    var loader = $('div.btn img.loader');
        loader.show();
        var formDataArray = $(this).serializeArray();
            data = ['accountEdit',formDataArray];

     $.ajax({
            url: baseUriDomain+'/conf/doctrine/user.crud_Interaction.php',
            type: 'GET',
            data: {userData: data},
            dataType: 'json',
            success: function(response){
                var _html;
                for(var data in response) {
                    if(response[data].user_accountsetting_update == true) {
                        loader.hide();
                        _html = '<div class="alert alert-success" style ="font-size: 14px;padding: 10px;" role="alert">Your account was successfully updated!</div>';
                        $('.details .message').html(_html);
                    }else{
                         _html = '<div class="alert alert-warning" style ="font-size: 14px;padding: 10px;" role="alert">Updating your account failed!</div>';
                        $('.details .message').html(_html);
                        loader.hide();
                    }
                }
            }
        });

});
﻿
﻿//change pass link
$('a.changepass-show-link').on('click', function(e){
    e.preventDefault();
 $( ".changepass-show" ).toggle();
});

