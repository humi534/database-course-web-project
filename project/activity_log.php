<?php
    include_once("./add_ons/header.php");
    include("./includes/dbconn.inc.php");
    include("./add_ons/sidebar.php");
?>

<?php
    $month = date('m');
    $day = date('d');
    $year = date('Y');

    $today = $year . '-' . $month . '-' . $day. 'T12:00';
?>

<div class="main-content">
    <h1>ACTIVITY LOG</h1>
    <form class="form-activity" action='activity_log_tables.php' method='post'>
        <label>Get activities of ASL from </label>
        <label>FROM</label>
        <input type="datetime-local" name="datetime-from" value="<?php echo $today; ?>"/>
        <label>TO</label>
        <input type="datetime-local" name="datetime-to" value="<?php echo $today; ?>"/>
        <input type="submit"/>
</form>

</div>

<?php
    include_once("./add_ons/footer.php");
?>
