<?php require_once("includes/db_connection.php")?>
<?php require_once("includes/functions.php");?>
<?php session_start();?>

<?php
//insert data from form to table when make party submit
if(isset($_POST['submit'])){  
   $myID = $_SESSION['username'];

       
    $interests_i = $_POST["inter"];
    $loc_exp_i = $_POST["location"];
    $loc_i = $_POST["saveloc"];
    $name_i = $_POST["partytitle"];
    $exp_i=$_POST["partydetail"];
    $date_i = $_POST["partydate"];
    $mem_limit_i =(int)$_POST["slider"];
    $master_i =$myID;
    $visible_i = 1;
    $members_i = $myID.",";

    $in ="INSERT INTO party (";
    $in .= " interests,loc_exp,loc,name,exp,date,mem_limit,master,members";
    $in .= ")";
    $in .= " VALUES (";
    $in .= " '{$interests_i}','$loc_exp_i','$loc_i','$name_i','$exp_i','$date_i',$mem_limit_i,'$myID','$members_i'";
    $in .= ")";

    $insert_result = mysqli_query($connection,$in);
    
    if(!$insert_result){
         die("query failed.<br>");
    }else{
        redirect_to("home.php");
    }



}
?>



<?php 
    // Close databse connection
    mysqli_close($connection);

?>

