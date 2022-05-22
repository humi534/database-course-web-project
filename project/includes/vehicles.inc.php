<?php
    // Connection to the database
    require_once 'dbconn.inc.php'; 

    // Display all the vehilces
    if(isset($_POST["see-all-button"])) {
        header( "Location: ../see_all/vehicles.see_all.php");
        exit();
    }

    // Display selected vehicles
    if(isset($_POST["select-search"])){
        $select_search = $_POST["select-search"];
        $contain_search = $_POST["contain-search"];

        header( "Location: ../see_all/vehicles.see_all.php?select-search=$select_search&&contain-search=$contain_search" );
        
        exit(); 
    }

    // Display a vehicle's details given its ID
    if(isset($_POST["details-button"])) {
        $immatriculation = $_POST["details-button"];
        header( "Location: ../details/vehicles.details.php?immatriculation=$immatriculation");
        exit();
    }

?>
