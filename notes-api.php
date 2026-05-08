<?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        header("Content-Type: application/json");
        
        include('connection.php');
        $sql = "SELECT * FROM notes";
        $result = mysqli_query($conn,$sql);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(["notes" => $rows]);
    }
?>