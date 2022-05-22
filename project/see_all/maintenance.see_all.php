<?php
    include_once("../add_ons/header.php");
    include("../includes/dbconn.inc.php");
    include("../add_ons/sidebar.php");
?>
    
<div class="main-content">
    <h1>Maintenances - List</h1>
        <section class="Maintenance">
            <table class="content-table center">
                <thead>
                    <tr>
                        <th>code</th>
                        <th>start date</th>
                        <th>end date</th>
                        <th>aircraft code</th>
                        <th>status</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    //SQL Request for a search request
                    if( isset($_GET['select-search']) && isset($_GET['contain-search']) ){

                        $select_search = $_GET['select-search'];
                        $contain = $_GET['contain-search'];

                        $sql = "SELECT * FROM `maintenance` WHERE `$select_search` like '%$contain%'";
                        
                    } else {
                        $sql ="SELECT * FROM `maintenance`";
                        
                    }
                    $result = mysqli_query($conn, $sql);
                    $nb_rows = mysqli_num_rows($result);
                    $maintenances = "<form action='../includes/maintenance.inc.php' method='post'>";
                    if ($nb_rows>0){
                        while ($row = mysqli_fetch_assoc($result)){
                            
                            $id_maintenance = $row['id'];
                            $maintenances   .= "<tr>";
                            
                            //Id
                            $maintenances .= "<td>".$row['id']."</td>";

                            //Maintenance start date
                            $maintenance_date_start = $row['start_date'];
                            $maintenance_date_new_format_start = date('Y-m-d H:i', strtotime($maintenance_date_start));
                            $maintenances .= "<td>".$maintenance_date_new_format_start."</td>";

                            //Maintenance end date
                            $maintenance_date_end = $row['end_date'];
                            if($maintenance_date_end != NULL) {
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

                            $maintenances .= "</tr>";
                        }
                        
                    }
                    
                    $maintenances .= "</form>"; 
                    echo $maintenances;
                ?>
            </tbody>
        </table>

    </section>
</div>

<?php
    include_once("../add_ons/footer.php");
?>
