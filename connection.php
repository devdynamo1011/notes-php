<?php
    $server_name = "localhost";
    $user_name = "root";
    $conn_password = "12345678";
    $database = "janumay";
    $conn = new mysqli($server_name,$user_name,$conn_password,$database);

    if($conn->connect_error){
        die("Connection failed: " . mysqli_connect_error());
    }
?>