<?php
    include_once("./add_ons/header.php");
    include("./includes/dbconn.inc.php");
    include("./add_ons/sidebar.php");
?>

<?php

    //----Card 1 SQL Request-------
    $sql ="SELECT COUNT(id) as nb_completed FROM `maintenance` WHERE status='completed'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nb_completed = $row['nb_completed'];

    //----Card 2 SQL Request-------
    $sql ="SELECT COUNT(id) as nb_current FROM `maintenance` WHERE status ='in progress' OR status='warning'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nb_current = $row['nb_current'];

    //----Card 3 SQL Request-------
    $sql ="SELECT COUNT(id) as nb_warnings FROM `maintenance` WHERE status='warning'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nb_warnings = $row['nb_warnings'];


?>
    
<div class="main-content">

    <h1>Overview</h1>

    <div class="cardBox">
        <div class="card">
            <div>
                <div class="numbers"><?php echo $nb_completed; ?></div>
                <div class="cardname">success maintenances</div>
            </div>
            <div class="iconBox">
                <i class="fa fa-check" aria-hidden="true"></i>
            </div>
        </div>
        
        <div class="card">
            <div>
                <div class="numbers"><?php echo $nb_current; ?></div>
                <div class="cardname">Current maintenances</div>
            </div>
            <div class="iconBox">
                <i class="fa fa-eye" aria-hidden="true"></i>
            </div>
        </div>
        
        <div class="card">
            <div>
                <div class="numbers"><?php echo $nb_warnings; ?></div>
                <div class="cardname">Warnings</div>
            </div>
            <div class="iconBox">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            </div>
        </div>
        
        
    </div>


    <h1>Maintenances</h1>
    <div class="Maintenance">
        <form class="form-search" action='/project/includes/maintenance.inc.php' method='post'>
        
            <i class="fa fa-search" aria-hidden="true" id="search_icon"></i>
        
            <select name="select-search">
                <option value="id">CODE</option>
                <option value="start_date">START DATE</option>
                <option value="end_date">END DATE</option>
                <option value="aircraft_id">AIRCRAFT CODE</option>
                <option value="status">STATUS</option>
            </select>
            <input type="text" name="contain-search">
            <button type="submit">SEARCH</button>
            <button type="submit" name="see-all-button">SEE ALL</button>
        </form>

        <div class="table_and_buttons">
            <table class="content-table">
                <thead>
                    <tr>
                        <th>code</th>
                        <th>start date</th>
                        <th>end date</th>
                        <th>aircraft code</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql ="SELECT * FROM `maintenance` limit 4";
                        $result = mysqli_query($conn, $sql);
                        $nb_rows = mysqli_num_rows($result);
                        $maintenances ="";
                        if ($nb_rows>0){
                            while ($row = mysqli_fetch_assoc($result)){
                                $maintenances .= "<tr>";
                                $maintenances .= "<td>".$row['id']."</td>";

                                //Maintenance Start date
                                $maintenance_date = $row['start_date'];
                                $maintenance_date_new_format = date('Y-m-d H:i', strtotime($maintenance_date));
                                $maintenances .= "<td>".$maintenance_date_new_format."</td>";

                                //Maintenance End date
                                $maintenance_date_end = $row['end_date'];
                                if($maintenance_date_end != NULL){
                                    $maintenance_date_new_format_end = date('Y-m-d H:i', strtotime($maintenance_date_end));
                                    $maintenances .= "<td>".$maintenance_date_new_format_end."</td>";
                                } else {
                                    $maintenances .= "<td>Not yet finished</td>";
                                }
                                
                                //Maintenance aircraft
                                $maintenances .= "<td>".$row['aircraft_id']."</td>";

                                //Maintenance status
                                if ($row['status'] == "completed"){
                                    $maintenances .= "<td> <p class='status status-completed'>".$row['status']."</p></td>";
                                }

                                else if ($row['status'] == "in progress"){
                                    $maintenances .= "<td> <p class='status status-inprogress'>".$row['status']."</p></td>";
                                }

                                else if ($row['status'] == "not yet started"){
                                    $maintenances .= "<td> <p class='status status-notyetstarted'>".$row['status']."</p></td>";
                                }

                                else if ($row['status'] == "warning"){
                                    $maintenances .= "<td> <p class='status status-warning'>".$row['status']."</p></td>";
                                }

                                else {
                                    $maintenances .= "<td>".$row['status']."</td>";
                                }

                            }
                        }
                        echo $maintenances;
                    ?>
                </tbody>
            </table>
        </div>
    
    </div>
</div>

<?php
    include_once("./add_ons/footer.php");
?>