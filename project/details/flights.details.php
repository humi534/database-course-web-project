
<?php
    include_once("../add_ons/header.php");
    include("../includes/dbconn.inc.php");
    include("../add_ons/sidebar.php");

    $flight_id = $_GET['id'];
?>
<div class="main-content">
    <h1>Details about a flight</h1>
    <div class="Flights">
        <a href="http://localhost/project/map.php" title="Map">
            <img class="map"
                src="/project/style/map_update.png"
                alt="Map for the vehicles used"
                width="700" height="345">
        </a>
            <?php
                if(isset($_GET['id'])) {
                    $flight_id = $_GET['id'];
                    $sql ="SELECT * FROM `flight` WHERE `id`= $flight_id";
                    $result = mysqli_query($conn, $sql);
                    $nb_rows = mysqli_num_rows($result);
                    $flights ="";
                    if ($nb_rows>0){
                        while ($row = mysqli_fetch_assoc($result)){
                            //Airport Departure 
                            $IATA_departure = $row['airport_departure'];
                            $sql_airport = "SELECT * FROM `airport` WHERE `IATA` like '$IATA_departure'";
                            $result_airport = mysqli_query($conn, $sql_airport);
                            $nb_rows_airport = mysqli_num_rows($result_airport);

                            if ($nb_rows_airport>0){
                                while ($row_airport = mysqli_fetch_assoc($result_airport)){
                                    $airport_name_departure = $row_airport['long_name'];
                                }                                
                            }

                            //Scheduled Departure Time 
                            $flight_date_d = $row['scheduled_departure_time'];
                            $flight_date_d_new_format = date('Y-m-d H:i', strtotime($flight_date_d));
                            
                            //Observed Departure Time
                            $flight_obs_d = $row['observed_departure_time'];
                            if($flight_obs_d){
                                $flight_obs_d_new_format = date('Y-m-d H:i', strtotime($flight_obs_d));
                            }else{
                                $flight_obs_d_new_format = "";
                            }

                            //Airport Arrival 
                            $IATA_arrival = $row['airport_arrival'];
                            $sql_airport = "SELECT * FROM `airport` WHERE `IATA` like '$IATA_arrival'";
                            $result_airport = mysqli_query($conn, $sql_airport);
                            $nb_rows_airport = mysqli_num_rows($result_airport);
                            if ($nb_rows_airport>0){
                                while ($row_airport = mysqli_fetch_assoc($result_airport)){
                                    $airport_name_arrival = $row_airport['long_name'];
                                }                                
                            }

                            //Scheduled Arriva Time 
                            $flight_date_a = $row['scheduled_arrival_time'];
                            $flight_date_a_new_format = date('Y-m-d H:i', strtotime($flight_date_a));

                            //Observed Departure Time
                            $flight_obs_a = $row['observed_arrival_time'];
                            if($flight_obs_a){
                                $flight_obs_a_new_format = date('Y-m-d H:i', strtotime($flight_obs_a));
                            } else {
                                $flight_obs_a_new_format = "";
                            }
                        }
                    }
                }
            ?>
        <br>
        <br>
        <div class="list-flight-details"> 
        	<ul>
                <li><span class ="fa fa-plane"></span>  DEPARTURE </li>
                <li class="dotted-line">
                    <ul class = "empty-ul-departure">
                        <li><?php echo $airport_name_departure.", ".$IATA_departure ?></li>
                        <li class ="black"><?php echo "<strong> Scheduled time : </strong>".$flight_date_d_new_format ?></li>
                        <li class ="black"><?php echo "<strong> Observed time : </strong>".$flight_obs_d_new_format  ?></li>
                    </ul>
                    <br>
                    <br>
                </li>
            </ul>
            <ul>
                <li><span class ="fa fa-plane fa-rotate-90"></span> ARRIVAL</li>
                <li>
                    <ul class = "empty-ul">
                        <li><?php echo $airport_name_arrival.", ".$IATA_arrival ?></li>
                        <li class ="black"><?php echo "<strong> Scheduled time : </strong>".$flight_date_a_new_format ?></li>
                        <li class ="black"><?php echo "<strong> Observed time : </strong>".$flight_obs_a_new_format ?></li>
                    </ul>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
                </li>
            </ul>
        </div>

        <div class="table_and_buttons">
            <table class="content-table">
                <thead>
                    <tr>
                        <th colspan="1"><h3><br>Load Plan</h3></th>
                    </tr>
                    <tr>
                        <th>Id Load Plan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($_GET['id'])) {
                            $sql ="SELECT * 
                                FROM `load_plan` 
                                WHERE `id_flight`=$flight_id";
                            $result = mysqli_query($conn, $sql);
                            $nb_rows = mysqli_num_rows($result);
                            $load_plan ="";
                            if ($nb_rows>0){
                                while ($row = mysqli_fetch_assoc($result)){
                                    $load_plan .= "<tr>";

                                    //Id Load Plan
                                    $load_plan .= "<td>".$row['id']."</td>";
                                    $load_plan .= "</tr>";
                                }
                            }
                            echo $load_plan;
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="table_and_buttons">
            <table class="content-table">
                <thead>
                    <tr>
                        <th colspan="7"><h3><br>Vehicles</h3></th>
                    </tr>
                    <tr>
                        <th>Speed loaders</th>
                        <th>Deck loader</th>
                        <th>High loader</th>
                        <th>Ground Power Unit</th>
                        <th>Tanker</th>
                        <th>Dollies</th>
                        <th>Dollies Tractor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //Vehicles 
                        // Speed Loader
                        $sql2 ="SELECT id_flight, immatriculation_vehicle, type FROM flight_vehicle LEFT JOIN vehicle ON ".$_GET['id']." = id_flight WHERE vehicle.type LIKE 'speed loader' AND flight_vehicle.immatriculation_vehicle = vehicle.immatriculation_number";
                        $result2 = mysqli_query($conn, $sql2);
                        $nb_rows2 = mysqli_num_rows($result2);
                        $vehicles = "<tr>";
                        $vehicles .= "<td> ";
                        if($nb_rows2>0)
                            {
                                while($row2 = mysqli_fetch_assoc($result2)){
                                    $vehicles .= " ".$row2['immatriculation_vehicle'].", ";
                                }
                            }
                        else
                            {
                                $vehicles .= "<form action='../includes/vehicles.inc.php' method='post'>";
                                $vehicles .= "<input type='hidden' name='select-search' value='type'/>";
                                $vehicles .= "<input type='hidden' name='contain-search' value='speed loader'/>";
                                $vehicles .= "<button name ='submit'  class='ADD-button' style='height:50px;width:150px'>Find Speed Loader</button></form>";
                            }
                        $vehicles .= "</td> ";

                        // Deck Loader
                        $sql2 ="SELECT id_flight, immatriculation_vehicle, type FROM flight_vehicle LEFT JOIN vehicle ON ".$_GET['id']." = id_flight WHERE vehicle.type LIKE 'deck loader' AND flight_vehicle.immatriculation_vehicle = vehicle.immatriculation_number";
                        $result2 = mysqli_query($conn, $sql2);
                        $nb_rows2 = mysqli_num_rows($result2);
                        $vehicles .= "<td> ";
                        if($nb_rows2>0)
                        {
                            while($row2 = mysqli_fetch_assoc($result2)){
                                $vehicles .= " ".$row2['immatriculation_vehicle'].", ";
                            }
                        }
                        else
                            {
                                $vehicles .= "<form action='../includes/vehicles.inc.php' method='post'>";
                                $vehicles .= "<input type='hidden' name='select-search' value='type'/>";
                                $vehicles .= "<input type='hidden' name='contain-search' value='deck loader'/>";
                                $vehicles .= "<button name ='submit' class='ADD-button' style='height:50px;width:150px'>Find Deck Loader</button></form>";
                            }
                        $vehicles .= "</td> ";

                        // High Loader
                        $sql2 ="SELECT id_flight, immatriculation_vehicle, type FROM flight_vehicle LEFT JOIN vehicle ON ".$_GET['id']." = id_flight WHERE vehicle.type LIKE 'high loader' AND flight_vehicle.immatriculation_vehicle = vehicle.immatriculation_number";
                        $result2 = mysqli_query($conn, $sql2);
                        $nb_rows2 = mysqli_num_rows($result2);
                        $vehicles .= "<td> ";
                        if($nb_rows2>0)
                        {
                            while($row2 = mysqli_fetch_assoc($result2)){
                                $vehicles .= " ".$row2['immatriculation_vehicle'].", ";
                            }
                        }
                        else
                            {
                                $vehicles .= "<form action='../includes/vehicles.inc.php' method='post'>";
                                $vehicles .= "<input type='hidden' name='select-search' value='type'/>";
                                $vehicles .= "<input type='hidden' name='contain-search' value='high loader'/>";
                                $vehicles .= "<button name ='submit' class='ADD-button' style='height:50px;width:150px'>Find High Loader</button></form>";
                            }
                        $vehicles .= "</td> ";

                        // GPU
                        $sql2 ="SELECT id_flight, immatriculation_vehicle, type FROM flight_vehicle LEFT JOIN vehicle ON ".$_GET['id']." = id_flight WHERE vehicle.type LIKE 'GPU' AND flight_vehicle.immatriculation_vehicle = vehicle.immatriculation_number";
                        $result2 = mysqli_query($conn, $sql2);
                        $nb_rows2 = mysqli_num_rows($result2);
                        $vehicles .= "<td> ";
                        if($nb_rows2>0)
                        {
                            while($row2 = mysqli_fetch_assoc($result2)){
                                $vehicles .= " ".$row2['immatriculation_vehicle'].", ";
                            }
                        }
                        else
                            {
                                $vehicles .= "<form action='../includes/vehicles.inc.php' method='post'>";
                                $vehicles .= "<input type='hidden' name='select-search' value='type'/>";
                                $vehicles .= "<input type='hidden' name='contain-search' value='GPU'/>";
                                $vehicles .= "<button name ='submit'  class='ADD-button' style='height:50px;width:150px'>Find GPU</button></form>";
                            }
                        $vehicles .= "</td> ";

                        // Refuelling
                        $sql2 ="SELECT id_flight, immatriculation_vehicle, type FROM flight_vehicle LEFT JOIN vehicle ON ".$_GET['id']." = id_flight WHERE vehicle.type LIKE 'refuelling' AND flight_vehicle.immatriculation_vehicle = vehicle.immatriculation_number";
                        $result2 = mysqli_query($conn, $sql2);
                        $nb_rows2 = mysqli_num_rows($result2);
                        $vehicles .= "<td> ";
                        if($nb_rows2>0)
                        {
                            while($row2 = mysqli_fetch_assoc($result2)){
                                $vehicles .= " ".$row2['immatriculation_vehicle'].", ";
                            }
                        }
                        else
                            {
                                $vehicles .= "<form action='../includes/vehicles.inc.php' method='post'>";
                                $vehicles .= "<input type='hidden' name='select-search' value='type'/>";
                                $vehicles .= "<input type='hidden' name='contain-search' value='refuelling'/>";
                                $vehicles .= "<button name ='submit'  class='ADD-button' style='height:50px;width:150px'>Find Refueller</button></form>";
                            }
                        $vehicles .= "</td> ";

                        // Dollies
                        $sql2 ="SELECT id_flight, immatriculation_vehicle, type FROM flight_vehicle LEFT JOIN vehicle ON ".$_GET['id']." = id_flight WHERE vehicle.type LIKE 'dolly' AND flight_vehicle.immatriculation_vehicle = vehicle.immatriculation_number";
                        $result2 = mysqli_query($conn, $sql2);
                        $nb_rows2 = mysqli_num_rows($result2);
                        $vehicles .= "<td> ";
                        if($nb_rows2>0)
                        {
                            while($row2 = mysqli_fetch_assoc($result2)){
                                $vehicles .= " ".$row2['immatriculation_vehicle'].", ";
                            }
                        }
                        else
                            {
                                $vehicles .= "<form action='../includes/vehicles.inc.php' method='post'>";
                                $vehicles .= "<input type='hidden' name='select-search' value='type'/>";
                                $vehicles .= "<input type='hidden' name='contain-search' value='dolly'/>";
                                $vehicles .= "<button name ='submit' class='ADD-button' style='height:50px;width:150px'>Find Dollies</button></form>";
                            }
                        $vehicles .= "</td> ";

                        // Dollies Tractor
                        $sql2 ="SELECT id_flight, immatriculation_vehicle, type FROM flight_vehicle LEFT JOIN vehicle ON ".$_GET['id']." = id_flight WHERE vehicle.type LIKE 'dolly tractor' AND flight_vehicle.immatriculation_vehicle = vehicle.immatriculation_number";
                        $result2 = mysqli_query($conn, $sql2);
                        $nb_rows2 = mysqli_num_rows($result2);
                        $vehicles .= "<td> ";
                        if($nb_rows2>0)
                        {
                            while($row2 = mysqli_fetch_assoc($result2)){
                                $vehicles .= " ".$row2['immatriculation_vehicle'].", ";
                            }
                        }
                        else
                            {
                                $vehicles .= "<form action='../includes/vehicles.inc.php' method='post'>";
                                $vehicles .= "<input type='hidden' name='select-search' value='type'/>";
                                $vehicles .= "<input type='hidden' name='contain-search' value='dolly tractor'/>";
                                $vehicles .= "<button name ='submit'  class='ADD-button' style='height:50px;width:150px'>Find Dollies Tractor</button></form>";
                            }
                        $vehicles .= "</td> ";


                        $vehicles .= "</tr>";
                        echo $vehicles;
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php
    include_once("../add_ons/footer.php");
?>
