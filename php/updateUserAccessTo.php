<?php
    require('config.php');
    
    $Email = $_POST['strEmail'];
    $AccessTo = $_POST['strAccessTo'];
    $SessionID = $_POST['strSessionID'];

    $Email = strip_tags($Email);
    $AccessTo = strip_tags($AccessTo);
    $SessionID = strip_tags($SessionID);
    
    echo updateUserAccessTo($SessionID,$Email,$AccessTo);
?>