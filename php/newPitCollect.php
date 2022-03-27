'<?php
    require('config.php');
    $strUserSessionID = $_POST['strUserSessionID'];
    $intPitTeamNum = $_POST['intPitTeamNum'];
    $strRobotShape = $_POST['strRobotShape'];
    $intHeight = $_POST['intHeight'];
    $blnRobotHeightExtend = $_POST['blnRobotHeightExtend'];
    $strRobotDriveTrain = $_POST['strRobotDriveTrain'];
    $intDriveTrainMotors = $_POST['intDriveTrainMotors'];
    $intDriveTrainWheels = $_POST['intDriveTrainWheels'];
    $strDriveWheelType = $_POST['strDriveWheelType'];
    $strDriveMotorType = $_POST['strDriveMotorType'];
    $strBallCollection = $_POST['strBallCollection'];
    $blnOverBumper = $_POST['blnOverBumper'];
    $blnThroughBumper = $_POST['blnThroughBumper'];
    $blnIntakeExtendable = $_POST['blnIntakeExtendable'];
    $blnIntakeInternal = $_POST['blnIntakeInternal'];
    $blnHasShooter = $_POST['blnHasShooter'];
    $strShooterType = $_POST['strShooterType'];
    $blnTurret = $_POST['blnTurret'];
    $blnLimeLight = $_POST['blnLimeLight'];
    $strBallCapacity = $_POST['strBallCapacity'];
    $strNotes = $_POST['strNotes'];
    $strPitClimbing = $_POST['strPitClimbing'];


    $strUserSessionID = strip_tags($strUserSessionID);
    $intPitTeamNum = strip_tags($intPitTeamNum);
    $strRobotShape = strip_tags($strRobotShape);
    $intHeight = strip_tags($intHeight);
    $blnRobotHeightExtend = strip_tags($blnRobotHeightExtend);
    $strRobotDriveTrain = strip_tags($strRobotDriveTrain);
    $intDriveTrainMotors = strip_tags($intDriveTrainMotors);
    $intDriveTrainWheels = strip_tags($intDriveTrainWheels);
    $strDriveWheelType = strip_tags($strDriveWheelType);
    $strDriveMotorType = strip_tags($strDriveMotorType);
    $strBallCollection = strip_tags($strBallCollection);
    $blnOverBumper = strip_tags($blnOverBumper);
    $blnThroughBumper = strip_tags($blnThroughBumper);
    $blnIntakeExtendable = strip_tags($blnIntakeExtendable);
    $blnIntakeInternal = strip_tags($blnIntakeInternal);
    $blnHasShooter = strip_tags($blnHasShooter);
    $strShooterType = strip_tags($strShooterType);
    $blnTurret = strip_tags($blnTurret);
    $blnLimeLight = strip_tags($blnLimeLight);
    $strBallCapacity = strip_tags($strBallCapacity);
    $strNotes = strip_tags($strNotes);
    $strPitClimbing = strip_tags($strPitClimbing);

    echo addPitCollect($strUserSessionID,$intPitTeamNum,$strRobotShape,$intHeight,$blnRobotHeightExtend,$strRobotDriveTrain,$intDriveTrainMotors,$intDriveTrainWheels,$strDriveWheelType,$strDriveMotorType,$strBallCollection,$blnOverBumper,$blnThroughBumper,$blnIntakeExtendable,$blnIntakeInternal,$blnHasShooter,$blnUpperHab,$blnLowerHab,$strShooterType,$blnTurret,$blnLimeLight,$strBallCapacity,$strNotes,$strPitClimbing);

?>