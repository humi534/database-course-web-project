<?php
    include_once("./add_ons/header.php");
    include("./includes/dbconn.inc.php");
    include("./add_ons/sidebar.php");
?>

<?php

    //----Card 1 SQL Request-------
    $sql ="SELECT COUNT(immatriculation_number) as nb_vehicles  FROM `vehicle`";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $nb_vehicles = $row['nb_vehicles'];

?>

<div class="main-content">

<h1>Vehicles</h1>

<div class="Maintenance">

<div class="cardBox">
    <div class="card">
        <div>
            <div class="numbers"><?php echo $nb_vehicles;?></div>
            <div class="cardname">Number of Vehicles</div>
        </div>
        <div class="iconBox">
            <i class="fa fa-car" aria-hidden="true"></i>
        </div>
    </div>
</div>

<form class="form-search" action='/project/includes/vehicles.inc.php' method='post'>
        
        <i class="fa fa-search" aria-hidden="true" id="search_icon"></i>
    
        <select name="select-search">
            <option value="immatriculation_number">CODE</option>
            <option value="type"> Type </option>
        </select>
        <input type="text" name="contain-search">
        <button type="submit">SEARCH</button>

        <button type="submit" name="see-all-button">SEE ALL</button>
    </form>
    

<div class="table_and_buttons">
    <head>  
        <meta charset="utf-8"/>
    </head>
    <section class="Vehicles">
        <table class="content-table">
            <thead>
                <tr>
                    <th>Identification code</th>
                    <th>Type</th>
                    <th>Purchase Date</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM `vehicle` LIMIT 5 ";
                    $result = mysqli_query($conn, $sql);
                    $nb_rows = mysqli_num_rows($result);
                    $vehicles ="";
                    if ($nb_rows>0){
                        while ($row = mysqli_fetch_assoc($result)){
                            $immatriculation_number = $row['immatriculation_number'];
                            $vehicles .= "<tr> <td>".$immatriculation_number."</td>"; 
                            $vehicles .= "<td>".$row['type']."</td>"; 
                            $vehicles .= "<td>".$row['purchase_date']."</td>";

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
    include_once("./add_ons/footer.php");
?>
