<?php 
    require './connection.php';
    require './header.php';

    $postData = file_get_contents("php://input");
    if(!empty($postData)) {
        $request = serialize($postData);
        $sql = "INSERT INTO designated(designated) VALUES ('$request')";
        if(mysqli_query($connect , $sql)) {
            echo json_encode(["success" => true , "message" => "فاکتور فروش اضافه شد"]);
            http_response_code(201);
        }else{
            http_response_code(401);
            die("ناموفق");
        }
    }