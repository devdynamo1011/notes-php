<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        header("Content-Type: application/json");
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);
        $search = $data['search'];

        include('connection.php');
        $sql = "SELECT * FROM notes WHERE note LIKE '%$search%'";
        $result = mysqli_query($conn,$sql);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(["notes" => $rows]);
    }
?>