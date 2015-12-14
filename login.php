<?php session_start();?>
<?php require_once("includes/db_connection.php")?>
<?php require_once("includes/functions.php");?>
<?php
if (isset($_POST['login'])){
    
    $username = $_POST["userId"];
    $password = $_POST["userPw"];
    
    $found_amdin = attempt_login($username,$password);
    
    if($found_amdin){
        //succes
        $_SESSION["admin_id"]=$found_amdin["id"];
        $_SESSION["username"]=$found_amdin["username"];
        redirect_to("home.php");
    }else{
        //failure
        $_SESSION["message"] = "username or password not found";
        redirect_to("index.php");
    }
    
}


?>