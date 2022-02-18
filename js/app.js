$(document).ready( function () {
    /*$('.tblData').DataTable({
          buttons: ['pageLength','colvis','copy','csv','excel','pdf','print']
    }); */

    
  });
  
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
      $.post('../php/newUser.php', {
          strTeamCode:$('#txtAccessCode').val(),
          strFirstName:$('#txtFirstName').val(),
          strLastName:$('#txtLastName').val(),
          strUserName:$('#txtEmail').val(),
          strPassword:$('#txtPassword').val(),
      },
      function(){
  
      });
  });
  
  $(document).on('click','#btnSubmitObservation', function() {
      let blnAutoTarmacTaxi = $("input:checkbox[id=autoTaxiYes]")[0].checked;;
      
      let blnTeleOpShootsBalls = $("input:checkbox[id=teleRobotShootOpposite]")[0].checked;
      
      let blnTeleOpPlaysDefense = $("input:checkbox[id=teleRobotShootOpposite]")[0].checked;
     
      let blnMoreQuintet = $("input:checkbox[id=moreQuintetInAuto]")[0].checked;
      
      let blnMoreThan16 = $("input:checkbox[id=more16ClimbPts]")[0].checked;
      
      let blnMoreWin = $("input:checkbox[id=moreWinMatch]")[0].checked;
      
      
      $.post('../php/newObservation.php', {
          strUserSessionID:sessionStorage.getItem('ScoutFRCSessionID'),
          intMatch:$('#txtMatchNumber').val(),
          intTeamScouting:$('#txtTeamNumScouting').val(),
          strScoutingPosition:$('#dpdwTeamPosition').val(),
          strTarmacStartingPosition:$('input[name=radTarmacPlace]:checked').val(),
          blnAutoTarmacTaxi:blnAutoTarmacTaxi,
          intAutoUpperHub:$('#txtAutoBallsInUpper').val(),
          intAutoLowerHub:$('#txtAutoBallsInLower').val(),
          intTeleOpUpperHub:$('#txtTeleBallsInUpper').val(),
          intTeleOpLowerHub:$('#txtTeleBallsInLower').val(),
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
                    title: 'Super observation recorded',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    $('#txtMatchNumber').val('');
                    $('#txtTeamNumScouting').val('');
                    $('#dpdwTeamPosition').val('B1').trigger('change');
                    $("input:radio[name=radTarmacPlace]:checked")[0].checked = false;
                    $("input:checkbox[id=autoTaxiYes]:checked")[0].checked = false;
                    $('#txtAutoBallsInUpper').text('0');
                    $('#txtAutoBallsInLower').text('0');
                    $('#txtTeleBallsInUpper').text('0');
                    $('#txtTeleBallsInLower').text('0');
                    $("input:checkbox[id=teleRobotShootOpposite]:checked")[0].checked = false;
                    $("input:checkbox[id=teleRobotPlayDefense]:checked")[0].checked = false;
                    $("input:radio[name=radClimbing]:checked")[0].checked = false;
                    $("input:checkbox[id=moreQuintetInAuto]:checked")[0].checked = false;
                    $("input:checkbox[id=more16ClimbPts]:checked")[0].checked = false;
                    $("input:checkbox[id=moreWinMatch]:checked")[0].checked = false;
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

  $(document).on('click','#btnResetObservationForm', function() {
    $('#txtMatchNumber').val('');
    $('#txtTeamNumScouting').val('');
    $('#dpdwTeamPosition').val('B1').trigger('change');
    $("input:radio[name=radTarmacPlace]:checked")[0].checked = false;
    $("input:checkbox[id=autoTaxiYes]:checked")[0].checked = false;
    $('#txtAutoBallsInUpper').text('0');
    $('#txtAutoBallsInLower').text('0');
    $('#txtTeleBallsInUpper').text('0');
    $('#txtTeleBallsInLower').text('0');
    $("input:checkbox[id=teleRobotShootOpposite]:checked")[0].checked = false;
    $("input:checkbox[id=teleRobotPlayDefense]:checked")[0].checked = false;
    $("input:radio[name=radClimbing]:checked")[0].checked = false;
    $("input:checkbox[id=moreQuintetInAuto]:checked")[0].checked = false;
    $("input:checkbox[id=more16ClimbPts]:checked")[0].checked = false;
    $("input:checkbox[id=moreWinMatch]:checked")[0].checked = false;
})

  $(document).on('click','#btnSubmitPit', function() {
    let blnRobotHeightExtend;
    if($('#pitExtendYes:checked').val()){
        blnRobotHeightExtend = true;
    } else {
        blnRobotHeightExtend = false;
    }
    let blnOverBumper;
    if($('#pitOverBumper').val()){
        blnOverBumper = true;
    } else {
        blnOverBumper = false;
    }
    let blnThroughBumper;
    if($('#pitThroughBumper').val()){
        blnThroughBumper = true;
    } else {
        blnThroughBumper = false;
    }
    let blnIntakeExtendable;
    if($('#pitExtendable').val()){
        blnIntakeExtendable = true;
    } else {
        blnIntakeExtendable = false;
    }
    let blnIntakeInternal;
    if($('#pitInternal').val()){
        blnIntakeInternal = true;
    } else {
        blnIntakeInternal = false;
    }
    let blnHasShooter;
    if($('#pitHasShooterYes').val()){
        blnHasShooter = true;
    } else {
        blnHasShooter = false;
    }
    let blnUpperHab;
    if($('#pitUpperHab').val()){
        blnUpperHab = true;
    } else {
        blnUpperHab = false;
    }
    let blnLowerHab;
    if($('#pitLowerHab').val()){
        blnLowerHab = true;
    } else {
        blnLowerHab = false;
    }
    let blnTurret;
    if($('#pitTurretYes').val()){
        blnTurret = true;
    } else {
        blnTurret = false;
    }
    let blnLimeLight;
    if($('#pitLLYes').val()){
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
                    $("input:radio[name=pitRobotShape]:checked")[0].checked = false;
                    $('#pitRobotHeight').val('');
                    $("input:checkbox[id=swRobotHeightExtend]:checked")[0].checked = false;
                    $('#dpdwDriveTrainType').val('B1').trigger('change');
                    $('#txtPitBtnNumDriveMotors').text('0');
                    $('#txtPitBtnNumDriveWheels').text('0');
                    $('#dpdwWheelType').val('CH').trigger('change');
                    $('#dpdwMotorType').val('CH').trigger('change');
                    $("input:radio[name=pitRadBallCollection]:checked")[0].checked = false;
                    $("input:checkbox[id=swRobotIntakeExtend]:checked")[0].checked = false;
                    $("input:checkbox[id=swRobotIntakeThrough]:checked")[0].checked = false;
                    $("input:checkbox[id=swRobotIntakeOver]:checked")[0].checked = false;
                    $("input:checkbox[id=swRobotInternal]:checked")[0].checked = false;
                    $("input:checkbox[id=swHasShooter]:checked")[0].checked = false;
                    $('#dpdwShooterType').val('CH').trigger('change');
                    $("input:checkbox[id=swTurret]:checked")[0].checked = false;
                    $("input:checkbox[id=swLL]:checked")[0].checked = false;
                    $("input:radio[name=pitMaxBalls]:checked")[0].checked = false;
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
                    $("input:radio[name=pitRobotShape]:checked")[0].checked = false;
                    $('#pitRobotHeight').val('');
                    $("input:checkbox[id=swRobotHeightExtend]:checked")[0].checked = false;
                    $('#dpdwDriveTrainType').val('B1').trigger('change');
                    $('#txtPitBtnNumDriveMotors').text('0');
                    $('#txtPitBtnNumDriveWheels').text('0');
                    $('#dpdwWheelType').val('CH').trigger('change');
                    $('#dpdwMotorType').val('CH').trigger('change');
                    $("input:radio[name=pitRadBallCollection]:checked")[0].checked = false;
                    $("input:checkbox[id=swRobotIntakeExtend]:checked")[0].checked = false;
                    $("input:checkbox[id=swRobotIntakeThrough]:checked")[0].checked = false;
                    $("input:checkbox[id=swRobotIntakeOver]:checked")[0].checked = false;
                    $("input:checkbox[id=swRobotInternal]:checked")[0].checked = false;
                    $("input:checkbox[id=swHasShooter]:checked")[0].checked = false;
                    $('#dpdwShooterType').val('CH').trigger('change');
                    $("input:checkbox[id=swTurret]:checked")[0].checked = false;
                    $("input:checkbox[id=swLL]:checked")[0].checked = false;
                    $("input:radio[name=pitMaxBalls]:checked")[0].checked = false;
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