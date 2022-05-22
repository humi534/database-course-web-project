<?php
    include_once("add_ons/header.php");
    include("includes/dbconn.inc.php");
    include("add_ons/sidebar.php");
?>

<?php

    //----Card 1 SQL Request-------
    $sql ="SELECT COUNT(code) as nb_ulds  FROM `uld`";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nb_ulds = $row['nb_ulds'];

    //----Card 2 SQL Request-------
    $sql ="SELECT id FROM `flight` WHERE scheduled_departure_time < CURRENT_TIMESTAMP AND scheduled_arrival_time > CURRENT_TIMESTAMP";
    $result = mysqli_query($conn, $sql);
    $nb_rows = mysqli_num_rows($result);
    $currently_used_ulds = 0;
    if ($nb_rows>0){
        while ($row = mysqli_fetch_assoc($result)){
            $sql2 ="SELECT COUNT(id) as count FROM `good` WHERE id_flight = ".$row["id"]."";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $currently_used_ulds += $row2['count'];
        }
    }
?>

<div class="main-content">

<h1>ULD</h1>

<div class="Maintenance">

<div class="cardBox">
    <div class="card">
        <div>
            <div class="numbers"><?php echo $nb_ulds;?></div>
            <div class="cardname">Number of ULDs</div>
        </div>
        <div class="iconBox">
            <i class="fa fa-box" aria-hidden="true"></i>
        </div>
    </div>

    
    <div class="card">
        <div>
            <div class="numbers"><?php echo $currently_used_ulds;?></div>
            <div class="cardname">Number of ULDs currently used</div>
        </div>
        <div class="iconBox">
            <i class="fa fa-plane" aria-hidden="true"></i>
        </div>
    </div>
</div>

<form class="form-search" action='/project/includes/ULDs.inc.php' method='post'>
        
        <i class="fa fa-search" aria-hidden="true" id="search_icon"></i>
    
        <select name="select-search">
            <option value="code">CODE</option>
            <option value="name">Name </option>
            <option value="aircraft_type">Aircraft Type</option>
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
                    $sql = "SELECT * FROM `uld` LIMIT 5";
                    $result = mysqli_query($conn, $sql);
                    $nb_rows = mysqli_num_rows($result);
                    $ulds ="";
                    if ($nb_rows>0){
                        while ($row = mysqli_fetch_assoc($result)){
                            $code  = $row['code'];
                            $ulds .= "<tr> <td>".$row['code']."</td>"; 
                            $ulds .= "<td>".$row['name']."</td>"; 
                            $ulds .= "<td>".$row['length']."</td>";
                            $ulds .= "<td>".$row['width']."</td>";
                            $ulds .= "<td>".$row['height']."</td>";
                            $ulds .= "<td>".$row['empty_weight']."</td>";
                            $ulds .= "<td>".$row['max_gross_weight']."</td>";
                            $ulds .= "<td>".$row['volume']."</td>";
                            $ulds .= "<td>".$row['aircraft_type']."</td>";  

                            //Button for more details
                            $ulds .= "<td>   
                            <form method='post' action='/project/includes/ULDs.inc.php' display: inline>
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
    include_once("add_ons/footer.php");
?>
