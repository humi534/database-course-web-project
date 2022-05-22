<?php
    include_once("../add_ons/header.php");
    include("../includes/dbconn.inc.php");
    include("../add_ons/sidebar.php");
?>

<div class="main-content">
<head>  
        <meta charset="utf-8"/>
</head>
    <h1>ULD <?php echo $_GET["code"] ?>'s Details</h1>
    <section class="Job">
    <?php
            $ULD_code = $_GET["code"];
            $map = "<a href='http://localhost/project/map.php?display=specific&ULD_code=$ULD_code' title='Map'>";
            $map .="<img class='map'
                src='/project/style/map_update.png'
                alt='Map for the vehicules used'
                width='700' height='345'></a>";
            echo $map;
        ?>
        <table class="content-table">
            <thead>
                <tr>
                <th>ULD Code</th>
                <th>Good Transported</th>
                <th>Flight ID Used On</th>
                <th>ULD Position</th>
                <th>ULD Security</th>
                <th>ULD Weight</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $uld ="";
                        $sql ="SELECT DISTINCT * FROM good WHERE ".$_GET['code']." = id_ULD";
                        $result = mysqli_query($conn, $sql);
                        $nb_rows = mysqli_num_rows($result);

                        if($nb_rows>0)
                        {
                            while($row = mysqli_fetch_assoc($result)){

                                // Looking for the flights the ULD has done and goods transported
                                $uld .= "<tr>";
                                
                                // ULD's Code
                                $uld .= "<td>".$row['id_ULD']."</td>";

                                // Good Transported
                                $uld .= "<td>".$row['id']. "</td>";

                                // Flight used on
                                $uld .= "<td>".$row['id_flight']. "</td>";

                                // ULD Position
                                $uld .= "<td>".$row['ULD_position']. "</td>";

                                // ULD Security
                                $uld .= "<td>".$row['secure']. "</td>";

                                // ULD Weight
                                $uld .= "<td>".$row['weight']. "</td>";
                      

                                $uld .= "</tr>";
                            }
                        }

                    echo $uld;
                ?>
            </tbody>
        </table>
    </section>
</div>

<?php
    include_once("../add_ons/footer.php");
?>  I
