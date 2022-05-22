<?php
    // Connection to the database
    require_once 'dbconn.inc.php'; 

    // Display a given ULD's details given its code
    if(isset($_POST["details-button"])) {
        $code = $_POST["details-button"];

        header( "Location: ../details/uld.details.php?code=$code");
        exit();
    }

    // Display all the ULDs
    if(isset($_POST["see-all-button"])) {
        header( "Location: ../see_all/uld.see_all.php");
        exit();
    }

    // Display selected ULDs
    if(isset($_POST["select-search"])){
        $select_search = $_POST["select-search"];
        $contain_search = $_POST["contain-search"];

        header( "Location: ../see_all/uld.see_all.php?select-search=$select_search&&contain-search=$contain_search" );
        
        exit(); 
    }
?>
