<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');

    $host_name = 'db5005740965.hosting-data.io';
    $database = 'dbs4830229';
    $user_name = 'dbu1555430';
    $password = 'Lifelonglearningisimportant01!';

    $conScouting = new mysqli($host_name, $user_name, $password, $database);

    function newTeam($TeamName,$TeamNumber$StreetAddress,$ZIP,$State,$ContactNumber,$FirstName,$LastName,$Email){
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
        if(strlen($TeamNumber) < 1 || $TeamNumber == null || strlen($TeamNumber) > 4){
            $strErrorMessage = $strErrorMessage . 'TeamNumber must be passed to web service | ';
            $blnError = true;
        }
        if(strlen($StreetAddress) < 1 || $StreetAddress == null){
            $strErrorMessage = $strErrorMessage . 'Street Address must be passed to web service | ';
            $blnError = true;
        }
        if(strlen($ZIP) < 1|| $ZIP == null || strlen($ZIP) != 6){
            $strErrorMessage = $strErrorMessage . 'ZIP Code must be passed to web service | ';
            $blnError = true;
            //Do I need to check if have alpha characters?
        }
        if(strlen($State) < 1 || $State == null || strlen($State) > 2){
            $strErrorMessage = $strErrorMessage . 'State must be passed to web service and must be two digits long | ';
            $blnError = true;
        }
        if(strlen($ContactNumber) < 1 || $ContactNumber == null){
            $strErrorMessage = $strErrorMessage . 'Phone Number must be passed to web service with area code | ';
            $blnError = true;
            // What checks should I add here?
        }
        if(strlen($FirstName) < 1 || $FirstName == null){
            $strErrorMessage = $strErrorMessage . 'First Name must be passed to web service | ';
            $blnError = true;
        }
        if(strlen($LastName) < 1 || $LastName == null){
            $strErrorMessage = $strErrorMessage . 'Last Name must be passed to web service | ';
            $blnError = true;
        }
        if(strlen($Email) < 1 || $Email == null || ){
            $strErrorMessage = $strErrorMessage . 'Last Name must be passed to web service | ';
            $blnError = true;
            //need to parse the email and check the different parts
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
                 $statCustodial->bind_param('sssssssss', $strTeamID, $TeamName, $StreetAddress, $ZIP, $State, $ContactNumber, $Owner, $strStatus,$APIKey);
                 
                 if($statCustodial->execute()){
                    if(newUser($Owner,$FirstName,$LastName,$Phone,$strTeamID,$Password) == '{"Outcome":"New User Created"}'){
                        return '{"Outcome":"'.$strTeamID.'"}';
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