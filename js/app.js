$(document).on('click','#btnLogout', function() {
    Swal.fire({
        icon: 'warning',
        title: 'Logout?',
        text: 'Are you sure you want to logout?',
        showCancelButton: true,
        confirmButtonText: 'Yes'
    }).then((result)=> {
        window.location.href ="login.html";
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