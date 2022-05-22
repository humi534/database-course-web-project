<?php
    include_once("./add_ons/header.php");
    include("./includes/dbconn.inc.php");
    include("./add_ons/sidebar.php");
?>

<?php

    //----Card 1 SQL Request-------
    $sql ="SELECT count(`id`) as nb_flights FROM `flight` where month(`observed_arrival_time`)= month(CURRENT_TIMESTAMP())";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nb_flights = $row['nb_flights'];

    //----Card 2 SQL Request-------
    $sql ="SELECT count(`id`) as nb_current_flights FROM `flight` where month(`observed_arrival_time`)= month(CURRENT_TIMESTAMP()) AND day(`observed_arrival_time`) = day(CURRENT_TIMESTAMP())";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nb_current_flights = $row['nb_current_flights'];

    //----Card 3 SQL Request-------
    $sql ="SELECT count(`id`) as nb_delay_departure FROM `flight` WHERE `scheduled_departure_time` != `observed_departure_time`";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nb_delay_departure = $row['nb_delay_departure'];

    //----Card 4 SQL Request-------
    $sql ="SELECT count(`id`) as nb_delay_arrival FROM `flight` WHERE `scheduled_arrival_time` != `observed_arrival_time`";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nb_delay_arrival = $row['nb_delay_arrival'];

?>
    
<div class="main-content">

    <h1>Flights</h1>

    <div class="cardBox">
        <div class="card">
            <div>
                <div class="numbers"><?php echo $nb_flights; ?></div>
                <div class="cardname">Number of flights since the beginning of the month</div>
            </div>
            <div class="iconBox">
                <i class="ti-location-arrow" aria-hidden="true"></i>
            </div>
        </div>
        
        <div class="card">
            <div>
                <div class="numbers"><?php echo $nb_current_flights; ?></div>
                <div class="cardname">Current Flights</div>
            </div>
            <div class="iconBox">
                <i class="fa fa-eye" aria-hidden="true"></i>
            </div>
        </div>
        
        <div class="card">
            <div>
                <div class="numbers"><?php echo $nb_delay_departure; ?></div>
                <div class="cardname">Flights delayed at departure</div>
            </div>
            <div class="iconBox">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="numbers"><?php echo $nb_delay_arrival; ?></div>
                <div class="cardname">Flights delayed at arrival</div>
            </div>
            <div class="iconBox">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            </div>
        </div>
    </div>


    
    <div class="Flights">
        <div class="bottom-right-buttons">  
            <form class="form-search" action='/project/includes/flights.inc.php' method='post'>
            
                <i class="fa fa-search" aria-hidden="true" id="search_icon"></i>
            
                <select name="select-search">
                    <option value="id">FLIGHT ID</option>
                    <option value="id_aircraft">AIRCRAFT ID</option>
                    <option value="airport_departure">DEPARTURE</option>
                    <option value="airport_arrival">ARRIVAL</option>
                    <option value="scheduled_departure_time">SCHEDULED DEPARTURE TIME</option>
                    <option value="scheduled_arrival_time">SCHEDULED ARRIVAL TIME</option>
                </select>
                <input type="text" name="contain-search">
                <button type="submit">SEARCH</button>

                <button  type="submit" name="see-all-button">SEE ALL</button>
            </form>            
        </div>

        <div class="table_and_buttons">
            <table class="content-table">
                <thead>
                    <tr>
                        <th>Flight id</th>
                        <th>Aircraft id</th>
                        <th>Departure airport</th>
                        <th>Departure time</th>
                        <th>Arrival airport</th>
                        <th>Arrival time</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql ="SELECT * FROM `flight` limit 4";
                        $result = mysqli_query($conn, $sql);
                        $nb_rows = mysqli_num_rows($result);
                        $flights ="";
                        if ($nb_rows>0){
                            while ($row = mysqli_fetch_assoc($result)){
                                $flights .= "<tr>";

                                //Flight ID
                                $id = $row['id'];
                                $flights .= "<td>".$row['id']."</td>";

                                //Aircraft ID
                                $flights .= "<td>".$row['id_aircraft']."</td>";

                                //Airport Departure 
                                $IATA = $row['airport_departure'];
                                $flights .= "<td>".$IATA."</td>";

                                //Scheduled Departure Time 
                                $flight_date_d = $row['scheduled_departure_time'];
                                $flight_date_d_new_format = date('Y-m-d H:i', strtotime($flight_date_d));
                                $flights .= "<td> <strong>Scheduled time : </strong>".$flight_date_d_new_format;
                                
                                //Observed Departure Time
                                $flight_obs_d = $row['observed_departure_time'];
                                if($flight_obs_d){
                                    $flight_obs_d_new_format = date('Y-m-d H:i', strtotime($flight_obs_d));
                                    $flights .= "</br> <strong>Observed time : </strong>".$flight_obs_d_new_format."</td>";
                                }else{
                                    $flights .= "</td>";
                                }
                                //Airport Arrival 
                                $IATA = $row['airport_arrival'];
                                $flights .= "<td>".$IATA."</td>";

                                //Scheduled Arriva Time 
                                $flight_date_a = $row['scheduled_arrival_time'];
                                $flight_date_a_new_format = date('Y-m-d H:i', strtotime($flight_date_a));
                                $flights .= "<td> <strong>Scheduled time : </strong>".$flight_date_a_new_format;

                                //Observed Departure Time
                                $flight_obs_a = $row['observed_arrival_time'];
                                if($flight_obs_a){
                                    $flight_obs_a_new_format = date('Y-m-d H:i', strtotime($flight_obs_a));
                                    $flights .= "</br> <strong> Observed time : </strong>".$flight_obs_a_new_format."</td>";
                                } else {
                                    $flights .= "</td>";
                                }
                                //Button for more details
                                $flights .= "<td>    
                                            <form method='post' action='/project/includes/flights.inc.php' display: inline>
                                            <button class='ADD-button' type='submit' name='details-button' value=$id>More details</button>
                                            </form> 
                                        </td>";

                                $flights .= "</tr>";
                            }
                        }
                        echo $flights;
                    ?>
                </tbody>
            </table>
        
            
        </div>
    
    </div>
</div>

<?php
    include_once("./add_ons/footer.php");
?>