<?php
    require('config.php');
    
    $strPassword = $_POST['strPassword'];
    $strSessionID = $_POST['strSessionID'];

    $strPassword = strip_tags($strPassword);
    $strSessionID = strip_tags($strSessionID);
    
    echo selfPasswordReset($strSessionID,$strPassword);
?>