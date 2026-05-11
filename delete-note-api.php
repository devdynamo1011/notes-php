<?php
    if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

        header("Content-Type: application/json");
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);
        $id = $data['id'];

        include('connection.php');
        $sql = "DELETE FROM notes WHERE id = '$id'";
        if(mysqli_query($conn,$sql)){
            echo json_encode([
                "message"=>"Note deleted successfully",
                "status"=>true
            ]);
        }else{
            echo json_encode(["message"=>"Some error","status"=>false]);
        }
    }
?>