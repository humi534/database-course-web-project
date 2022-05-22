<?php
    include_once("./add_ons/header.php");
    include("./includes/dbconn.inc.php");
    include("./add_ons/sidebar.php");
    include_once("./add_ons/footer.php");

    header( "Location: ./activity_log_tables.php?");
    exit();
?>