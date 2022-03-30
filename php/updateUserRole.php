<?php
    require('config.php');
    
    $Email = $_POST['strEmail'];
    $Role = $_POST['strRole'];
    $SessionID = $_POST['strSessionID'];

    $Email = strip_tags($Email);
    $Role = strip_tags($Role);
    $SessionID = strip_tags($SessionID);
    
    echo updateUserRoles($SessionID,$Email,$Role);
?>