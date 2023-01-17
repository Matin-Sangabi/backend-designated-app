<?php 
    $connect =  mysqli_connect("localhost" , 'root' , '' , 'designated-app');
    if($connect -> connect_errno) {
        // echo json_encode(["message" => "ارتباط با سرور بر قزار نیست"])
        die("Connection failed: " . $db->connect_error);
    }