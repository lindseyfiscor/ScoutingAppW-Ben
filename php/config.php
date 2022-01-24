<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');

    $host_name = 'db5005740965.hosting-data.io';
    $database = 'dbs4830229';
    $user_name = 'dbu1555430';
    $password = 'Lifelonglearningisimportant01!';

    $conScouting = new mysqli($host_name, $user_name, $password, $database);

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

    function newUserWithCode($Username,$FirstName,$LastName,$Password,$TeamCode){
        global $conScouting;
        $strQuery = "INSERT INTO tblUsers VALUES (?,?,?,?,(SELECT TeamID FROM tblTeams WHERE TeamKey = ? AND Status = 'ACTIVE'),'62C6E982-01B5-41B7-8395-7B2745A6B097')";
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
      
		 $statCustodial = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statCustodial->bind_param('sssss', $Username, $FirstName, $LastName, $Password, $TeamCode);
         if($statCustodial->execute()){
            sendVerificationEmail($Username);
            return '{"Outcome":"New User Created"}';
         } else {
            return '{"Outcome":"Error"}';
         }

         // $result = $statCustodial->get_result();
         
         // echo json_encode(($result->fetch_assoc()));
         $statCustodial->close();
    }

    function verifyUsernamePassword($strUsername,$strPassword){
        global $conScouting;
        $strQuery = "SELECT Email FROM tblUsers WHERE UPPER(Email) = UPPER(?) AND UserPassword= ? AND UserStatus = 'ACTIVE'";
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
      
		 $statCustodial = $conScouting->prepare($strQuery);
		 // Bind Parameters
		 $statCustodial->bind_param('ss', $strUsername, $strPassword);
         $statCustodial->execute();      
         $statCustodial->bind_result($strEmail);
         $statCustodial->fetch();
         $intRows = $statCustodial->num_rows;
         if($strEmail){
            return 'true';
         } else {
            return 'false';
         }
         
         $statCustodial->close();
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
        $strQuery = "INSERT INTO tblUsers VALUES (?,?,?,?,?,?";
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
                    if(newUser($FirstName,$LastName,$Owner,$Password,$TeamNumber,'C1692D0B-A418-47E2-BABC-A6BAF94384E4') == '{"Outcome":"New User Created"}'){
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
        $strQuery = "INSERT INTO tblCurrentSessions VALUES (?,?,SYSDATE(),SYSDATE(),(SELECT Team FROM tblUsers WHERE Email = ?),(SELECT InternalTeams.TeamID FROM tblUsers LEFT JOIN tblTeams ON tblUsers.Team = tblTeams.TeamID LEFT JOIN InternalTeams ON tblTeams.InternalTeamOwnership = InternalTeams.TeamID WHERE Email = ?))";
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
      
		 $statCustodial = $conScouting->prepare($strQuery);

		 // Bind Parameters
		 $statCustodial->bind_param('ssss', $strSessionID,$Username,$Username,$Username);
         if($statCustodial->execute()){
            return '{"Outcome":"'.$strSessionID.'"}';
         } else {
            return '{"Outcome":"Error"}';
         }

         // $result = $statCustodial->get_result();
         
         // echo json_encode(($result->fetch_assoc()));
         $statCustodial->close();
    }
?>