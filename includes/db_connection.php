<?php

    define("DB_SERVER","localhost");
    define("DB_USER","powlk");
    define("DB_PASS","wndqja855");
    define("DB_NAME","powlk");

    //1. Create a database connection
    $connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

    mysqli_query($connection,'SET NAMES utf8'); 

    // Test if connection occurred
    if(mysqli_connect_errno()){
        die("Database connection failed : " .
            mysqli_connect_error() .
            " (" . mysqli_connect_errno(). ")<br>"
           );
    }
?>
