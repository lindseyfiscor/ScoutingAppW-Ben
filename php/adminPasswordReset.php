<?php
    require('config.php');
    
    $Email = $_POST['strEmail'];
    $Password = $_POST['strPassword'];
    $SessionID = $_POST['strSessionID'];

    $Email = strip_tags($Email);
    $Password = strip_tags($Password);
    $SessionID = strip_tags($SessionID);
    
    echo adminPasswordReset($SessionID,$Password,$Email);
?>