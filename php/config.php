<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');

    $host_name = 'db5005740965.hosting-data.io';
    $database = 'dbs4830229';
    $user_name = 'dbu1555430';
    $password = 'Lifelonglearningisimportant01!';

    $conScouting = new mysqli($host_name, $user_name, $password, $database);

    echo 'This is an echo';

    function newTeam($strTeamName,$strStreetAddress,$strZIP,$strState,$strContactNumber,$strOwnerEmail,$strFirstName,$strLastName,$strPhone,$strPassword) {
        echo 'This is a test';
    }
?>