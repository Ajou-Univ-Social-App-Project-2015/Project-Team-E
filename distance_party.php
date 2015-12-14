<?php require_once("includes/db_connection.php")?>
<?php require_once("includes/functions.php");?>

<?php
// Start the session
session_start();
?>


<?php

if(isset($_POST['submit_distance'])){  
    
    $curlat = $_POST["curLat"];
    $curlng = $_POST["curLng"];
    $distance = $_POST["distance"];
    $_SESSION["curlat"]=$curlat;
    $_SESSION["curlng"]=$curlng;
    $_SESSION["distance"]=$distance;
    redirect_to("home.php");
}
?>
    


