<?php
    // Connection to the database
    require_once 'dbconn.inc.php'; 

    // Display all the flights
    if(isset($_POST["see-all-button"])) {
        header( "Location: ../see_all/flights.see_all.php");
        exit();
    }

    // Display selected flights
    if(isset($_POST["select-search"])){
        $select_search = $_POST["select-search"];
        $contain_search = $_POST["contain-search"];

        header( "Location: ../see_all/flights.see_all.php?select-search=$select_search&&contain-search=$contain_search" );
        
        exit(); 
    }

    // Display a given flight's details given its ID
    if(isset($_POST["details-button"])) {
        $id = $_POST["details-button"];
        header( "Location: ../details/flights.details.php?id=$id");
        exit();
    }

    