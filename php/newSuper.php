<?php
    require('config.php');
    $strUserSessionID = $_POST['strUserSessionID'];
    $intSuperMatch = $_POST['intSuperMatch'];
    $strSuperNotes = $_POST['strSuperNotes'];
    
    $strUserSessionID = strip_tags($strUserSessionID);
    $intSuperMatch = strip_tags($intSuperMatch);
    $strSuperNotes = strip_tags($strSuperNotes);
    
    echo addSuper($strUserSessionID,$intSuperMatch,$strSuperNotes);

?>