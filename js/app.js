$(document).ready( function () {
    /*$('.tblData').DataTable({
          buttons: ['pageLength','colvis','copy','csv','excel','pdf','print']
    }); */

    
});

function buildNavigation(){
    let arrRoles = [];
    $.getJSON('php/getUserRoles',{strUserSessionID:sessionStorage.getItem('ScoutFRCSessionID')}, function(result){
        $.each(result, function(i,role){
            if(role.Description.includes(',')){
                let arrTempRols = role.Description.split(',');
                $.each(arrTempRols, function(i,tempRole){
                    arrRoles.push(tempRole);  
                })
            } else {
                arrRoles.push(role.Description);  
            }
            
        })
        console.log(arrRoles);
        let strNavHTML = '';
        if(arrRoles.includes('Scouting')){
            strNavHTML += '<li class="nav-item" id="navHome"><a class="nav-link" href="index.html"><i class="fas fa-home mr-2"></i>Home</a></li>';
        }
        if(arrRoles.includes('Pit')){
            strNavHTML += '<li class="nav-item" id="navPit"><a class="nav-link" href="pit.html"><i class="fas fa-frog mr-2"></i>Pit Scouting</a></li>';
        }
        if(arrRoles.includes('Super')){
            strNavHTML += '<li class="nav-item" id="navSuper"><a class="nav-link" href="superScouting.html"><i class="fas fa-hippo mr-2"></i>Super Scouting</a></li>';
        }
        strNavHTML += '<li class="nav-item" id="navMatch"><a class="nav-link" href="dataAnalysis.html"><i class="fas fa-database mr-2"></i>Match Info</a></li>';
        strNavHTML += '<li class="nav-item" id="navTeam"><a class="nav-link" href="teamInfo.html"><i class="fas fa-robot mr-2"></i>Team Info</a></li>';
        strNavHTML += '<li class="nav-item" id="navPitData"><a class="nav-link" href="pitData.html"><i class="fas fa-tools mr-2"></i>Pit Data</a></li>';
        if(arrRoles.includes('Team Owner') || arrRoles.includes('Super Admin')){
            strNavHTML += '<li class="nav-item" id="navAdmin"><a class="nav-link" href="admin.html"><i class="fas fa-tools mr-2"></i>Admin</a></li>';
        }
        if(arrRoles.includes('Super Admin')){
            strNavHTML += '<li class="nav-item" id="navMgmt"><a class="nav-link" href="teams.html"><i class="fas fa-tools mr-2"></i>Team Mangement</a></li>';
        }
        strNavHTML += '<li class="nav-item float-right"><a class="nav-link" id="btnLogout"><i class="fas fa-sign-in-alt mr-2"></i>Logout</a></li>';
        $('#divNavbar').append(strNavHTML);

        let strLocation = window.location.pathname;
        if(strLocation == '/' || strLocation == '/index.html'){
            $('#navHome').addClass('active');
        } else if(strLocation == '/pit.html'){
            $('#navPit').addClass('active');
        } else if(strLocation == '/superScouting.html'){
            $('#navSuper').addClass('active');
        } else if(strLocation == '/dataAnalysis.html'){
            $('#navMatch').addClass('active');
        } else if(strLocation == '/teamInfo.html'){
            $('#navTeam').addClass('active');
        } else if(strLocation == '/navPitData.html'){
            $('#navPitData').addClass('active');
        } else if(strLocation == '/navAdmin.html'){
            $('#navAdmin').addClass('active');
        } else if(strLocation == '/navMgmt.html'){
            $('#navMgmt').addClass('active');
        }
    })
}
    
$(document).on('click','.btnEditTeam', function() {
let strTeamID = $(this).attr('data-teamid');
console.log(strTeamID);
})

$(document).on('click','#btnLogout', function() {
    Swal.fire({
        icon: 'warning',
        title: 'Logout?',
        text: 'Are you sure you want to logout?',
        showCancelButton: true,
        confirmButtonText: 'Yes'
    }).then((result) =>{
        sessionStorage.removeItem('ScoutFRCSessionID');
        if(result.isConfirmed){
            window.location.href ="login.html";
        }
    })
})

$(document).on('click','.btnPlus', function() {
    let intCurrentQty = parseInt($(this).siblings().find('.txtSum').text());
    if(intCurrentQty <= 100){
    intCurrentQty +=1;
    $(this).siblings().find('.txtSum').text(intCurrentQty);
}
})

$(document).on('click','.btnMinus', function() {
    let intCurrentQty = parseInt($(this).siblings().find('.txtSum').text());
    if(intCurrentQty >= 1){
        intCurrentQty -=1;
        $(this).siblings().find('.txtSum').text(intCurrentQty);
    }
})

$(document).on('click','#btnNewTeam', function() {
    Swal.fire({
        icon: 'question',
        title: "Are you sure you want to create a new team?",
        showConfirmButton: true,
        showCancelButton: true
    }).then((result)=> {
        if(result.isConfirmed){
        $.post('../php/newTeam.php', {
            strTeamName:$('#txtTeamName').val(),
            strTeamNumber:$('#txtTeamNumber').val(),
            strCity:$('#txtCity').val(),
            strZIP:$('#txtZIP').val(),
            strState:$('#txtState').val(),
            strNation:$('#txtNation').val(),
            strPhone:$('#txtPhone').val(),
            strFirstName:$('#txtFirstName').val(),
            strLastName:$('#txtLastName').val(),
            strEmail:$('#txtEmail').val(),
            strPassword:$('#txtPassword').val(),
        },function(result){
            let objResult = JSON.parse(result);
            if(objResult.Outcome == 'Error'){
                Swal.fire({
                    postion: 'top-end',
                    icon: 'error',
                    title: 'New Team Was Not Created',
                    showConfirmButton: false,
                    timer: 1500
                })
            }else {
                Swal.fire({
                postion: 'top-end',
                icon: 'success',
                title: 'New Team Created',
                showConfirmButton: false,
                timer: 1500
                }).then((result) => {
                window.location.href = 'login.html';
            }) 
            }
        })
    }
    })
});

$(document).on('click','#btnJoin', function() {
Swal.fire({
    icon: 'question',
    title: "Are you sure you want to create a new user?",
    showConfirmButton: true,
    showCancelButton: true
}).then((result)=> {
    if(result.isConfirmed){
        $.post('../php/newUser.php', {
            strTeamCode:$('#txtAccessCode').val(),
            strFirstName:$('#txtFirstName').val(),
            strLastName:$('#txtLastName').val(),
            strUserName:$('#txtEmail').val(),
            strPassword:$('#txtPassword').val(),
        },function(result){
        let objResult = JSON.parse(result);
        if(objResult.Outcome == 'Error'){
            Swal.fire({
                postion: 'top-end',
                icon: 'error',
                title: 'New User Was Not Created',
                showConfirmButton: false,
                timer: 1500
            })
        }else {
            Swal.fire({
                postion: 'top-end',
                icon: 'success',
                title: 'New User Created',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                window.location.href = 'login.html';
            }) 
        }
        })
    }
})
});

$(document).on('click','#btnSubmitObservation', function() {
    let blnAutoTarmacTaxi;
    if ($("#autoTaxiYes").prop("checked")) {
        blnAutoTarmacTaxi = "True";
    } else {
        blnAutoTarmacTaxi = "False";
    };
    
    let blnTeleOpShootsBalls;
    if ($("#teleRobotShootOpposite").prop("checked")) {
        blnTeleOpShootsBalls = "True";
    } else {
        blnTeleOpShootsBalls = "False";
    };
    
    let blnTeleOpPlaysDefense;
    if ($("#teleRobotPlayDefense").prop("checked")) {
        blnTeleOpPlaysDefense = "True";
    } else {
        blnTeleOpPlaysDefense = "False";
    };
    
    let blnMoreQuintet;
    if ($("#moreQuintetInAuto").prop("checked")) {
        blnMoreQuintet = "True";
    } else {
        blnMoreQuintet = "False";
    };
    
    let blnMoreThan16;
    if ($("#more16ClimbPts").prop("checked")) {
        blnMoreThan16 = "True";
    } else {
        blnMoreThan16 = "False";
    };
    
    let blnMoreWin;
    if ($("#moreWinMatch").prop("checked")) {
        blnMoreWin = "True";
    } else {
        blnMoreWin = "False";
    };
    
    
    $.post('../php/newObservation.php', {
        strUserSessionID:sessionStorage.getItem('ScoutFRCSessionID'),
        intMatch:$('#txtMatchNumber').val(),
        intTeamScouting:$('#txtTeamNumScouting').val(),
        strScoutingPosition:$('#dpdwTeamPosition').val(),
        strTarmacStartingPosition:$('input[name=radTarmacPlace]:checked').val(),
        blnAutoTarmacTaxi:blnAutoTarmacTaxi,
        intAutoUpperHub:$('#txtAutoBallsInUpper').text(),
        intAutoLowerHub:$('#txtAutoBallsInLower').text(),
        intTeleOpUpperHub:$('#txtTeleBallsInUpper').text(),
        intTeleOpLowerHub:$('#txtTeleBallsInLower').text(),
        blnTeleOpShootsBalls:blnTeleOpShootsBalls,
        blnTeleOpPlaysDefense:blnTeleOpPlaysDefense,
        strEndGameClimbing:$('input[name=radClimbing]:checked').val(),
        blnMoreQuintet:blnMoreQuintet,
        blnMoreThan16:blnMoreThan16,
        blnMoreWin:blnMoreWin
    }, function(result){
        let objResult = JSON.parse(result);
        if(objResult.Outcome != 'Error'){
            Swal.fire({
                postion: 'top-end',
                icon: 'success',
                title: 'Stand observation recorded',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                $('#txtMatchNumber').val('');
                $('#txtTeamNumScouting').val('');
                $("#autoTaxiYes").prop('checked',false);
                $('.custom-control-input').prop('checked',false)
                $('#txtAutoBallsInUpper').text('0');
                $('#txtAutoBallsInLower').text('0');
                $('#txtTeleBallsInUpper').text('0');
                $('#txtTeleBallsInLower').text('0');
                $("#teleRobotShootOpposite").prop('checked',false);
                $("#teleRobotPlayDefense").prop('checked',false);
                $("#radClimbing]").prop('checked',false);
                $("#moreQuintetInAuto").prop('checked',false);
                $("#more16ClimbPts").prop('checked',false);
                $("#moreWinMatch").prop('checked',false);
                $('#dpdwTeamPosition').val('B1').trigger('change');
            })
        }else {
            Swal.fire({
                icon: 'error',
                title: 'Stand not recorded',
                html: '<p>Please check your form and try again</p>'
            })
        }
    })
})

  $(document).on('click','#btnResetObservationForm', function() {
    $('#txtMatchNumber').val('');
    $('#txtTeamNumScouting').val('');
    $("#autoTaxiYes").prop('checked',false);
    $('.custom-control-input').prop('checked',false)
    $('#txtAutoBallsInUpper').text('0');
    $('#txtAutoBallsInLower').text('0');
    $('#txtTeleBallsInUpper').text('0');
    $('#txtTeleBallsInLower').text('0');
    $("#teleRobotShootOpposite").prop('checked',false);
    $("#teleRobotPlayDefense").prop('checked',false);
    $("#radClimbing]").prop('checked',false);
    $("#moreQuintetInAuto").prop('checked',false);
    $("#more16ClimbPts").prop('checked',false);
    $("#moreWinMatch").prop('checked',false);
    $('#dpdwTeamPosition').val('B1').trigger('change');
})

  $(document).on('click','#btnSubmitPit', function() {
    let blnRobotHeightExtend;
    if ($("#pitExtendYes").prop("checked")) {
        blnRobotHeightExtend = true;
    } else {
        blnRobotHeightExtend = false;
    }

    let blnOverBumper;
    if ($("#pitOverBumper").prop("checked")) {
        blnOverBumper = true;
    } else {
        blnOverBumper = false;
    }

    let blnThroughBumper;
    if ($("#pitThroughBumper").prop("checked")) {
        blnThroughBumper = true;
    } else {
        blnThroughBumper = false;
    }

    let blnIntakeExtendable;
    if ($("#pitExtendable").prop("checked")) {
        blnIntakeExtendable = true;
    } else {
        blnIntakeExtendable = false;
    }

    let blnIntakeInternal;
    if ($("#pitInternal").prop("checked")) {
        blnIntakeInternal = true;
    } else {
        blnIntakeInternal = false;
    }

    let blnHasShooter;
    if ($("#pitHasShooterYes").prop("checked")) {
        blnHasShooter = true;
    } else {
        blnHasShooter = false;
    }

    let blnUpperHab;
    if ($("#pitUpperHab").prop("checked")) {
        blnUpperHab = true;
    } else {
        blnUpperHab = false;
    }

    let blnLowerHab;
    if ($("#pitLowerHab").prop("checked")) {
        blnLowerHab = true;
    } else {
        blnLowerHab = false;
    }

    let blnTurret;
    if ($("#pitTurretYes").prop("checked")) {
        blnTurret = true;
    } else {
        blnTurret = false;
    }

    let blnLimeLight;
    if ($("#pitLLYes").prop("checked")) {
        blnLimeLight = true;
    } else {
        blnLimeLight = false;
    }
    $.post('../php/newPitCollect.php', {
        strUserSessionID:sessionStorage.getItem('ScoutFRCSessionID'),
        intPitTeamNum:$('#pitTeamNum').val(),
        strRobotShape:$('input[name=pitRobotShape]:checked').val(),
        intHeight:$("#pitRobotHeight").val(),
        blnRobotHeightExtend:blnRobotHeightExtend,
        strRobotDriveTrain:$('#dpdwDriveTrainType').val(),
        intDriveTrainMotors:$('#txtPitBtnNumDriveMotors').text(),
        intDriveTrainWheels:$('#txtPitBtnNumDriveWheels').text(),
        strDriveWheelType:$('#dpdwWheelType').val(),
        strDriveMotorType:$('#dpdwMotorType').val(),
        strBallCollection:$('input[name=pitRadBallCollection]:checked').val(),
        blnOverBumper:blnOverBumper,
        blnThroughBumper:blnThroughBumper,
        blnIntakeExtendable:blnIntakeExtendable,
        blnIntakeInternal:blnIntakeInternal,
        blnHasShooter:blnHasShooter,
        strShooterType:$('#dpdwShooterType').val(),
        blnTurret:blnTurret,
        blnLimeLight:blnLimeLight,
        strBallCapacity:$('input[name=pitMaxBalls]:checked').val(),
        strNotes:$('#pitTextBox').text()
    }, function(result){
        let objResult = JSON.parse(result);
        if(objResult.Outcome != 'Error'){
            Swal.fire({
                postion: 'top-end',
                icon: 'success',
                title: 'Pit observation recorded',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                    $('#pitTeamNum').val('');
                    $('.custom-control-input').prop('checked',false)
                    $('#pitRobotHeight').val('');
                    $("#swRobotHeightExtend").prop('checked',false);
                    $('#txtPitBtnNumDriveMotors').text('0');
                    $('#txtPitBtnNumDriveWheels').text('0');
                    $("#swRobotIntakeOver").prop('checked',false);
                    $("#swRobotIntakeThrough").prop('checked',false);
                    $("#swRobotIntakeExtend").prop('checked',false);
                    $("#swRobotInternal").prop('checked',false);
                    $("#swHasShooter").prop('checked',false);
                    $("#swTurret").prop('checked',false);
                    $("#swLL").prop('checked',false);
                    $('#dpdwDriveTrainType').val('CH').trigger('change');
                    $('#dpdwWheelType').val('CH').trigger('change');
                    $('#dpdwMotorType').val('CH').trigger('change');
                    $('#pitTextBox').val('');
            }) 
        }else {
            Swal.fire({
                icon: 'error',
                title: 'Pit observation not recorded',
                html: '<p>Please check your form and try again</p>'
            })
        }
    })
})

$(document).on('click','#btnResetPitForm', function() {
    $('#pitTeamNum').val('');
    $('.custom-control-input').prop('checked',false)
    $('#pitRobotHeight').val('');
    $("#swRobotHeightExtend").prop('checked',false);
    $('#txtPitBtnNumDriveMotors').text('0');
    $('#txtPitBtnNumDriveWheels').text('0');
    $("#swRobotIntakeOver").prop('checked',false);
    $("#swRobotIntakeThrough").prop('checked',false);
    $("#swRobotIntakeExtend").prop('checked',false);
    $("#swRobotInternal").prop('checked',false);
    $("#swHasShooter").prop('checked',false);
    $("#swTurret").prop('checked',false);
    $("#swLL").prop('checked',false);
    $('#dpdwDriveTrainType').val('CH').trigger('change');
    $('#dpdwWheelType').val('CH').trigger('change');
    $('#dpdwMotorType').val('CH').trigger('change');
    $('#pitTextBox').val('');
})

$(document).on('click','#btnSubmitSuperScout', function() {
    
    $.post('../php/newSuper.php', {
        strUserSessionID:sessionStorage.getItem('ScoutFRCSessionID'),
        intSuperMatch:$('#superMatchNumber').val(),
        strSuperNotes:$('#superTextBox').text()
    }, function(result){
        let objResult = JSON.parse(result);
        if(objResult.Outcome != 'Error'){
            Swal.fire({
                postion: 'top-end',
                icon: 'success',
                title: 'Super observation recorded',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                $('#superMatchNumber').val('');
                $('#superTextBox').text('');
            })
        }else {
            Swal.fire({
                icon: 'error',
                title: 'Super not recorded',
                html: '<p>Please check your form and try again</p>'
            })
        }
    })
})

$(document).on('click','#btnResetSuperForm', function() {
    $('#superMatchNumber').val('');
    $('#superTextBox').text('');
})  
  
$(document).on('click','#btnLogin', function() {
    $.post('../php/verifyUsernamePassword.php', {
        strTeamCode:$('#txtAccessCode').val(),
        strFirstName:$('#txtFirstName').val(),
        strLastName:$('#txtLastName').val(),
        strUserName:$('#txtEmail').val(),
        strPassword:$('#txtPassword').val(),
    },
    function(){

    });
});

$(document).on('click','#btnSignIn',function(){
    var objNewSessionResponse;
    let blnError = false;
    let strErrorMessage = '';
    if(!$('#txtEmail').val()){
        blnError = true;
        strErrorMessage += '<p>Email/Username is Blank</p>';
    }
    if(!$('#txtPassword').val()){
        blnError = true;
        strErrorMessage += '<p>Password is Blank</p>';
    }
    if(blnError == true){
        Swal.fire({
            icon: 'error',
            title: 'Missing Data',
            html: strErrorMessage
        })
    } else {
        var objNewSessionPromise = $.post('../php/newSession.php', { strUsername:$('#txtEmail').val(), strPassword: $('#txtPassword').val() }, function(result){
            objNewSessionResponse = JSON.parse(result);
        })
    }
    $.when(objNewSessionPromise).done(function() {
        if(objNewSessionResponse.Outcome == 'Login Failed'){
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                html: '<h3>Please review your username and password</h3>'
            }) 
        } else {
            sessionStorage.setItem('ScoutFRCSessionID',objNewSessionResponse.Outcome);
            window.location.replace('index.html');
        }
    })
})
  
$(document).on('click','.btn-more-match-info',function(){
    let strObservationID = $(this).attr('data-observationid');
    $.each(arrObjObservation,function(i,observation){
        if(observation.ObservationID == strObservationID){
            $('#txtModObservationDetailsMatch').text(observation.Match);
            $('#txtModObservationDetailsWin').text(observation.MoreWin);
            if(observation.MoreWin == "true") {
                $('#txtModObservationDetailsWin').addClass('text-danger');
                $('#txtModObservationDetailsWin').addClass('text-success');
            } else {
                $('#txtModObservationDetailsWin').addClass('text-success');
                $('#txtModObservationDetailsWin').addClass('text-danger');
            }
            $('#txtModObservationTeam').text(observation.TeamScouting);
            //$('#txtModObservationDetailsRankingPoints').text(observation.Match);
            $('#txtModObservationDetailsDriverPosition').text(observation.ScoutingPosition);
            $('#txtModObservationDetailsTarmacPosition').text(observation.TarmacStartingPosition);
            $('#txtModObservationDetailsClimbing').text(observation.EndGameClimbing);
            $('#txtModObservationDetailsQuintet').text(observation.MoreQuintet);
            $('#txtModObservationDetailsTaxi').text(observation.AutoTarmacTaxi);
            $('#txtModObservationDetailsAutoUpperHub').text(observation.AutoUpperHub);
            $('#txtModObservationDetailsAutoLowerHub').text(observation.AutoLowerHub);
            $('#txtModObservationDetailsBalls').text(observation.TeleOpShootsBalls);
            $('#txtModObservationDetailsDefense').text(observation.TeleOpPlaysDefense);
            $('#txtModObservationDetailsTeleOpUpperHub').text(observation.TeleOpUpperHub);
            $('#txtModObservationDetailsTeleOpLowerHub').text(observation.TeleOpLowerHub);
            
        }
    })
    
})

$(document).on('click','.btnViewPitDetails',function(){
    let strTeamNumber = $(this).attr('data-teamnumber');
    console.log('You clicked Team Number: ' + strTeamNumber);
})

$(document).on('click','#btnTeamKey',function(){
$.getJSON('https://lindsey.swollenhippo.com/php/getTeamKey.php',{strUserSessionID:'2a2f2543-9e4d-41e0-856e-9a04556c8347'},function(result){
    if(result.length > 0){
        $.each(result, function(i,teamkey){
            Swal.fire({
                icon: 'info',
                title: 'Your TeamKey Is',
                html: '<h3>' + teamkey.TeamKey + '</h3>'
            })
            
        })
    }
})  

})

function fillRoles(){
    $.getJSON('../php/getUserRolesOptions.php',{strUserSessionID:sessionStorage.getItem('ScoutFRCSessionID')},function(result){
        $.each(result, function(i,role){
            $('#admRoles').append('<option value="' + role.RoleID + '">' + role.Description + '</option>');
        })
    })
}

$(document).on('click','#btnUpdateUser',function(){
    let strRole = $('#admRoles').val();
    let strAbleTo = $('#cboAbleToScout').val().join(',');
})

$(document).on('click','.btnEditUser',function(){
    let strEmail = $(this).attr('data-email');
    $('#spanEmail').text(strEmail);
})