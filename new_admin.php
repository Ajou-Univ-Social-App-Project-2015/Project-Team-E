<?php require_once("includes/db_connection.php")?>
<?php require_once("includes/functions.php");?>


<?php
if (isset($_POST['regSubmit'])){
    $username = $_POST["uid"];
    $hashed_password = $_POST["password"];

    $query = "INSERT INTO admins (";
    $query .= "username,hashed_password";
    $query .= ") VALUES (";
    $query .= "'{$username}','{$hashed_password}'";
    $query .= ")";
    $result = mysqli_query($connection,$query);
    
    if($result){
        //success
        $_SESSION["message"] = "Admin created.";
        redirect_to("index.php");
    }else{
        //fail
        $_SESSION["message"] = "Admin creation failed.";
    }
    
}


?>