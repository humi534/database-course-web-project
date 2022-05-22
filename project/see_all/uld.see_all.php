
<?php
    include_once("../add_ons/header.php");
    include("../includes/dbconn.inc.php");
    include("../add_ons/sidebar.php");
?>
    
<div class="main-content">
    <h1>ULDs - List</h1>

        <section class="Maintenance">
            <table class="content-table center">
                <thead>
                    <tr>
                        <th>Identification code</th>
                        <th>Name</th>
                        <th>Length</th>
                        <th>Width</th>
                        <th>Height</th>
                        <th>Empty Weight</th>
                        <th>Max Gross Weight</th>
                        <th>Volume (in cubic meter)</th>
                        <th>Aircraft Type</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    //SQL Request for a search request
                    if( isset($_GET['select-search']) && isset($_GET['contain-search']) ){

                        $select_search = $_GET['select-search'];
                        $contain = $_GET['contain-search'];

                         // Search
                        $sql = "SELECT * FROM `uld` WHERE `$select_search` like '%$contain%'"; 
                        
                    } else {
                        $sql ="SELECT * FROM `uld`";
                        
                    }
                    $result = mysqli_query($conn, $sql);
                    $nb_rows = mysqli_num_rows($result);
                    $ulds ="";
                    if ($nb_rows>0){
                        while ($row = mysqli_fetch_assoc($result))
                        {
                            $ulds .= "<form action='../includes/ulds.inc.php' method='post'>";
                            $code = $row['code'];
                            $ulds .= "<tr>";
                            
                            //ULD's Code
                            $ulds .= "<td>".$row['code']."</td>";

                            //Name
                            $ulds .= "<td>".$row['name']."</td>";

                            //Length
                            $ulds .= "<td>".$row['length']."</td> ";

                            //Width
                            $ulds .= "<td>".$row['width']."</td> ";

                            //Height
                            $ulds .= "<td>".$row['height']."</td>";

                            //Empty Weight
                            $ulds .= "<td>".$row['empty_weight']."</td>";

                            //Max Gross Weight
                            $ulds .= "<td>".$row['max_gross_weight']."</td>";

                            //Volume
                            $ulds .= "<td>".$row['volume']."</td>";

                            //Aircraft Type
                            $ulds .= "<td>".$row['aircraft_type']."</td>";

                            //Details
                            //Button for more details
                            $ulds .= "<td>    
                            <form method='post' action='/project/includes/aircrafts.inc.php' display: inline>
                            <button class='ADD-button' type='submit' name='details-button' value=$code>More details</button>
                            </form> 
                            </td>";

                            $ulds .= "</tr>";
                            }

                        }
                    echo $ulds;
                ?>
            </tbody>
        </table>

    </section>
</div>

<?php
    include_once("../add_ons/footer.php");
?>
