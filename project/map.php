
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie-edge">
        <title>OpenStreetMap</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin=""/>

        <style>
            .map_specific-group, .map_general-group{
                display: flex;
            }

            .form_map_container{
                width: 40%;
            }

            .form_map_container form{
                padding-left: 20%;
                padding-top: 10%;
            }

            .map-container{
                width: 60%;
            }

            .map{
                width: 100%;
                height: 100vh;
            }

            .form_map_container legend{
                font-weight: bold;
            }
            
        </style>
    </head>
    <body>

        <?php
            include("includes/dbconn.inc.php");
 
            $month = date('m');
            $day = date('d');
            $year = date('Y');
            $today06 = $year . '-' . $month . '-' . $day. 'T06:00';
            $today = $year . '-' . $month . '-' . $day. 'T12:00';

            if(!isset($_GET["display"])){
                $_GET["display"] = "general";
            }

            if(!isset($_POST["datetime"])){
                $_POST["datetime"] = $today;
            }
            @$vehicle = $_POST["vehicle"];
        ?>

        
        <?php
        #______________________________________________________________________________________
        #------------------------------------GENERAL------------------------------------------
        #______________________________________________________________________________________
        
        if ($_GET["display"] == "general") {
        ?>
            <div class="map_general-group" id="map_general-group">
                <div class="form_map_container">
                    <form method="post" action="">
                        <legend>What do you want to display?</legend>
                        <br>
                        <legend>Vehicles</legend>
                        <input type="checkbox" name="vehicle[]" value="dolly" <?php if(@in_array("dolly", $vehicle)){echo("checked");} ?>>Dolly<br>
                        <input type="checkbox" name="vehicle[]" value="lavatory-service" <?php if(@in_array("lavatory-service",$vehicle)){echo("checked");} ?>>Lavatory service<br>
                        <input type="checkbox" name="vehicle[]" value="refueling" <?php if(@in_array("refueling",$vehicle)){echo("checked");} ?>>Refueling<br>
                        <input type="checkbox" name="vehicle[]" value="high loader" <?php if(@in_array("high loader",$vehicle)){echo("checked");} ?>>High loader<br>
                        <input type="checkbox" name="vehicle[]" value="push back" <?php if(@in_array("push back",$vehicle)){echo("checked");} ?>>Push back<br>
                        <input type="checkbox" name="vehicle[]" value="speed loader" <?php if(@in_array("speed loader",$vehicle)){echo("checked");} ?>>Speed loader<br>
                        <input type="checkbox" name="vehicle[]" value="main deck loader" <?php if(@in_array("main deck loader",$vehicle)){echo("checked");} ?>>Main deck loader<br>
                        <input type="checkbox" name="vehicle[]" value="GPU" <?php if(@in_array("GPU",$vehicle)){echo("checked");} ?>>GPU<br>
                        <input type="checkbox" name="vehicle[]" value="toilet car" <?php if(@in_array("toilet car",$vehicle)){echo("checked");} ?>>Toilet car<br>
                        <input type="checkbox" name="vehicle[]" value="fire truck" <?php if(@in_array("fire truck",$vehicle)){echo("checked");} ?>>Fire truck<br>
                        <input type="checkbox" name="vehicle[]" value="other" <?php if(@in_array("other",$vehicle)){echo("checked");} ?>>Other<br>
                        <br>
                        <legend>Aircraft</legend>
                        <input type="checkbox" name="vehicle[]" value="aircraft" <?php if(@in_array("aircraft",$vehicle)){echo("checked");} ?>>Aicraft<br>
                        <br>
                        <legend>ULDs</legend>
                        <input type="checkbox" name="vehicle[]" value="ULD" <?php if(@in_array("ULD",$vehicle)){echo("checked");} ?>>ULD<br>
                        <br><br>
                        
                        <label>Period: </label>
                        <input type="datetime-local" name="datetime" value="<?php echo $_POST["datetime"]; ?>"/>
                        <br><br>
                        <input type="submit" name = "submit" value="Submit" />
                    </form>
                </div>
                
                <div class="map-container">
                    <div class="map" id="map"></div>
                </div>
                
                <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
                    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
                    crossorigin=""></script>
        
                <script src="script.js"></script>

                
                <?php
                    error_reporting(E_ERROR | E_PARSE); #enables to hide warning when $vehicle is empty
                    $date_selected = date('Y-m-d H:i', strtotime($_POST["datetime"]));

                    /*----------------Vehicles----------------*/

                    $sql ="SELECT vhc_mvt.latitude,vhc_mvt.longitude,vhc_mvt.date, vhc.immatriculation_number,vhc.type,vhc.purchase_date 
                        FROM vehicle_movement AS vhc_mvt, vehicle AS vhc
                        WHERE vhc.immatriculation_number = vhc_mvt.immatriculation_vehicle AND vhc_mvt.date LIKE '%$date_selected%' and vhc.type IN ('" . implode("','", $vehicle) . "')";

                    $result = mysqli_query($conn, $sql);
                    if($result){
                        
                        while($row = mysqli_fetch_assoc($result)){
                            $date_movement = date('Y-m-d H:i', strtotime($row["date"]));
                            $purchase_date = date('Y-m-d H:i', strtotime($row["purchase_date"]));

                            echo("<script type='text/javascript'>drawVehicle('". $row["type"] . "','". $row["immatriculation_number"] . 
                                "','" . $purchase_date ."'," .$row["latitude"] . "," . $row["longitude"].");</script>");
                        }
                    }


                    /*----------------Aircrafts----------------*/
                    if (in_array('aircraft',$vehicle)){
                        $sql ="SELECT air.id, air_mvt.latitude,air_mvt.longitude,air_mvt.date, air.name_aircraft_type,air.fuel_level,air.purchase_date 
                            FROM aircraft_movement AS air_mvt, aircraft AS air
                            WHERE air.id = air_mvt.id_aircraft AND air_mvt.date LIKE '%$date_selected%'";

                        $result = mysqli_query($conn, $sql);
                        if($result){             
                            while($row = mysqli_fetch_assoc($result)){
                                $purchase_date = date('Y-m-d H:i', strtotime($row["purchase_date"]));
                                echo("<script type='text/javascript'>drawAircraft(".$row["id"] . ",'" .$row["name_aircraft_type"] . "','" .
                                $purchase_date ."'," .$row["latitude"] . "," . $row["longitude"].");</script>");                        
                            }
                        }
                    }

                    /*----------------ULDs----------------*/
                    if (in_array('ULD',$vehicle)){
                        $sql ="SELECT uld.code, uld_mvt.latitude,uld_mvt.longitude,uld_mvt.date, uld.name, uld.length, 
                                        uld.width, uld.height, uld.empty_weight, uld.max_gross_weight, uld.volume
                            FROM uld_movement AS uld_mvt, uld
                            WHERE uld.code = uld_mvt.id_ULD AND uld_mvt.date LIKE '%$date_selected%'";

                        $result = mysqli_query($conn, $sql);
                        if($result){             
                            while($row = mysqli_fetch_assoc($result)){
                                echo("<script type='text/javascript'>drawULD(".$row["code"] . ",'" .
                                                                                $row["name"] . "'," .
                                                                                $row["length"] . "," . 
                                                                                $row["width"] . "," . 
                                                                                $row["height"] . "," . 
                                                                                $row["empty_weight"] . "," . 
                                                                                $row["max_gross_weight"] . "," . 
                                                                                $row["volume"] . "," . 
                                                                                $row["latitude"] . "," . 
                                                                                $row["longitude"].");</script>");                        
                            }
                        }
                    }
                    
                ?>
            </div>
        <?php
        }
        ?>


        <?php
        #______________________________________________________________________________________
        #------------------------------------SPECIFIC------------------------------------------
        #______________________________________________________________________________________

        if ($_GET["display"] == "specific") {
        ?>
            <div class="map_specific-group" id="map_specific-group">

                <?php

                if(!isset($_GET["id_aircraft"]) && !isset($_GET["immatriculation"]) && !isset($_GET["ULD_code"])){
                    echo('no vehicle or aircraft or uld provided');
                }
                
                else{
                    if(!isset($_POST["datetime-from"])){
                        $_POST["datetime-from"] = $today06;
                        $_POST["datetime-to"] = $today;
                    }
    
                    if(isset($_GET["id_aircraft"])){
                        $id_aircraft = $_GET['id_aircraft'];

                        #extract information about the aircraft
                        $sql ="SELECT air.name_aircraft_type,air.fuel_level,air.purchase_date 
                            FROM aircraft_movement AS air_mvt, aircraft AS air
                            WHERE air.id = air_mvt.id_aircraft AND air.id = $id_aircraft";
                        
                        $result = mysqli_query($conn, $sql);
                        if($result){
                            while($row = mysqli_fetch_assoc($result)){
                                $purchase_date = date('Y-m-d H:i', strtotime($row["purchase_date"]));
                                $name_aircraft_type = $row["name_aircraft_type"];
                                $fuel_level = $row["fuel_level"];
                            }
                        }
                    }
    
                    elseif(isset($_GET["immatriculation"])){
                        $immatriculation = $_GET['immatriculation'];

                        #extract information about the vehicle
                        $sql = "SELECT vhc.immatriculation_number,vhc.type,vhc.purchase_date 
                            FROM vehicle as vhc, vehicle_movement as vhc_mvt
                            WHERE vhc.immatriculation_number = vhc_mvt.immatriculation_vehicle AND vhc_mvt.immatriculation_vehicle = '$immatriculation'";
                        
                        $result = mysqli_query($conn, $sql);
                        $nb_rows = mysqli_num_rows($result);
                        if($nb_rows>0){
                            while($row = mysqli_fetch_assoc($result)){
                                $purchase_date = date('Y-m-d H:i', strtotime($row["purchase_date"]));
                                $type = $row["type"];
                            }
                        } else {
                            echo("<b>No movement detected for this vehicle</b>");
                            $sql = "SELECT vhc.immatriculation_number,vhc.type,vhc.purchase_date 
                                FROM vehicle as vhc
                                WHERE vhc.immatriculation_number = '$immatriculation'";
                            
                            $result = mysqli_query($conn, $sql);
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    $purchase_date = date('Y-m-d H:i', strtotime($row["purchase_date"]));
                                    $type = $row["type"];
                                }
                            }
                        }
                    }
                    
                    elseif(isset($_GET["ULD_code"])){
                        $ULD_code = $_GET['ULD_code'];

                        #extract information about the ULD
                        $sql ="SELECT uld.code, uld.name, uld.length, uld.width, uld.height, uld.empty_weight, uld.max_gross_weight, uld.volume
                            FROM uld_movement AS uld_mvt, uld
                            WHERE uld.code = uld_mvt.id_ULD AND uld.code = $ULD_code";
                        
                        $result = mysqli_query($conn, $sql);
                        if($result){
                            while($row = mysqli_fetch_assoc($result)){
                                $name = $row["name"];
                                $length = $row["length"];
                                $width = $row["width"];
                                $height = $row["height"];
                                $empty_weight = $row["empty_weight"];
                                $max_gross_weight = $row["max_gross_weight"];
                                $volume = $row["volume"];
                            }
                        }
                    }
                    
                ?>
        
                    <div class="form_map_container">
                        <form method="post" action="">

                            <?php
                            if(isset($_GET["id_aircraft"])){
                                echo("<legend>Aircraft Information</legend>");
                                echo("<br>aircraft type: " . $name_aircraft_type . '<br>');
                                echo("Fuel Level: " . $fuel_level . '<br>');
                                echo("Purchase date: " . $purchase_date . '<br>');
                            }

                            elseif(isset($_GET["immatriculation"])){
                                echo("<legend>Vehicle Information</legend>");
                                echo("<br>Vehicle type: " . $type . '<br>');
                                echo("Immatriculation number: " . $immatriculation . '<br>');
                                echo("Purchase date: " . $purchase_date . '<br>');
                            }

                            elseif(isset($_GET["ULD_code"])){
                                
                                echo("<legend>ULD Information</legend>");
                                echo("<br>Name: " . $name . '<br>');
                                echo("<br>Width: " . $width . '<br>');
                                echo("<br>height: " . $height . '<br>');
                                echo("<br>Empty weight: " . $empty_weight . '<br>');
                                echo("<br>Max Gross Weight: " . $max_gross_weight . '<br>');
                                echo("<br>Volume: " . $volume . '<br>');
                            }

                            ?>
    
                            <br><br>
                            <label>Period: </label>
                            <br><br>
                            <label>FROM :</label>
                            <input type="datetime-local" name="datetime-from" value="<?php echo $_POST["datetime-from"]; ?>"/>
                            <br><br>
                            <label>TO :</label>
                            <input type="datetime-local" name="datetime-to" value="<?php echo $_POST["datetime-to"]; ?>"/>
                            <br><br>
                            <input type="submit" name = "submit" value="Submit" />
                        </form>
                    </div>
                    <div class="map-container">
                        <div class="map" id="map"></div>
                    </div>
                    
                    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
                        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
                        crossorigin=""></script>
                    
                    <script src="script.js"></script>
                    
                    <?php
    
                        $date_selected_from = date('Y-m-d H:i', strtotime($_POST["datetime-from"]));
                        $date_selected_to = date('Y-m-d H:i', strtotime($_POST["datetime-to"]));
        
                        if(isset($_GET["id_aircraft"])){
                            $sql ="SELECT air.id, air_mvt.latitude,air_mvt.longitude,air_mvt.date, 
                                air.name_aircraft_type,air.fuel_level,air.purchase_date 
                                FROM aircraft_movement AS air_mvt, aircraft AS air
                                WHERE air.id = air_mvt.id_aircraft  AND 
                                    air.id = $id_aircraft AND
                                    air_mvt.date >= '$date_selected_from' AND
                                    air_mvt.date <= '$date_selected_to'";
                        
                            $result = mysqli_query($conn, $sql);
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    $date_movement = date('Y-m-d H:i', strtotime($row["date"]));
                                    echo("<script type='text/javascript'>drawAircraftMovement('". $row["name_aircraft_type"] . 
                                        "','". $row["date"] . "','" . $row["purchase_date"] ."'," .$row["latitude"] . "," . 
                                        $row["longitude"] . ");</script>");
                                }
                                echo("<script type='text/javascript'>drawLines();</script>");
                            }
                        }
                        
                        elseif(isset($_GET["immatriculation"])){
                            $sql ="SELECT vhc_mvt.latitude,vhc_mvt.longitude,vhc_mvt.date, 
                                vhc.immatriculation_number,vhc.type,vhc.purchase_date FROM vehicle_movement AS vhc_mvt, vehicle AS vhc
                                WHERE vhc.immatriculation_number = vhc_mvt.immatriculation_vehicle AND
                                    vhc.immatriculation_number = '$immatriculation' AND
                                    vhc_mvt.date >= '$date_selected_from' AND
                                    vhc_mvt.date <= '$date_selected_to'";
                        
                            $result = mysqli_query($conn, $sql);
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    $date_movement = date('Y-m-d H:i', strtotime($row["date"]));
                                    echo("<script type='text/javascript'>drawVehicleMovement('". $row["type"] . "','". $row["date"] . "','" .
                                        $row["immatriculation_number"] . "','" . $row["purchase_date"] ."'," .$row["latitude"] . "," . $row["longitude"] . 
                                        ");</script>");
                                }
                                echo("<script type='text/javascript'>drawLines();</script>");
                            }
                        }

                        elseif(isset($_GET["ULD_code"])){
                            $sql ="SELECT uld_mvt.latitude, uld_mvt.longitude, uld_mvt.date, uld.code, uld.name, uld.length, uld.width, uld.height, uld.empty_weight, uld.max_gross_weight, uld.volume
                                    FROM uld_movement AS uld_mvt, uld
                                    WHERE uld.code = uld_mvt.id_ULD AND 
                                        uld.code = $ULD_code AND
                                        uld_mvt.date >= '$date_selected_from' AND
                                        uld_mvt.date <= '$date_selected_to'";
                        
                            $result = mysqli_query($conn, $sql);
                            if($result){
                                while($row = mysqli_fetch_assoc($result)){
                                    $date_movement = date('Y-m-d H:i', strtotime($row["date"]));
                                    echo("<script type='text/javascript'>drawULDMovement('". $row["name"] . "','". $row["date"]  . "'," .
                                        $row["latitude"] . "," . $row["longitude"] . ");</script>");
                                }
                                echo("<script type='text/javascript'>drawLines();</script>");
                            }
                        }
                    ?>
                <?php
                } 
                ?>
            </div>
        <?php
        }
        ?>
    </body>
</html>
