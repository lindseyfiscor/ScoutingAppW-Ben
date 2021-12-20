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

    function newUser($FirstName,$LastName,$Email,$ContactNumber,$Password){
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
        if(strlen($Phne) < 10 || $ContactNumber == null || isValidContactNumber($ContactNumber) == false){
            $strErrorMessage = $strErrorMessage . 'Team Contact Number must be passed to web service with area code | ';
            $blnError = true;
        } else {
            $ContactNumber = normalizeContactNumber($ContactNumber);
        }
        //do I do the password check in the same way or there a safer way to keep it more private with php stuff?
        global $conScouting;
        $strQuery = "INSERT INTO tblUsers VALUES (?,?,?,?,?,SYSDATE(),'NEW')";
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
		 $statScouting->bind_param('sssss', $FirstName, $LastName, $Email, $ContactNumber, $Password);
         if($statScouting->execute()){
            sendVerificationEmail($Email);
            return '{"Outcome":"New User Created"}';
         } else {
            return '{"Outcome":"Error"}';
         }

         // $result = $statCustodial->get_result();
         
         // echo json_encode(($result->fetch_assoc()));
         $statScouting->close();
    }

    function newTeam($TeamName,$TeamNumber,$StreetAddress,$ZIP,$State,$ContactNumber,$FirstName,$LastName,$Email,$Phone,$Password){
        $strErrorMessage = '';
        $blnError = false;
        $TeamName = trim($TeamName);
        $TeamNumber= trim($TeamNumber);
        $StreetAddress = trim($StreetAdress);
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
        if(strlen($StreetAddress) < 3 || $StreetAddress == null){
            $strErrorMessage = $strErrorMessage . 'Street Address must be passed to web service | ';
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

        //if(strlen($Phone) < 10 || $Phone == null || isValidContactNumber($Phone) == false){
        //    $strErrorMessage = $strErrorMessage . 'OwnerPhone Number must be passed to web service with area code | ';
        //    $blnError = true;
        //} else {
        //    $Phone = normalizeContactNumber($Phone);
        //}

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
            $strQuery = "INSERT INTO tblTeams VALUES (?,?,?,?,?,?,?,?,?,(SELECT TeamKey FROM tblTeamKeys WHERE TeamKey NOT IN (SELECT b.TeamKey FROM tblTeams b) LIMIT 1))";
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
              
                 $statCustodial = $conScouting->prepare($strQuery);

                 // Bind Parameters
                 $statCustodial->bind_param('sssssssss', $TeamName, $TeamNumber, $StreetAddress, $ZIP, $State, $ContactNumber, $FirstName, $LastName, $Email, $strStatus, $APIKey);
                 
                 if($statCustodial->execute()){
                    if(newUser($Owner,$FirstName,$LastName,$Phone,$TeamNumber,$Password) == '{"Outcome":"New User Created"}'){
                        return '{"Outcome":"'.$TeamNumber.'"}';
                    } else {
                        return '{"Outcome":"Error"}';
                    }
                    
                 } else {
                    return '{"Outcome":"Error"}';
                 }
        
                 // $result = $statCustodial->get_result();
                 
                 // echo json_encode(($result->fetch_assoc()));
                 $statCustodial->close();
            }
            catch (exception $ex) {
                var_dump($ex);
            }
        }
        
        
    }

    newTeam('','','','','','','','','','');

?>