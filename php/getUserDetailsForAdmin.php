<?php
    require('config.php');
    
    $Email = $_POST['strEmail'];
    $SessionID = $_POST['strSessionID'];

    $Email = strip_tags($Email);
    $SessionID = strip_tags($SessionID);
    
    echo getUserDetailsForAdmin($SessionID,$Email);
?>