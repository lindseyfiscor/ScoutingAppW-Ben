<?php
    require('config.php'); 
    $strUsername = $_GET['strUsername'];
    $strPassword = $_GET['strPassword'];

    $strUsername = strip_tags($strUsername);
    $strPassword = strip_tags($strPassword);
    
    if(verifyUsernamePassword($strUsername,$strPassword) == 'true'){
        echo createNewSession($strUsername);
    } else {
        echo '{"Outcome":"Login Failed"}';
    }  
?>