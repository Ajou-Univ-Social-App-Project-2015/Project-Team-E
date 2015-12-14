<?php require_once("includes/db_connection.php")?>
<?php require_once("includes/functions.php");?>
    <?php session_start();?>

<?php
//insert data from form to table when make party submit
if(isset($_POST['attendsubmit'])){  

    $myID = $_SESSION['username'].',';
    $id = $_POST['enrollId'];
        
        
    $query = "UPDATE party SET ";
    $query .= "members = CONCAT( party.members,'{$myID}' ) ";
    $query .= "WHERE id = {$id}";

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

?>