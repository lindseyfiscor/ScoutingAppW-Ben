<?php
    require('config.php');
    $strUserSessionID = $_POST['strUserSessionID'];
    $intMatch = $_POST['intMatch'];
    $intTeamScouting = $_POST['intTeamScouting'];
    $strScoutingPosition = $_POST['strScoutingPosition'];
    $strTarmacStartingPosition = $_POST['strTarmacStartingPosition'];
    $blnAutoTarmacTaxi = $_POST['blnAutoTarmacTaxi'];
    $intAutoUpperHub = $_POST['intAutoUpperHub'];
    $intAutoLowerHub = $_POST['intAutoLowerHub'];
    $intTeleOpUpperHub = $_POST['intTeleOpUpperHub'];
    $intTeleOpLowerHub = $_POST['intTeleOpLowerHub'];
    $blnTeleOpShootsBalls = $_POST['blnTeleOpShootsBalls'];
    $blnTeleOpPlaysDefense = $_POST['blnTeleOpPlaysDefense'];
    $strEndGameClimbing = $_POST['strEndGameClimbing'];
    $blnMoreQuintet = $_POST['blnMoreQuintet'];
    $blnMoreThan16 = $_POST['blnMoreThan16'];
    $blnMoreWin = $_POST['blnMoreWin'];
    $intAutoMissed = $_POST['intAutoBallsMissed'];
    $intTeleMissed = $_POST['intTeleBallsMissed'];
    $blnAutoBallPickUp = $_POST['blnAutoBallPickUp'];

    $strUserSessionID = strip_tags($strUserSessionID);
    $intMatch = strip_tags($intMatch);
    $intTeamScouting = strip_tags($intTeamScouting);
    $strScoutingPosition = strip_tags($strScoutingPosition);
    $strTarmacStartingPosition = strip_tags($strTarmacStartingPosition);
    $blnAutoTarmacTaxi = strip_tags($blnAutoTarmacTaxi);
    $intAutoUpperHub = strip_tags($intAutoUpperHub);
    $intAutoLowerHub = strip_tags($intAutoLowerHub);
    $intTeleOpUpperHub = strip_tags($intTeleOpUpperHub);
    $intTeleOpLowerHub = strip_tags($intTeleOpLowerHub);
    $blnTeleOpShootsBalls = strip_tags($blnTeleOpShootsBalls);
    $blnTeleOpPlaysDefense = strip_tags($blnTeleOpPlaysDefense);
    $strEndGameClimbing = strip_tags($strEndGameClimbing);
    $blnMoreQuintet = strip_tags($blnMoreQuintet);
    $blnMoreThan16 = strip_tags($blnMoreThan16);
    $blnMoreWin = strip_tags($blnMoreWin);
    $intAutoMissed = strip_tags($intAutoMissed);
    $intTeleMissed = strip_tags($intTeleMissed);
    $blnAutoBallPickUp = strip_tags($blnAutoBallPickUp);
  
    echo addObservation($strUserSessionID,$intMatch,$intTeamScouting,$strScoutingPosition,$strTarmacStartingPosition,$blnAutoTarmacTaxi,$intAutoUpperHub,$intAutoLowerHub,$intTeleOpUpperHub,$intTeleOpLowerHub,$blnTeleOpShootsBalls,$blnTeleOpPlaysDefense,$strEndGameClimbing,$blnMoreQuintet,$blnMoreThan16,$blnMoreWin,$intAutoMissed,$intTeleMissed,$blnAutoBallPickUp);
?>