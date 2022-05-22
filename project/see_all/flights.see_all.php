<?php
    include_once("../add_ons/header.php");
    include("../includes/dbconn.inc.php");
    include("../add_ons/sidebar.php");
?>
    
<div class="main-content">
    <h1>Flights - List</h1>
        <section class="Flight">
            <table class="content-table center">
                <thead>
                    <tr>
                        <th>Flight id</th>
                        <th>Aircraft id</th>
                        <th>Departure</th>
                        <th>Scheduled departure time</th>
                        <th>Arrival</th>
                        <th>Scheduled arrival time</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    //SQL Request for a search request
                    if( isset($_GET['select-search']) && isset($_GET['contain-search']) ){
                        $select_search = $_GET['select-search'];
                        $contain = $_GET['contain-search'];

                        $sql = "SELECT * FROM `flight` WHERE `$select_search` like '%$contain%'"; 
                        
                        
                    } else {
                        $sql ="SELECT * FROM `flight`";
                        
                    }
                    $result = mysqli_query($conn, $sql);
                    $nb_rows = mysqli_num_rows($result);
                    $flights = "<form action='../includes/flights.inc.php' method='post'>";
                    if ($nb_rows>0){
                        while ($row = mysqli_fetch_assoc($result)){
                            
                            $id = $row['id'];
                            $flights   .= "<tr>";

                            //Flight ID
                            $flights .= "<td>".$row['id']."</td>";

                            //Aircraft ID
                            $flights .= "<td>".$row['id_aircraft']."</td>";

                            //Airport Departure 
                            $IATA = $row['airport_departure'];
                            $flights .= "<td>".$IATA."</td>";

                            //Scheduled Departure Time 
                            $flight_date_d = $row['scheduled_departure_time'];
                            $flight_date_d_new_format = date('Y-m-d H:i', strtotime($flight_date_d));
                            $flights .= "<td>".$flight_date_d_new_format."</td>";
                            
                            //Airport Arrival 
                            $IATA = $row['airport_arrival'];
                            $flights .= "<td>".$IATA."</td>";

                            //Scheduled Arriva Time 
                            $flight_date_a = $row['scheduled_arrival_time'];
                            $flight_date_a_new_format = date('Y-m-d H:i', strtotime($flight_date_a));
                            $flights .= "<td>".$flight_date_a_new_format."</td>";

                            //Button for more details
                            $flights .= "<td>    
                                        <form method='post' action='/project/includes/flights.inc.php' display: inline>
                                        <button class='ADD-button' type='submit' name='details-button' value=$id>
                                        More details
                                        </button>
                                        </form> 
                                    </td>";


                            $flights .= "<br>";
                            $flights .= "</tr>";
                        }
                        
                    }
                    
                    $flights .= "</form>"; 
                    echo $flights;
                ?>
            </tbody>
        </table>

    </section>
</div>

<?php
    include_once("../add_ons/footer.php");
?>
