<?php
    require('config.php');
    $strUserSessionID = $_GET['strUserSessionID'];
    $strUserSessionID = strip_tags($strUserSessionID);
  
    echo getObservationDataBySessionID($strUserSessionID);
?>