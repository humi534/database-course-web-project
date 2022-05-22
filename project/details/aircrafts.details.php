<?php
    include_once("../add_ons/header.php");
    include("../includes/dbconn.inc.php");
    include("../add_ons/sidebar.php");
?>

<div class="main-content">
<head>  
        <meta charset="utf-8"/>
</head>
    <h1>Aircraft <?php echo $_GET["id"] ?>'s Details</h1>
    <section class="Job">
    <?php
            $id_aircraft = $_GET["id"];
            $map = "<a href='http://localhost/project/map.php?display=specific&id_aircraft=$id_aircraft' title='Map'>";
            $map .="<img class='map'
                src='/project/style/map_update.png'
                alt='Map for the vehicules used'
                width='700' height='345'></a>";
            echo $map;
        ?>
        <table class="content-table">
            <thead> 
                <h1> Flights </h1>
                <tr>
                    <th>Aircraft's ID</th>
                    <th>Flight's ID </th>
                    <th>From</th>
                    <th>To</th>
                    <th>Gate's ID</th>
                    <th>Departure Time </th>
                    <th>Arrival Time </th>
                    <th>Vehicles </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $flights ="";
                        $sql ="SELECT DISTINCT * FROM flight WHERE ".$_GET['id']." = id_aircraft";
                        $result = mysqli_query($conn, $sql);
                        $nb_rows = mysqli_num_rows($result);

                        if($nb_rows>0)
                        {
                            while($row = mysqli_fetch_assoc($result)){
                                // Looking for the flights the aircraft has done
                                $flight_id = $row['id'];

                                $flights .= "<tr>";

                                //Aircraft's ID
                                $flights .= "<td>".$row['id_aircraft']."</td>";
                                
                                //Flight's ID
                                $flights .= "<td>".$row['id']."</td>";


                                //Departure
                                $flights .= "<td>".$row['airport_departure'];

                                //Arrival
                                $flights .= "<td>".$row['airport_arrival']."";

                                //Gate's ID
                                $flights .= "<td>".$row['id_gate']. "</td>";

                                //Scheduled Times
                                $flights .= "<td>".$row['scheduled_departure_time']. "</td>";

                                $flights .= "<td>".$row['scheduled_arrival_time']. "</td>";

                                //Vehicles 
                                
                                $sql2 ="SELECT DISTINCT * FROM flight_vehicle WHERE ".$row['id']." = id_flight";
                                $result2 = mysqli_query($conn, $sql2);
                                $nb_rows2 = mysqli_num_rows($result2);

                                if($nb_rows2>0)
                                {
                                    $flights .= "<td> ";
                                    while($row2 = mysqli_fetch_assoc($result2)){
                                        $flights .= " ".$row2['immatriculation_vehicle'].", ";
                                    }
                                    $flights .= " </td>";
                                }
                                
                                $flights .= "</tr>";
                            }
                        }

                    echo $flights;
                ?>
            </tbody>
        </table>
    </section>
    <section class="Job">
        <table class="content-table">
            <thead> 
                <h1>Maintenances</h1>
                <tr>
                    <th>Aircraft's ID</th>
                    <th>Maintenance's ID </th>
                    <th>Start Time </th>
                    <th>End Time </th>
                    <th>Status </th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $maintenance ="";
                        $sql ="SELECT DISTINCT * FROM maintenance WHERE ".$_GET['id']." = aircraft_id";
                        $result = mysqli_query($conn, $sql);
                        $nb_rows = mysqli_num_rows($result);

                        if($nb_rows>0)
                        {
                            while($row = mysqli_fetch_assoc($result)){

                                // Looking for the maintenance the aircraft has done
                                $maintenance .= "<tr>";
                                
                                //Aircraft's ID
                                $maintenance .= "<td>".$row['aircraft_id']."</td>";

                                //Maintenance's ID
                                $maintenance .= "<td>".$row['id']."</td>";

                                //Start Date
                                $maintenance .= "<td>".$row['start_date'];

                                //End Date
                                $maintenance .= "<td>".$row['end_date']."";

                                //Maintenance's Status
                                $maintenance .= "<td>".$row['status']."";

                                $maintenance .= "</tr>";
                            }
                        }

                    echo $maintenance;
                ?>
            </tbody>
        </table>

    </section>
</div>

<?php
    include_once("../add_ons/footer.php");
?>  I
