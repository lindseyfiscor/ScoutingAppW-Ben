<?php
    require('config.php');
    
    $Email = $_GET['strEmail'];
    $SessionID = $_GET['strSessionID'];

    $Email = strip_tags($Email);
    $SessionID = strip_tags($SessionID);
    
    echo getUserDetailsForAdmin($SessionID,$Email);
?>