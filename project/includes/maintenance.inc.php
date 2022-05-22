<?php
    // Connection to the database
    require_once 'dbconn.inc.php'; 

    // Display all the maintenances
    if(isset($_POST["see-all-button"])) {
        header( "Location: ../see_all/maintenance.see_all.php");
        exit();
    }

    // Display selected maintenances
    if(isset($_POST["select-search"])){
        $select_search = $_POST["select-search"];
        $contain_search = $_POST["contain-search"];

        header( "Location: ../see_all/maintenance.see_all.php?select-search=$select_search&&contain-search=$contain_search" );
        
        exit(); 
    }
