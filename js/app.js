$(document).ready( function () {
    /*$('.tblData').DataTable({
          buttons: ['pageLength','colvis','copy','csv','excel','pdf','print']
    }); */

    document.getElementById('txtPassword').addEventListener('keyup', function(event){
        if (event.keyCode === 13){
            event.preventDefault();
            $('#btnSignIn').click();
        }
    })
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
      console.log('btnNewTeam clicked');
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
      },
      function(){
        let objResult = JSON.parse(result);
        if(objResult.Outcome != 'Error'){
            Swal.fire({
                postion: 'top-end',
                icon: 'success',
                title: 'Pit observation recorded',
                showConfirmButton: false,
                timer: 1500
            }).then((result) => {
                $('#txtTeamName').val('');
                    $('#txtTeamNumber').val('');
                    $('#txtCity').val('');
                    $('#txtZIP').val('');
                    $('#txtState').val('');
                    $('#txtNation').val('');
                    $('#txtPhone').val('');
                    $('#txtFirstName').val('');
                    $('#txtLastName').val('');
                    $('#txtEmail').val('');
                    $('#txtPassword').val('');
            }) 
        }else {
            Swal.fire({
                icon: 'error',
                title: 'Pit observation not recorded',
                html: '<p>Please check your form and try again</p>'
            })
        }
    });
})
  
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
      let blnAutoTarmacTaxi;
      if($('#autoTaxiYes:checked').val()){
          blnAutoTarmacTaxi = true;
      } else {
          blnAutoTarmacTaxi = false;
      }
      let blnTeleOpShootsBalls;
      if($('#teleRobotShootOpposite').val()){
          blnTeleOpShootsBalls = true;
      } else {
          blnTeleOpShootsBalls = false;
      }
      let blnTeleOpPlaysDefense;
      if($('#teleRobotShootOpposite').val()){
          blnTeleOpPlaysDefense = true;
      } else {
          blnTeleOpPlaysDefense = false;
      }
      let blnMoreQuintet;
      if($('#moreQuintetInAuto').val()){
          blnMoreQuintet = true;
      } else {
          blnMoreQuintet = false;
      }
      let blnMoreThan16;
      if($('#more16ClimbPts').val()){
          blnMoreThan16 = true;
      } else {
          blnMoreThan16 = false;
      }
      let blnMoreWin;
      if($('#moreWinMatch').val()){
          blnMoreWin = true;
      } else {
          blnMoreWin = false;
      }
      
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
                    $('#autoTaxiYes').val('');
                    $('#txtAutoBallsInUpper').text('0');
                    $('#txtAutoBallsInLower').text('0');
                    $('#txtTeleBallsInUpper').text('0');
                    $('#txtTeleBallsInLower').text('0');
                    //boolean
                    //boolean
                    $("input:radio[name=radClimbing]:checked")[0].checked = false;
                    //boolean
                    //boolean
                    //boolean
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
                $('#superMatchNumber').val('');
                    $('#pitTeamNum').val('');
                    $('#pitRobotShape').val('');
                    $('#pitRobotHeight').val('');
                    //boolean
                    $('#dpdwDriveTrainType').val('');
                    $('#txtPitBtnNumDriveMotors').val('');
                    $('#txtPitBtnNumDriveWheels').val('');
                    $('#dpdwWheelType').val('');
                    $('#dpdwMotorType').val('');
                    $('#pitRadBallCollection').val('');
                    //boolean
                    //boolean
                    //boolean
                    //boolean
                    //boolean
                    $('#dpdwShooterType').val('');
                    //boolean
                    //boolean
                    $('#pitMaxBalls').val('');
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
  
  $(document).on('click','#btnResetObservationForm', function() {
    window.location.reload();
  
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