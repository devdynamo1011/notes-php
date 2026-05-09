<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        header("Content-Type: application/json");
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);
        $note = $data['note'];

        include('connection.php');
        $sql = "INSERT INTO notes (note) value ('$note')";
        if(mysqli_query($conn,$sql)){
            $last_id = mysqli_insert_id($conn);
            echo json_encode([
                "message"=>"Note added successfully",
                "status"=>true, 
                "last_id" => $last_id
            ]);
        }else{
            echo json_encode(["message"=>"Some error","status"=>false]);
        }
    }
?>