<?php
    require('config.php');
    
    $Email = $_POST['strEmail'];
    $FirstName = $_POST['strFirstName'];
    $LastName = $_POST['strLastName'];
    $AccessTo = $_POST['strAccessTo'];
    $Roles = $_POST['strRoles'];
    $SessionID = $_POST['strSessionID'];

    $Email = strip_tags($Email);
    $FirstName = strip_tags($FirstName);
    $LastName = strip_tags($LastName);
    $AccessTo = strip_tags($AccessTo);
    $Roles = strip_tags($Roles);
    $SessionID = strip_tags($SessionID);
    
    echo updateUserAdmin($Email,$FirstName, $LastName, $AccessTo, $Roles, $SessionID);
?>