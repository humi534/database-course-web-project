<?php
    include_once("../add_ons/header.php");
    include("../includes/dbconn.inc.php");
    include("../add_ons/sidebar.php");
?>

<div class="main-content">
<head>  
        <meta charset="utf-8"/>
</head>
    <h1>Vehicle <?php echo $_GET["immatriculation"] ?>'s Details</h1>
    <section class="Job">
        <?php
            $immatriculation = $_GET["immatriculation"];
            $map = "<a href='http://localhost/project/map.php?display=specific&immatriculation=$immatriculation' title='Map'>";
            $map .="<img class='map'
                src='/project/style/map_update.png'
                alt='Map for the vehicles used'
                width='700' height='345'></a>";
            echo $map;
        ?>
        <table class="content-table">
            <thead> 
                <h1> Vehicles </h1>
                <tr>
                    <th>Immatriculation Number </th>
                    <th>Type</th>
                    <th>Flight's ID </th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Used Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $vehicles ="";
                    $immatriculation = $_GET['immatriculation'];
                    $sql ="SELECT DISTINCT * FROM flight_vehicle WHERE immatriculation_vehicle = '$immatriculation'";
                    $result = mysqli_query($conn, $sql);
                    $nb_rows = mysqli_num_rows($result);
                    
                    if($nb_rows > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            $sql2 = "SELECT DISTINCT * FROM vehicle WHERE immatriculation_number = '$immatriculation'";
                            $result2 = mysqli_query($conn, $sql2);
                            $nb_rows = mysqli_num_rows($result2);
                            $row2 = mysqli_fetch_assoc($result2);

                            // Looking for the flights the vehicle has done
                            $immatriculation_number = $row['immatriculation_vehicle'];

                            $vehicles .= "<tr>";

                            //Immatriculation Number
                            $vehicles .= "<td>".$row['immatriculation_vehicle']."</td>";

                            //Type
                            $vehicles .= "<td>".$row2['type']."</td>";

                            //Flight's ID
                            $vehicles .= "<td>".$row['id_flight']."</td>";
                    

                            //Scheduled Times
                            $vehicles .= "<td>".$row['start_date']. "</td>";

                            $vehicles .= "<td>".$row['end_date']. "</td>";

                            //Used Time
                            $time = strtotime($row['end_date']) - strtotime($row['start_date']);
                            $s = $time%60;
                            $m = floor(($time%3600)/60);
                            $vehicles .= "<td>".$m." Minutes ".$s." Seconds</td>";

                            $vehicles .= "</tr>";
                        }
                    }

                    echo $vehicles;
                ?>
            </tbody>
        </table>
    </section>
</div>

<?php
    include_once("../add_ons/footer.php");
?>  I
