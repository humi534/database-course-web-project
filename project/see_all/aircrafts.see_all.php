<?php
    include_once("../add_ons/header.php");
    include("../includes/dbconn.inc.php");
    include("../add_ons/sidebar.php");
?>
    
<div class="main-content">
    <h1>Aircrafts - List</h1>

        <section class="Maintenance">
            <table class="content-table center">
                <thead>
                    <tr>
                        <th>Identification code</th>
                        <th>Type</th>
                        <th>Capacity</th>
                        <th>Fuel Level</th>
                        <th>Purchase Date</th>
                        <th>Last maintenance id</th>
                        <th>Date of maintenance</th>
                        <th>Details </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    //SQL Request for a search request
                    if( isset($_GET['select-search']) && isset($_GET['contain-search']) ){

                        $select_search = $_GET['select-search'];
                        $contain = $_GET['contain-search'];

                         // Search
                        $sql = "SELECT * FROM `aircraft` WHERE `$select_search` like '%$contain%'"; 
                        
                    } else {   
                        $sql ="SELECT * FROM `aircraft`";
                        
                    }

                    $result = mysqli_query($conn, $sql);
                    $nb_rows = mysqli_num_rows($result);
                    $aircrafts ="";
                    if ($nb_rows>0){
                        while ($row = mysqli_fetch_assoc($result))
                        {
                            $aircrafts .= "<form action='../includes/aircrafts.inc.php' method='post'>";
                            $sql2 = "SELECT * FROM aircraft_type WHERE name = '".$row['name_aircraft_type']."'";
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($result2);
                            
                            $id = $row['id'];
                            $aircrafts .= "<tr>";
                            
                            //ID
                            $aircrafts .= "<td>".$id."</td>";

                            //Type
                            $aircrafts .= "<td>".$row['name_aircraft_type']."</td>";

                            //Capacity
                            $aircrafts .= "<td>".$row2['capacity']."</td> ";

                            //Fuel_level
                            $aircrafts .= "<td>".$row['fuel_level']."</td> ";

                            //Date Purchased
                            $aircrafts .= "<td>".$row['purchase_date']."</td>";

                            //ID Last Maintenance
                            $sql3 = "SELECT * FROM maintenance WHERE aircraft_id = '".$row['id']."' ORDER BY maintenance.start_date DESC";
                            $result3 = mysqli_query($conn, $sql3);
                            $row3 = mysqli_fetch_assoc($result3);
                            

                            if($row3['id'] == 0){
                                $aircrafts .= "<td>No Maintenance done yet</td>";
                                $aircrafts .= "<td>No maintenance done yet</td>";
                            } elseif (strtotime($row3['end_date']) > time()) {
                                $aircrafts .= "<td>".$row3['id']."</td>";
                                $aircrafts .= "<td>Airplane currently in maintenance </td>";
                            }
                            else {
                                $aircrafts .= "<td>".$row3['id']."</td>";
                                $aircrafts .= "<td>".$row3['start_date']."</td>";
                            }

                            //Details
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
    include_once("../add_ons/footer.php");
?>