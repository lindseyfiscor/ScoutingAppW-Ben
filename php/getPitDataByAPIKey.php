<?php
    require('config.php');
    $strAPIKey = $_GET['strAPIKey'];
    $strAPIKey = strip_tags($strAPIKey);

    $strTeamCode = $_GET['strTeamCode'];
    $strTeamCode = strip_tags($strTeamCode);
  
    echo getPitDataByAPIKey($strAPIKey, $strTeamCode);
?>