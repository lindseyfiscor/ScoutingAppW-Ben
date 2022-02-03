<?php
    require('config.php');
    $strUserSessionID = $_POST['strUserSessionID'];
    $intMatch = $_POST['intMatch'];
    $intTeamScouting = $_POST['txtTeamNumScouting'];
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

    $strTeamName = strip_tags($strUserSessionID);
    $intMatch = strip_tags($intMatch);
    $intTeamScouting = strip_tags();
    $strScoutingPosition = strip_tags();
    $strTarmacStartingPosition = strip_tags();
    $blnAutoTarmacTaxi = strip_tags();
    $intAutoUpperHub = strip_tags();
    $intAutoLowerHub = strip_tags();
    $intTeleOpUpperHub = strip_tags();
    $intTeleOpLowerHub = strip_tags();
    $blnTeleOpShootsBalls = strip_tags();
    $blnTeleOpPlaysDefense = strip_tags();
    $strEndGameClimbing = strip_tags();
    $blnMoreQuintet = strip_tags();
    $blnMoreThan16 = strip_tags();
    $blnMoreWin = strip_tags();
  
    echo addObservation($strUserSessionID,$intMatch,$intTeamScouting,$strScoutingPosition,$strTarmacStartingPosition,$blnAutoTarmacTaxi,$intAutoUpperHub,$intAutoLowerHub,$intTeleOpUpperHub,$intTeleOpLowerHub,$blnTeleOpShootsBalls,$blnTeleOpPlaysDefense,$strEndGameClimbing,$blnMoreQuintet,$blnMoreThan16,$blnMoreWin);
?>