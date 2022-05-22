<?php
    //Database handler method
    $serverName = "localhost";

    
    $dbUser = $_SERVER['DB_USER'];
    $dbPassword = $_SERVER['DB_PASS'];
    /*$dbName = "mschyns_".$_SERVER['DB_USER'];*/
    $dbName = "mschyns_s203800";

    /*
    $dbUser = "root";
    $dbPassword = "123";
    $dbName = "mschyns_s203800";
    */

    $conn = mysqli_connect($serverName, $dbUser, $dbPassword, $dbName);
    
    if (!$conn) {
        die ("Connection failed: " . mysqli_connect_error());
    }