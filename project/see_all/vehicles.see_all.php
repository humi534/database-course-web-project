<?php
    include_once("../add_ons/header.php");
    include("../includes/dbconn.inc.php");
    include("../add_ons/sidebar.php");
?>
    
<div class="main-content">
    <h1>Vehicles - List</h1>

        <section class="Maintenance">
            <table class="content-table center">
                <thead>
                    <tr>
                        <th>Immatriculation Number</th>
                        <th>Type</th>
                        <th>Purchase Date</th>
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
                        $sql = "SELECT * FROM `vehicle` WHERE `$select_search` like '%$contain%'"; 
                        
                    } else {
                        $sql ="SELECT * FROM `vehicle`";
                        
                    }
                    $result = mysqli_query($conn, $sql);
                    $nb_rows = mysqli_num_rows($result);
                    $vehicles ="";
                    if ($nb_rows>0){
                        while ($row = mysqli_fetch_assoc($result))
                        {
                            $vehicles .= "<form action='../includes/vehicles.inc.php' method='post'>";                           
                            $immatriculation_number = $row['immatriculation_number'];
                            $vehicles .= "<tr>";
                            
                            //ID
                            $vehicles .= "<td>".$immatriculation_number."</td>";

                            //Type
                            $vehicles .= "<td>".$row['type']."</td>";

                            //Date Purchased
                            $vehicles .= "<td>".$row['purchase_date']."</td>";

                            //Details
                            //Button for more details
                            $vehicles .= "<td>    
                            <form method='post' action='/project/includes/vehicles.inc.php' display: inline>
                            <button class='ADD-button' type='submit' name='details-button' value=$immatriculation_number>More details</button>
                            </form> 
                            </td>";

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
?>
