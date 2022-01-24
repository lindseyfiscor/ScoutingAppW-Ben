<?php
    require('config.php');
    $strTeamName = $_GET['strTeamName'];
    $strTeamNumber = $_GET['strTeamNumber'];
    $strCity = $_GET['strCity'];
    $strZIP  = $_GET['strState'];
    $strState  = $_GET['strState'];
    $strNation  = $_GET['strNation'];
    $strPhone = $_GET['strPhone'];
    $strFirstName = $_GET['strFirstName'];
    $strLastName = $_GET['strLastName'];
    $strEmail = $_GET['strEmail'];
    $strPassword = $_GET['strPassword'];

    $strTeamName = strip_tags($strTeamName);
    $strTeamNumber = strip_tags($strTeamNumber);
    $strCity = strip_tags($strCity);
    $strZIP = strip_tags($strZIP);
    $strState = strip_tags($strState);
    $strNation = strip_tags($strNation);
    $strPhone = strip_tags($strPhone);
    $strFirstName = strip_tags($strFirstName);
    $strLastName = strip_tags($strLastName);
    $strEmail = strip_tags($strEmail);
    $strPassword = strip_tags($strPassword);
    
    echo newTeam($strTeamName,$TeamNumber,$strCity,$strZIP,$strState,$strNation,$strPhone,$strFirstName,$strLastName,$strEmail,$strPassword);
?>