<?php
require './connection.php';
require './header.php';
$postData = file_get_contents("php://input");
if (!empty($postData)) {
    $request = json_decode($postData);
    $name = $request->name;
    $email = $request->email;
    $pass = $request->password;
    $password = sha1($pass);
    $sql = "INSERT INTO users (name , email , password) VALUES ('$name' , '$email' , '$password')";
    if (mysqli_query($connect, $sql)) {
        echo json_encode(["success" => true, "message" => "کاربر اضافه شد"]);
        http_response_code(201);
    } else {
        http_response_code(402);
    }
}
