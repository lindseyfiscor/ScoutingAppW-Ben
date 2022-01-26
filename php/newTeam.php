<?php
    require('config.php');
    $strTeamName = $_POST['strTeamName'];
    $strTeamNumber = $_POST['strTeamNumber'];
    $strCity = $_POST['strCity'];
    $strZIP  = $_POST['strZIP'];
    $strState  = $_POST['strState'];
    $strNation  = $_POST['strNation'];
    $strPhone = $_POST['strPhone'];
    $strFirstName = $_POST['strFirstName'];
    $strLastName = $_POST['strLastName'];
    $strEmail = $_POST['strEmail'];
    $strPassword = $_POST['strPassword'];

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
    



    echo newTeam($strTeamName,$strTeamNumber,$strCity,$strZIP,$strState,$strNation,$strPhone,$strFirstName,$strLastName,$strEmail,$strPassword);
?>