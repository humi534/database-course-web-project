<?php
    // Connection to the database
    require_once 'dbconn.inc.php'; 

    // Display an aircraft's Details given its ID
    if(isset($_POST["details-button"])) {
        $id = $_POST["details-button"];

        header( "Location: ../details/aircrafts.details.php?id=$id");
        exit();
    }

    // Display all the aircrafts
    if(isset($_POST["see-all-button"])) {
        header( "Location: ../see_all/aircrafts.see_all.php");
        exit();
    }

    // Display selected aircrafts
    if(isset($_POST["select-search"])){
        $select_search = $_POST["select-search"];
        $contain_search = $_POST["contain-search"];

        header( "Location: ../see_all/aircrafts.see_all.php?select-search=$select_search&&contain-search=$contain_search" );
        
        exit(); 
    }
?>
