<?php
    include_once("./add_ons/header.php");
    include("./includes/dbconn.inc.php");
    include("./add_ons/sidebar.php");

    #Set default value for datetime-from and datetime-to in case this page 
    #is open manually (not by the form on activity_log page)
    $month = date('m');
    $day = date('d');
    $year = date('Y');
    $today08 = $year . '-' . $month . '-' . $day. 'T08:00';
    $today18 = $year . '-' . $month . '-' . $day. 'T18:00';

    if(!isset($_POST["datetime-from"])){
        $_POST["datetime-from"] = $today08;
        $_POST["datetime-to"] = $today18;
    }
?>

<div class="main-content">

    <?php      
        $time_from = date('Y-m-d H:i', strtotime($_POST["datetime-from"]));
        $time_to = date('Y-m-d H:i', strtotime($_POST["datetime-to"]));
    ?>

    <form class="form-activity" action='activity_log_tables.php' method='post'>
        <label>Choose time interval: </label>
        <label>FROM</label>
        <input type="datetime-local" name="datetime-from" value="<?php echo $today08; ?>"/>
        <label>TO</label>
        <input type="datetime-local" name="datetime-to" value="<?php echo $today18; ?>"/>
        <input type="submit"/>
    </form>

    <h1>ACTIVITY LOG</h1>

    <section class="arrivals">
        <h2>ARRIVALS</h2>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Flight number</th>
                    <th>Airport departure</th>
                    <th>Airport arrival</th>
                    <th>Scheduled arrival time</th>
                    <th>Observed arrival time</th>
                    <th>Gate</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql ="SELECT id, airport_departure, airport_arrival, scheduled_arrival_time, observed_arrival_time, id_gate FROM flight";
                    $result = mysqli_query($conn, $sql);
                    $i = 0;
                    $arrivals ="";
                    if($result){
                        while(($row = mysqli_fetch_assoc($result)) && $i < 4){

                            $scheduled_arr = date('Y-m-d H:i', strtotime($row["scheduled_arrival_time"]));
                            $observed_arr = date('Y-m-d H:i', strtotime($row["observed_arrival_time"]));
                            
                            if (($scheduled_arr > $time_from && $scheduled_arr < $time_to) || ($observed_arr > $time_from && $observed_arr < $time_to)){
                                $i++;
                                $arrivals .= "<tr>";
                                $arrivals .= "<td>".$row['id']."</td>";
                                $arrivals .= "<td>".$row['airport_departure']."</td>";
                                $arrivals .= "<td>".$row['airport_arrival']."</td>";
                                $arrivals .= "<td>".$scheduled_arr."</td>";
                                $arrivals .= "<td>".$observed_arr. "</td>";
                                $arrivals .= "<td>".$row['id_gate']. "</td>";
                                $arrivals .= "</tr>";
                            }
                        }
                    }
                    echo $arrivals;
                ?>
            </tbody>
        </table>
    </section>

    <section class="departures">
        <h2>DEPARTURES</h2>
        <table class="content-table">
            <thead>
                <tr>
                    <th>flight number</th>
                    <th>airport departure</th>
                    <th>airport arrival</th>
                    <th>scheduled departure time</th>
                    <th>observed departure time</th>
                    <th>Gate</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql ="SELECT id, airport_departure, airport_arrival, scheduled_departure_time, observed_departure_time, id_gate FROM flight";
                    $result = mysqli_query($conn, $sql);
                    $i = 0;
                    $departures ="";
                    if($result){
                        while(($row = mysqli_fetch_assoc($result)) && $i < 4){

                            $scheduled_dep = date('Y-m-d H:i', strtotime($row["scheduled_departure_time"]));
                            $observed_dep = date('Y-m-d H:i', strtotime($row["observed_departure_time"]));
                            
                            if (($scheduled_dep > $time_from && $scheduled_dep < $time_to) || ($observed_dep > $time_from && $observed_dep < $time_to)){
                                $i++;
                                $departures .= "<tr>";
                                $departures .= "<td>".$row['id']."</td>";
                                $departures .= "<td>".$row['airport_departure']."</td>";
                                $departures .= "<td>".$row['airport_arrival']."</td>";
                                $departures .= "<td>".$scheduled_dep."</td>";
                                $departures .= "<td>".$observed_dep. "</td>";
                                $departures .= "<td>".$row['id_gate']. "</td>";
                                $departures .= "</tr>";
                            }
                        }
                    }
                    echo $departures;
                ?>
            </tbody>
        </table>
    </section>


    <section class="maintenances">
        <h2>MAINTENANCES</h2>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Maintenance number</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Aircraft number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql ="SELECT * FROM maintenance";
                    $result = mysqli_query($conn, $sql);
                    $maintenances ="";
                    $i = 0;
                    if($result){
                        while(($row = mysqli_fetch_assoc($result)) && ($i < 4)){

                            $start_date = date('Y-m-d H:i', strtotime($row["start_date"]));
                            if($row["end_date"] != NULL){
                                $end_date = date('Y-m-d H:i', strtotime($row["end_date"]));
                            } else {
                                $end_date = "";
                            }

                            
                            
                            if (($start_date > $time_from && $start_date < $time_to) || ($end_date > $time_from && $end_date < $time_to)){
                                $i++;
                                $maintenances .= "<tr>";
                                $maintenances .= "<td>".$row['id']."</td>";
                                $maintenances .= "<td>".$start_date."</td>";
                                $maintenances .= "<td>".$end_date."</td>";
                                $maintenances .= "<td>".$row['aircraft_id']."</td>";
                                $maintenances .= "<td>".$row['status']. "</td>";
                                $maintenances .= "</tr>";
                            }
                        }
                    }
                    echo $maintenances;
                ?>
            </tbody>
        </table>
    </section>
</div>

<?php
    include_once("./add_ons/footer.php");
?>
