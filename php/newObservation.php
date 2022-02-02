<?php
    require('config.php');
    $strUserSessionID = $_POST['strUserSessionID'];
    $intMatch = $_POST['intMatch'];

    $strTeamName = strip_tags($strUserSessionID);
    $intMatch = strip_tags($intMatch);
  
    echo addObservation($strUserSessionID,$intMatch,$intTeamScouting,$strScoutingPosition,$strTarmacStartingPosition,$blnAutoTarmacTaxi,$intAutoUpperHub,$intAutoLowerHub,$intTeleOpUpperHub,$intTeleOpLowerHub,$blnTeleOpShootsBalls,$blnTeleOpPlaysDefense,$strEndGameClimbing,$blnMoreQuintet,$blnMoreThan16,$blnMoreWin);
?>