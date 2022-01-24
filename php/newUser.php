<?php
    require('config.php');
    
    $strUserName = $_GET['strUserName'];
    $strFirstName = $_GET['strFirstName'];
    $strLastName = $_GET['strLastName'];
    $strPhone = $_GET['strPhone'];
    $strPassword = $_GET['strPassword'];
    $strTeamCode = $_GET['strTeamCode'];

    $strUserName = strip_tags($strUserName);
    $strFirstName = strip_tags($strFirstName);
    $strLastName = strip_tags($strLastName);
    $strPhone = strip_tags($strPhone);
    $strPassword = strip_tags($strPassword);
    $strTeamCode = strip_tags($strTeamCode);

    echo newUserWithCode($strUserName,$strFirstName,$strLastName,$strPhone,$strPassword,$strTeamCode);
?>