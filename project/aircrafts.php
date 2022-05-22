<?php
    include_once("./add_ons/header.php");
    include("./includes/dbconn.inc.php");
    include("./add_ons/sidebar.php");
?>

<?php

    //----Card 1 SQL Request-------
    $sql ="SELECT COUNT(id) as nb_aircrafts  FROM `aircraft`";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nb_aircrafts = $row['nb_aircrafts'];

    //----Card 2 SQL Request-------
    $sql ="SELECT COUNT(DISTINCT(id_aircraft)) as currently_used_aircrafts  FROM `flight` WHERE scheduled_departure_time < CURRENT_TIMESTAMP AND scheduled_arrival_time > CURRENT_TIMESTAMP";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $currently_used_aircrafts = $row['currently_used_aircrafts'];

    //----Card 3 SQL Request-------
    $sql ="SELECT COUNT(DISTINCT(aircraft_id)) as currently_maintainanced_aicrafts  FROM `maintenance` WHERE status = 'in progress'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $currently_maintainanced_aicrafts = $row['currently_maintainanced_aicrafts'];

    //----Card 4 SQL Request-------
    $sql ="SELECT * FROM `flight` WHERE scheduled_departure_time < CURRENT_TIMESTAMP AND scheduled_arrival_time > CURRENT_TIMESTAMP";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $dep = $row['airport_departure'];
    $arr = $row['airport_arrival']
;
?>

<div class="main-content">

<h1>Aircrafts</h1>

<div class="Maintenance">

<div class="cardBox">
    <div class="card">
        <div>
            <div class="numbers"><?php echo $nb_aircrafts;?></div>
            <div class="cardname">Number of aircrafts</div>
        </div>
        <div class="iconBox">
            <i class="fa fa-plane" aria-hidden="true"></i>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers"><?php echo $currently_used_aircrafts;?></div>
            <div class="cardname">Number of aircrafts currently used</div>
        </div>
        <div class="iconBox">
            <i class="fa fa-plane" aria-hidden="true"></i>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers"><?php echo $currently_maintainanced_aicrafts;?></div>
            <div class="cardname">Number of aircrafts currently maintained</div>
        </div>
        <div class="iconBox">
            <i class="fa fa-tools" aria-hidden="true"></i>
        </div>
    </div>
    
    
    <div class="card">
        <div>
            <div class="numbers"><?php echo $dep."-".$arr; ?></div>
            <div class="cardname" aria-hidden="true">Current Flight</div>
        </div>
        <div class="iconBox">
            <i class="fa fa-users"></i>
        </div>
    </div>
</div>

<form class="form-search" action='/project/includes/aircrafts.inc.php' method='post'>
        
        <i class="fa fa-search" aria-hidden="true" id="search_icon"></i>
    
        <select name="select-search">
            <option value="id">CODE</option>
            <option value="name_aircraft_type"> Type </option>
            <option value="purchase_date">Purchase Date</option>
            <option value="fuel_level">Fuel Level</option>
        </select>
        <input type="text" name="contain-search">
        <button type="submit">SEARCH</button>

        <button type="submit" name="see-all-button">SEE ALL</button>
    </form>
    

<div class="table_and_buttons">
    <head>  
        <meta charset="utf-8"/>
    </head>
    <section class="Aircraft">
        <table class="content-table">
            <thead>
                <tr>
                    <th>Identification code</th>
                    <th>Type</th>
                    <th>Fuel Level</th>
                    <th>Purchase Date</th>
                    <th>Last maintenance id</th>
                    <th>Date of maintenance</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM `aircraft` LIMIT 5 ";
                    $result = mysqli_query($conn, $sql);
                    $nb_rows = mysqli_num_rows($result);
                    $aircrafts ="";
                    if ($nb_rows>0){
                        while ($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $aircrafts .= "<tr> <td>".$id."</td>"; 
                            $aircrafts .= "<td>".$row['name_aircraft_type']."</td>"; 
                            $aircrafts .= "<td>".$row['fuel_level']."</td>";
                            $aircrafts .= "<td>".$row['purchase_date']."</td>";
                            
                            // Maintenances informations
                            $sql2 = "SELECT * FROM maintenance WHERE aircraft_id = '".$row['id']."' ORDER BY maintenance.start_date DESC";
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($result2);
                            
                            $aircrafts .= "<td>".$id."</td>";
                            
                            $id_maintenance = $row2['id'];
                            if($id_maintenance == 0){
                                $aircrafts .= "<td>No maintenance done yet</td>";
                            } elseif (strtotime($row2['end_date']) > time()) {
                                $aircrafts .= "<td>Airplane currently in maintenance </td>";
                            }
                            
                            else {
                                $aircrafts .= "<td>".$row2['start_date']."</td>";
                            }

                            // Button for more details
                            $aircrafts .= "<td>   
                            <form method='post' action='/project/includes/aircrafts.inc.php' display: inline>
                            <button class='ADD-button' type='submit' name='details-button' value=$id>More details</button>
                            </form> 
                            </td>";

                            $aircrafts .= "</tr>";
                            
                        }
                    }
                    echo $aircrafts;
                ?>
            </tbody>
        </table>
    </section>   
</div>

<?php
    include_once("./add_ons/footer.php");
?>
