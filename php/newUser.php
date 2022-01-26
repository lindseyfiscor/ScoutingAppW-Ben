<?php
    require('config.php');
    
    $strUserName = $_POST['strUserName'];
    $strFirstName = $_POST['strFirstName'];
    $strLastName = $_POST['strLastName'];
    $strPassword = $_POST['strPassword'];
    $strTeamCode = $_POST['strTeamCode'];

    $strUserName = strip_tags($strUserName);
    $strFirstName = strip_tags($strFirstName);
    $strLastName = strip_tags($strLastName);
    $strPassword = strip_tags($strPassword);
    $strTeamCode = strip_tags($strTeamCode);
    echo newUserWithCode($strUserName,$strFirstName,$strLastName,$strPassword,$strTeamCode);
?>