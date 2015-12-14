<?php require_once("includes/db_connection.php")?>
<?php require_once("includes/functions.php");?>


<?php
//insert data from form to table when make party submit
if(isset($_POST['removesubmit'])){  
    
    $id = $_POST["saveid"];

    //2. Perform database query
    $query = "DELETE FROM party ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";

    $result = mysqli_query($connection,$query);//get resource

    if($result && mysqli_affected_rows($connection) == 1){
        //success
        redirect_to("home.php");
    }else{
        //Failure
        //$message = "party delete failed";
        die("db query failed. " . mysqli_error($connection));
    }
    
}
?>
    

<?php 
    // Close databse connection
    mysqli_close($connection);

?>

