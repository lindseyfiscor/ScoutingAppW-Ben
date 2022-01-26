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
        if(result.isConfirmed){
            window.location.href ="login.html";
        }
    })
})

$(document).on('click','.btnPlus', function() {
    let intCurrentQty = parseInt($(this).siblings().find('.txtSum').text());
    intCurrentQty +=1;
    $(this).siblings().find('.txtSum').text(intCurrentQty);
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

    });
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

$(document).on('click','#btnLogin', function() {
    $.post('../php/verifyUsernamePassword.php', {
        strTeamCode:$('#txtAccessCode').val(),
        strFirstName:$('#txtFirstName').val(),
        strLastName:$('#txtLastName').val(),
        $strUserName:$('#txtEmail').val(),
        strPassword:$('#txtPassword').val(),
    },
    function(){

    });
});