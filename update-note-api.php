<?php
    if ($_SERVER['REQUEST_METHOD'] == "PATCH") {

        header("Content-Type: application/json");
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);
        $id = $data['id'];
        $note = $data['note'];

        include('connection.php');
        $sql = "UPDATE notes SET note = '$note' WHERE id = '$id'";
        if(mysqli_query($conn,$sql)){
            echo json_encode([
                "message"=>"Note updated successfully",
                "status"=>true
            ]);
        }else{
            echo json_encode(["message"=>"Some error","status"=>false]);
        }
    }
?>