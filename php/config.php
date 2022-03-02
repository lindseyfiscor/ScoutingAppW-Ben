<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');

    $host_name = 'db5005740965.hosting-data.io';
    $database = 'dbs4830229';
    $user_name = 'dbu1555430';
    $password = 'Lifelonglearningisimportant01!';

    $conScouting = new mysqli($host_name, $user_name, $password, $database);

    function guidv4(){
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');

        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    function addObservation($strUserSessionID,$intMatch,$intTeamScouting,$strScoutingPosition,$strTarmacStartingPosition,$blnAutoTarmacTaxi,$intAutoUpperHub,$intAutoLowerHub,$intTeleOpUpperHub,$intTeleOpLowerHub,$blnTeleOpShootsBalls,$blnTeleOpPlaysDefense,$strEndGameClimbing,$blnMoreQuintet,$blnMoreThan16,$blnMoreWin,$intAutoMissed,$intTeleMissed,$blnAutoBallPickUp){
        try{
            global $conScouting;
            $strObservationID = guidv4();
            $strQuery = 'INSERT INTO tblObservations VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,(SELECT UserID FROM tblCurrentSessions WHERE SessionID = ?),SYSDATE(),?,?,?)';
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
        
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }

            $statScouting = $conScouting->prepare($strQuery);
            // Bind Parameters
            $statScouting->bind_param('ssssssssssssssssssss', $strObservationID,$intMatch,$intTeamScouting,$strScoutingPosition,$strTarmacStartingPosition,$blnAutoTarmacTaxi,$intAutoUpperHub,$intAutoLowerHub,$intTeleOpUpperHub,$intTeleOpLowerHub,$blnTeleOpShootsBalls,$blnTeleOpPlaysDefense,$strEndGameClimbing,$blnMoreQuintet,$blnMoreThan16,$blnMoreWin,$strUserSessionID,$intAutoMissed,$intTeleMissed,$blnAutoBallPickUp);
            if($statScouting->execute()){
                return '{"Outcome":"'.$strObservationID.'"}';
            } else {
                return '{"Outcome":"Error"}';
            }
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
    }

    function addPitCollect($strUserSessionID,$intPitTeamNum,$strRobotShape,$intHeight,$blnRobotHeightExtend,$strRobotDriveTrain,$intDriveTrainMotors,$intDriveTrainWheels,$strDriveWheelType,$strDriveMotorType,$strBallCollection,$blnOverBumper,$blnThroughBumper,$blnIntakeExtendable,$blnIntakeInternal,$blnHasShooter,$strShooterType,$blnTurret,$blnLimeLight,$strBallCapacity,$strNotes){
        try{
            global $conScouting;
            $strObservationID = guidv4(); //new to change strObservationID to strPitID?
            $strQuery = 'INSERT INTO tblPit VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,(SELECT UserID FROM tblCurrentSessions WHERE SessionID = ?),SYSDATE())';
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
        
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }

            $statScouting = $conScouting->prepare($strQuery);
            // Bind Parameters
            $statScouting->bind_param('ssssssssssssssssssssss', $strObservationID,$intPitTeamNum,$strRobotShape,$intHeight,$blnRobotHeightExtend,$strRobotDriveTrain,$intDriveTrainMotors,$intDriveTrainWheels,$strDriveWheelType,$strDriveMotorType,$strBallCollection,$blnOverBumper,$blnThroughBumper,$blnIntakeExtendable,$blnIntakeInternal,$blnHasShooter,$strShooterType,$blnTurret,$blnLimeLight,$strBallCapacity,$strNotes,$strUserSessionID);
            if($statScouting->execute()){
                return '{"Outcome":"'.$strObservationID.'"}';
            } else {
                return '{"Outcome":"Error"}';
            } 
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
    }

    function addSuper($strUserSessionID,$intSuperMatch,$strSuperNotes){
        try{
            global $conScouting;
            $strObservationID = guidv4();
            $strQuery = 'INSERT INTO tblSuper VALUES (?,?,?,(SELECT UserID FROM tblCurrentSessions WHERE SessionID = ?),SYSDATE())';
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
        
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }

            $statScouting = $conScouting->prepare($strQuery);
            // Bind Parameters
            $statScouting->bind_param('ssss', $strObservationID,$intSuperMatch,$strSuperNotes,$strUserSessionID);
            if($statScouting->execute()){
                return '{"Outcome":"'.$strObservationID.'"}';
            } else {
                return '{"Outcome":"Error"}';
            }
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
    }

    function deleteAllSuperRecords($strUserSessionID){
        try{
            global $conScouting;
            $strQuery = 'DELETE FROM tblSuper';
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
        
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }

            $statScouting = $conScouting->prepare($strQuery);
            // Bind Parameters
            if($statScouting->execute()){
                return '{"Outcome":"Records Deleted"}';
            } else {
                return '{"Outcome":"Error"}';
            }
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
    }

    function verifySession($strUserSessionID){
        global $conScouting;
        $strQuery = "SELECT SessionID FROM tblCurrentSessions WHERE SessionID = ? AND StartTime >= NOW() - INTERVAL 12 HOUR";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
        }
      
		 $statScouting = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statScouting->bind_param('s', $strUserSessionID);
         $statScouting->execute();      
         $statScouting->bind_result($strSessionID);
         $statScouting->fetch();
         $intRows = $statScouting->num_rows;
         if($strSessionID){
            return '{"Outcome":"Valid"}';
         } else {
            return '{"Outcome":"InValid"}';
         }
         // $result = $statScouting->get_result();
         
         // echo json_encode(($result->fetch_assoc()));
         $statScouting->close();
    }

    function getTeamPitData($strUserSessionID){
        global $conScouting;
        $strQuery = "SELECT * FROM tblPit WHERE EnterBy IN (SELECT Email FROM tblUsers WHERE Team = (SELECT TeamID FROM tblCurrentSessions WHERE SessionID = ?)) ORDER BY EntryDateTime DESC";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
        }
      
		 $statScouting = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statScouting->bind_param('s', $strUserSessionID);
         $statScouting->execute();      
         $result = $statScouting->get_result();
        $myArray = array();

        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $myArray[] = $row;
        }
        echo json_encode($myArray);
        
        $statScouting->close();
    }

    function getTeamKeyByUsername($strUsername){
        global $conScouting;
        $strQuery = "SELECT TeamKey FROM tblUsers LEFT JOIN tblTeams ON tblUsers.Team = tblTeams.TeamID WHERE Email = ?";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
		 $statScouting = $conScouting->prepare($strQuery);
		 // Bind Parameters
		 $statScouting->bind_param('s', $strUsername);
         $statScouting->execute();      
         $statScouting->bind_result($strTeamKey);
         $statScouting->fetch();
         if($strTeamKey){
            return '{"Outcome":"'.$strTeamKey.'"}';
         } else {
            return '{"Outcome":"Key Not Found"}';
         }
         
         $statScouting->close();
    }

    function getTeamObservations($strUserSessionID){
        global $conScouting;
        $strQuery = "SELECT * FROM tblObservations WHERE SubmittedBy IN (SELECT Email FROM tblUsers WHERE Team = (SELECT TeamID FROM tblCurrentSessions WHERE SessionID = ?)) ORDER BY tblObservations.Match, tblObservations.TeamScouting ASC";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
        }
      
		 $statScouting = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statScouting->bind_param('s', $strUserSessionID);
         $statScouting->execute();      
         $result = $statScouting->get_result();
        $myArray = array();

        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $myArray[] = $row;
        }
        echo json_encode($myArray);
        
        $statScouting->close();
    }

    function getTeamKey($strUserSessionID){
        global $conScouting;
        $strQuery = "SELECT TeamKey FROM tblTeams WHERE TeamID = (SELECT TeamID FROM tblCurrentSessions WHERE SessionID =?)";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
        }
      
		 $statScouting = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statScouting->bind_param('s', $strUserSessionID);
         $statScouting->execute();      
         $result = $statScouting->get_result();
        $myArray = array();

        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $myArray[] = $row;
        }
        echo json_encode($myArray);
        
        $statScouting->close();
    }
    
    function isValidContactNumber($ContactNumber){
        $minDigits = 10; 
        $maxDigits = 18;
        $count = 0;
        if (preg_match('/^[+][0-9]/', $ContactNumber)) { //is the first character + followed by a digit
            $count + 1;
            $ContactNumber = str_replace(['+'], '', $ContactNumber, $count); //remove +
        }
        
        //remove white space, dots, hyphens and brackets
        $ContactNumber = preg_replace('/[^0-9]/','',$ContactNumber);
        $count = $count + strlen($ContactNumber);
        if($count >= $minDigits && $count <= $maxDigits){
            return true;
        } else{
            return false;
        }
    }
    
    function normalizeContactNumber($ContactNumber) {
        //remove white space, dots, hyphens and brackets
        $ContactNumber = str_replace([' ', '.', '-', '(', ')'], '', $ContactNumber);
        return $ContactNumber;
    }

    function getTeamUsers($SessionID, $TeamID){
        try{
            global $conScouting;
            $strQuery = "SELECT Email, FirstName, LastName, Role FROM tblUsers WHERE Team = ?";
              // Check Connection
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
          
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }
          
             $statScouting = $conScouting->prepare($strQuery);
    
             // Bind Parameters
             $statScouting->bind_param('s', $TeamID);
             $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                     $myArray[] = $row;
             }
             echo json_encode($myArray);
                
             $statScouting->close();
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
        
    }

    function getTeamUsersForManagement($SessionID){
        try{
            global $conScouting;
            $strQuery = "SELECT tblUsers.Email, tblUsers.FirstName, tblUsers.LastName, tblRoles.Description  FROM tblUsers LEFT JOIN tblRoles ON tblUsers.Role = tblRoles.RoleID WHERE tblUsers.Team = (SELECT TeamID FROM tblCurrentSessions LEFT JOIN tblUsers ON tblCurrentSessions.UserID = tblUsers.Email LEFT JOIN tblRoles ON tblUsers.Role = tblRoles.RoleID WHERE SessionID = ? AND (tblRoles.Description = 'Team Owner' OR tblRoles.Description = 'Super Admin'))";
              // Check Connection
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
          
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }
          
             $statScouting = $conScouting->prepare($strQuery);
    
             // Bind Parameters
             $statScouting->bind_param('s', $SessionID);
             $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                     $myArray[] = $row;
             }
             echo json_encode($myArray);
                
             $statScouting->close();
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
        
    }

    function getUserRolesBySessionID($SessionID){
        try{
            global $conScouting;
            $strQuery = "SELECT tblRoles.Description FROM tblCurrentSessions LEFT JOIN tblUsers ON tblCurrentSessions.UserID = tblUsers.Email LEFT JOIN tblRoles ON tblUsers.Role = tblRoles.RoleID WHERE SessionID = ? UNION SELECT tblUsers.AccessTo AS Description FROM tblCurrentSessions LEFT JOIN tblUsers ON tblCurrentSessions.UserID = tblUsers.Email WHERE SessionID = ?";
              // Check Connection
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
          
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }
          
             $statScouting = $conScouting->prepare($strQuery);
    
             // Bind Parameters
             $statScouting->bind_param('ss', $SessionID, $SessionID);
             $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                     $myArray[] = $row;
             }
             echo json_encode($myArray);
                
             $statScouting->close();
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
        
    }


    function getUserAccessToBySessionID($SessionID){
        try{
            global $conScouting;
            $strQuery = "SELECT tblUsers.AccessTo FROM tblCurrentSessions LEFT JOIN tblUsers ON tblCurrentSessions.UserID = tblUsers.Email WHERE SessionID = ?";
              // Check Connection
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
          
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }
          
             $statScouting = $conScouting->prepare($strQuery);
    
             // Bind Parameters
             $statScouting->bind_param('s', $SessionID);
             $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                     $myArray[] = $row;
             }
             echo json_encode($myArray);
                
             $statScouting->close();
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
        
    }

    function verifyAccess($strUserSessionID,$strRoleID){
        global $conScouting;
        $strQuery = "SELECT * FROM tblUsers WHERE tblUsers.Role = ? AND tblUsers.Email = (SELECT UserID FROM tblCurrentSessions WHERE SessionID = ?)";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
        }
      
		 $statScouting = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statScouting->bind_param('ss', $strRoleID, $strUserSessionID);
         $statScouting->execute();    
         $statScouting->bind_result($strSessionID);
         $statScouting->fetch();
         $intRows = $statScouting->num_rows;
         if($strSessionID){
            return true;
         } else {
            return false;
         }
         // $result = $statScouting->get_result();
         
         // echo json_encode(($result->fetch_assoc()));
         $statScouting->close();
    }

    function getTeams($SessionID){
        if(verifyAccess($SessionID,'d8057ce3-048a-451b-b629-e627d48c2ab2') == false){
            return '{"Outcome":"No Access"}';
        } else {
            try{
                global $conScouting;
                $strQuery = "SELECT * FROM tblTeams LEFT JOIN tblUsers ON tblTeams.TeamID = tblUsers.Team WHERE tblUsers.Role = 'C1692D0B-A418-47E2-BABC-A6BAF94384E4'";
                  // Check Connection
                if ($conScouting->connect_errno) {
                    $blnError = "true";
                    $strErrorMessage = $conScouting->connect_error;
                    $arrError = array('error' => $strErrorMessage);
                    echo json_encode($arrError);
                    exit();
                }
              
                if ($conScouting->ping()) {
                } else {
                    $blnError = "true";
                    $strErrorMessage = $conScouting->error;
                    $arrError = array('error' => $strErrorMessage);
                    echo json_encode($arrError);
                }
              
                 $statScouting = $conScouting->prepare($strQuery);
        
                 // Bind Parameters
                 $statScouting->execute();      
                 $result = $statScouting->get_result();
                 $myArray = array();
        
                 while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                         $myArray[] = $row;
                 }
                 echo json_encode($myArray);
                    
                 $statScouting->close();
            } catch (exception $e) {
                echo 'Error: '.$e;
            }
        }
        
        
    }

    function getPitDataByAPIKey($strAPIKey, $strTeamCode){
        try{
            global $conScouting;
            $strQuery = "SELECT tblPit.* FROM tblPit LEFT JOIN tblUsers ON tblPit.EnterBy = tblUsers.Email WHERE EnterBy IN (SELECT Email FROM tblUsers WHERE Team = (SELECT TeamID FROM tblTeams WHERE TeamKey = ?)) AND ((SELECT COUNT(APIKey) FROM tblAPIKeys WHERE APIKey = ? AND TeamAccess = ?) > 0)";
              // Check Connection
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
          
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }
          
             $statScouting = $conScouting->prepare($strQuery);
    
             // Bind Parameters
             $statScouting->bind_param('sss', $strTeamCode, $strAPIKey, $strTeamCode);
             $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                     $myArray[] = $row;
             }
             echo json_encode($myArray);
                
             $statScouting->close();
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
    }

    function getSuperDataByAPIKey($strAPIKey, $strTeamCode){
        try{
            global $conScouting;
            $strQuery = "SELECT tblSuper.* FROM tblSuper LEFT JOIN tblUsers ON tblSuper.EnteredBy = tblUsers.Email WHERE EnteredBy IN (SELECT Email FROM tblUsers WHERE Team = (SELECT TeamID FROM tblTeams WHERE TeamKey = ?)) AND ((SELECT COUNT(APIKey) FROM tblAPIKeys WHERE APIKey = ? AND TeamAccess = ?) > 0)";
              // Check Connection
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
          
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }
          
             $statScouting = $conScouting->prepare($strQuery);
    
             // Bind Parameters
             $statScouting->bind_param('sss', $strTeamCode, $strAPIKey, $strTeamCode);
             $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                     $myArray[] = $row;
             }
             echo json_encode($myArray);
                
             $statScouting->close();
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
    }

    function getObservationDataByAPIKey($strAPIKey, $strTeamCode){
        try{
            global $conScouting;
            $strQuery = "SELECT tblObservations.* FROM tblObservations LEFT JOIN tblUsers ON tblObservations.SubmittedBy = tblUsers.Email WHERE SubmittedBy IN (SELECT Email FROM tblUsers WHERE Team = (SELECT TeamID FROM tblTeams WHERE TeamKey = ?)) AND ((SELECT COUNT(APIKey) FROM tblAPIKeys WHERE APIKey = ? AND TeamAccess = ?) > 0)";
              // Check Connection
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
          
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }
          
             $statScouting = $conScouting->prepare($strQuery);
    
             // Bind Parameters
             $statScouting->bind_param('sss', $strTeamCode, $strAPIKey, $strTeamCode);
             $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                     $myArray[] = $row;
             }
             echo json_encode($myArray);
                
             $statScouting->close();
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
    }

    function getPitDataBySessionID($strSessionID){
        try{
            global $conScouting;
            $strQuery = "SELECT tblPit.* FROM tblPit LEFT JOIN tblUsers ON tblPit.EnterBy = tblUsers.Email WHERE EnterBy IN (SELECT Email FROM tblUsers WHERE Team = (SELECT TeamID FROM tblCurrentSessions WHERE SessionID = ?)) AND (SELECT COUNT(Email) FROM tblUsers WHERE Email = (SELECT UserID FROM tblCurrentSessions WHERE SessionID = ?) AND Role != (SELECT RoleID FROM tblRoles WHERE Description = 'User' AND Status = '1')  > 0)";
              // Check Connection
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
          
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }
          
             $statScouting = $conScouting->prepare($strQuery);
    
             // Bind Parameters
             $statScouting->bind_param('ss', $strSessionID, $strSessionID);
             $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                     $myArray[] = $row;
             }
             echo json_encode($myArray);
                
             $statScouting->close();
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
    }

    function getSuperDataBySessionID($strSessionID){
        try{
            global $conScouting;
            $strQuery = "SELECT tblSuper.* FROM tblSuper LEFT JOIN tblUsers ON tblSuper.EnteredBy = tblUsers.Email WHERE EnteredBy IN (SELECT Email FROM tblUsers WHERE Team = (SELECT TeamID FROM tblCurrentSessions WHERE SessionID = ?)) AND (SELECT COUNT(Email) FROM tblUsers WHERE Email = (SELECT UserID FROM tblCurrentSessions WHERE SessionID = ?) AND Role != (SELECT RoleID FROM tblRoles WHERE Description = 'User' AND Status = '1')  > 0)";
              // Check Connection
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
          
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }
          
             $statScouting = $conScouting->prepare($strQuery);
    
             // Bind Parameters
             $statScouting->bind_param('ss', $strSessionID, $strSessionID);
             $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                     $myArray[] = $row;
             }
             echo json_encode($myArray);
                
             $statScouting->close();
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
    }

    function getObservationDataBySessionID($strSessionID){
        try{
            global $conScouting;
            $strQuery = "SELECT tblObservations.* FROM tblObservations LEFT JOIN tblUsers ON tblObservations.SubmittedBy = tblUsers.Email WHERE SubmittedBy IN (SELECT Email FROM tblUsers WHERE Team = (SELECT TeamID FROM tblCurrentSessions WHERE SessionID = ?)) AND (SELECT COUNT(Email) FROM tblUsers WHERE Email = (SELECT UserID FROM tblCurrentSessions WHERE SessionID = ?) AND Role != (SELECT RoleID FROM tblRoles WHERE Description = 'User' AND Status = '1')  > 0)";
              // Check Connection
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
          
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }
          
             $statScouting = $conScouting->prepare($strQuery);
    
             // Bind Parameters
             $statScouting->bind_param('ss', $strSessionID, $strSessionID);
             $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                     $myArray[] = $row;
             }
             echo json_encode($myArray);
                
             $statScouting->close();
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
    }

    function getUserRoles($SessionID){
        try{
            global $conScouting;
            $strQuery = "SELECT RoleID, Description, Status FROM tblRoles";
              // Check Connection
            if ($conScouting->connect_errno) {
                $blnError = "true";
                $strErrorMessage = $conScouting->connect_error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
                exit();
            }
          
            if ($conScouting->ping()) {
            } else {
                $blnError = "true";
                $strErrorMessage = $conScouting->error;
                $arrError = array('error' => $strErrorMessage);
                echo json_encode($arrError);
            }
          
             $statScouting = $conScouting->prepare($strQuery);
    
             // Bind Parameters
             $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                     $myArray[] = $row;
             }
             echo json_encode($myArray);
                
             $statScouting->close();
        } catch (exception $e) {
            echo 'Error: '.$e;
        }
        
    }
    
    function newUserWithCode($strUsername,$FirstName,$LastName,$Password,$TeamCode){
        global $conScouting;
        $strQuery = "INSERT INTO tblUsers VALUES (?,?,?,?,(SELECT TeamID FROM tblTeams WHERE TeamKey = ?),'62C6E982-01B5-41B7-8395-7B2745A6B097'),'Scouting'";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
        }
      
		 $statScouting = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statScouting->bind_param('sssss', $strUsername, $FirstName, $LastName, $Password, $TeamCode);
         if($statScouting->execute()){
            sendVerificationEmail($strUsername);
            return '{"Outcome":"New User Created"}';
         } else {
            return '{"Outcome":"Error"}';
         }

         // $result = $statScouting->get_result();
         
         // echo json_encode(($result->fetch_assoc()));
         $statScouting->close();
    }

    function verifyUsernamePassword($strUsername,$strPassword){
        global $conScouting;
        $strQuery = "SELECT Email FROM tblUsers WHERE UPPER(Email) = UPPER(?) AND UserPassword = ?";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
		 $statScouting = $conScouting->prepare($strQuery);
		 // Bind Parameters
		 $statScouting->bind_param('ss', $strUsername, $strPassword);
         $statScouting->execute();      
         $statScouting->bind_result($strEmail);
         $statScouting->fetch();
         $intRows = $statScouting->num_rows;
         if($strEmail){
            return 'true';
         } else {
            return 'false';
         }
         
         $statScouting->close();
    }

    function pullUserInfo($strUserSessionID,$Email){
        global $conScouting;
        $strQuery = "SELECT Email, FirstName, LastName, Role, Team, AccessTo FROM tblUsers WHERE UPPER(Email) = UPPER(?) AND Team = (SELECT TeamID FROM tblCurrentSessions WHERE SessionID = ?) AND ((SELECT COUNT(Email) FROM tblUsers WHERE (Role = 'C1692D0B-A418-47E2-BABC-A6BAF94384E4' OR Role = 'd8057ce3-048a-451b-b629-e627d48c2ab2') AND Email = (SELECT UserID FROM tblCurrentSessions WHERE SessionID = ? )) > 0)";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
		 $statScouting = $conScouting->prepare($strQuery);
		 // Bind Parameters
		 $statScouting->bind_param('sss', $Email, $strUserSessionID, $strUserSessionID);
         $statScouting->execute();      
             $result = $statScouting->get_result();
             $myArray = array();
    
             while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $myArray[] = $row;
        }
        echo json_encode($myArray);
         
        $statScouting->close();
    }

    function sendVerificationEmail($strEmailAddress){
        $emailTo = $strEmailAddress;
        $emailSubject = "Verify New Account for ScoutFRC";
        $emailHeaders = "MIME-Version: 1.0" . "\r\n";
        $emailHeaders = $emailHeaders . "Content-type:text/html;charset=UTF-8" . "\r\n";
        $emailHeaders = $emailHeaders . 'From: <AccountVerification@lindsey.swollenhippo.com>' . "\r\n";
        
        $message = "<!DOCTYPE html><html lang=\"en\" class=\"\"><head><!DOCTYPE html><html lang=\"en\" class=\"\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"><head>
        <title>Verify Account</title>
        </head><body>
        <div class=\"jumbotron\"><h1>Thank you for setting up an account</h1><p>Please click the link below to verify and activate your account. <br> <a href='http://lindsey.swollenhippo.com/verifyAccount.php?UserName=" . $emailTo . "'>http://lindsey.swollenhippo.com/verifyAccount.php?UserName=" . $emailTo . "</a></p></div>
        </body>
        </html>"; 
        
        mail($emailTo,$emailSubject,$message,$emailHeaders);
    }

    function newUser($FirstName,$LastName,$Email,$Password,$Team,$Role){
        if(strlen($FirstName) < 1 || $FirstName == null){
            $strErrorMessage = $strErrorMessage . 'First Name must be passed to web service | ';
            $blnError = true;
        }
        if(strlen($LastName) < 1 || $LastName == null){
            $strErrorMessage = $strErrorMessage . 'Lasr Name must be passed to web service | ';
            $blnError = true;
        }
        if(strlen($Email) < 1 || $Email == null || !filter_var($Email, FILTER_VALIDATE_EMAIL)){
            $strErrorMessage = $strErrorMessage . 'Email must be passed to web service | ';
            $blnError = true;
        }
        //do I do the password check in the same way or there a safer way to keep it more private with php stuff?
        global $conScouting;
        $strQuery = "INSERT INTO tblUsers VALUES (?,?,?,?,?,?,'Scouting')";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
        }
      
		 $statScouting = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statScouting->bind_param('ssssss', $Email, $FirstName, $LastName, $Password, $Team, $Role);
         if($statScouting->execute()){
            sendVerificationEmail($Email);
            return '{"Outcome":"New User Created"}';
         } else {
            return '{"Outcome":"Error"}';
         }

         // $result = $statScouting->get_result();
         
         // echo json_encode(($result->fetch_assoc()));
         $statScouting->close();
    }

    function updateUserRoles($Email,$Role){
        
        //do I do the password check in the same way or there a safer way to keep it more private with php stuff?
        global $conScouting;
        $strQuery = "UPDATE tblUsers SET Role = ? WHERE Email = ?";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
        }
      
		 $statScouting = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statScouting->bind_param('ss', $Role, $Email);
         if($statScouting->execute()){
            sendVerificationEmail($Email);
            return '{"Outcome":"User Updated"}';
         } else {
            return '{"Outcome":"Error"}';
         }

         // $result = $statScouting->get_result();
         
         // echo json_encode(($result->fetch_assoc()));
         $statScouting->close();
    }

    function updateUserAccessTo($Email,$AccessTo){
        
        //do I do the password check in the same way or there a safer way to keep it more private with php stuff?
        global $conScouting;
        $strQuery = "UPDATE tblUsers SET AccessTo = ? WHERE Email = ?";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
        }
      
		 $statScouting = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statScouting->bind_param('ss', $AccessTo, $Email);
         if($statScouting->execute()){
            sendVerificationEmail($Email);
            return '{"Outcome":"User Updated"}';
         } else {
            return '{"Outcome":"Error"}';
         }

         // $result = $statScouting->get_result();
         
         // echo json_encode(($result->fetch_assoc()));
         $statScouting->close();
    }

    function newTeam($TeamName,$TeamNumber,$City,$ZIP,$State,$Nation,$ContactNumber,$FirstName,$LastName,$Email,$Password){
        $strErrorMessage = '';
        $blnError = false;
        $TeamName = trim($TeamName);
        $TeamNumber= trim($TeamNumber);
        $City = trim($City);
        $ZIP = trim($ZIP);
        $State = trim($State);
        $ContactNumber = trim($ContactNumber);
        $FirstName = trim($FirstName);
        $LastName = trim($LastName);
        $Email = trim($Email);
        if(strlen($TeamName) < 1 || $TeamName == null){
            $strErrorMessage = $strErrorMessage . 'TeamName must be passed to web service | ';
            $blnError = true;
        }
        if(strlen($TeamNumber) != 4 || $TeamNumber == null || !is_numeric($TeamNumber)){
            $strErrorMessage = $strErrorMessage . 'TeamNumber must be a numeric value passed to web service with four characters | ';
            $blnError = true;
        }
        if(strlen($City) < 3 || $City == null){
            $strErrorMessage = $strErrorMessage . 'City must be passed to web service | ';
            $blnError = true;
        }
        if(strlen($ZIP) > 10 || strlen($ZIP) < 5  || $ZIP == null ){
            $strErrorMessage = $strErrorMessage . 'ZIP Code must be passed to web service and must be between 5 and 10 characters | ';
            $blnError = true; 
        }
        if(strlen($State) != 2 || $State == null){
            $strErrorMessage = $strErrorMessage . 'State must be passed to web service and must be two digits long | ';
            $blnError = true;
        }

        if(strlen($ContactNumber) < 10 || $ContactNumber == null || isValidContactNumber($ContactNumber) == false){
            $strErrorMessage = $strErrorMessage . 'Team Contact Number must be passed to web service with area code | ';
            $blnError = true;
        } else {
            $ContactNumber = normalizeContactNumber($ContactNumber);
        }

        if(strlen($FirstName) < 1 || $FirstName == null){
            $strErrorMessage = $strErrorMessage . 'First Name must be passed to web service | ';
            $blnError = true;
        }
        if(strlen($LastName) < 1 || $LastName == null){
            $strErrorMessage = $strErrorMessage . 'Last Name must be passed to web service | ';
            $blnError = true;
        }
        if(strlen($Email) < 1 || $Email == null || !filter_var($Email, FILTER_VALIDATE_EMAIL)){
            $strErrorMessage = $strErrorMessage . 'Email must be passed to web service | ';
            $blnError = true;
        }
        if(strlen($Password) < 1 ){
            $strErrorMessage = $strErrorMessage . 'Password must be passed to web service | ';
            $blnError = true;
        }
     

        if($blnError == true){
            echo '{"Outcome":"Error:'.$strErrorMessage.'"}';
            return '{"Outcome":"Error:'.$strErrorMessage.'"}';
        } else {
            global $conScouting;
            $strTeamID = guidv4();
            $strStatus = 'ACTIVE';
            $strQuery = "INSERT INTO tblTeams VALUES (?,?,?,?,?,?,?,?,(SELECT TeamKey FROM tblTeamKeys WHERE TeamKey NOT IN (SELECT b.TeamKey FROM tblTeams b) LIMIT 1))";
              // Check Connection
            try {
                if ($conScouting->connect_errno) {
                    $blnError = "true";
                    $strErrorMessage = $conScouting->connect_error;
                    $arrError = array('error' => $strErrorMessage);
                    echo json_encode($arrError);
                    exit();
                }
              
                if ($conScouting->ping()) {
                } else {
                    $blnError = "true";
                    $strErrorMessage = $conScouting->error;
                    $arrError = array('error' => $strErrorMessage);
                    echo json_encode($arrError);
                }
              
                 $statScouting = $conScouting->prepare($strQuery);

                 // Bind Parameters
                 $statScouting->bind_param('ssssssss', $strTeamID, $TeamName, $TeamNumber, $City, $State, $ZIP, $Nation, $ContactNumber);
                 
                 if($statScouting->execute()){
                    if(newUser($FirstName,$LastName,$Email,$Password,$strTeamID,'C1692D0B-A418-47E2-BABC-A6BAF94384E4') == '{"Outcome":"New User Created"}'){
                        return '{"Outcome":"'.$strTeamID.'"}';
                    } else {
                        return '{"Outcome":"Error Creating Team"}';
                    }
                    
                 } else {
                    return '{"Outcome":"Error Creating Team"}';
                 }
        
                 // $result = $statScouting->get_result();
                 
                 // echo json_encode(($result->fetch_assoc()));
                 $statScouting->close();
            }
            catch (exception $ex) {
                var_dump($ex);
            }
        }
        
        
    }

    function createNewSession($Username){
        global $conScouting;
        $strSessionID = guidv4();
        $strQuery = "INSERT INTO tblCurrentSessions VALUES (?,?,SYSDATE(),SYSDATE(),(SELECT Team FROM tblUsers WHERE Email = ?))";
      	// Check Connection
        if ($conScouting->connect_errno) {
            $blnError = "true";
            $strErrorMessage = $conScouting->connect_error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
            exit();
        }
      
        if ($conScouting->ping()) {
        } else {
            $blnError = "true";
            $strErrorMessage = $conScouting->error;
            $arrError = array('error' => $strErrorMessage);
            echo json_encode($arrError);
        }
      
		 $statScouting = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statScouting->bind_param('sss', $strSessionID,$Username,$Username);
         if($statScouting->execute()){
            return '{"Outcome":"'.$strSessionID.'"}';
         } else {
            return '{"Outcome":"Error"}';
         }

         // $result = $statScouting->get_result();
         
         // echo json_encode(($result->fetch_assoc()));
         $statScouting->close();
    }
?>