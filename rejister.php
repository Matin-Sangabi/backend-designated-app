<?php
require './connection.php';
require './header.php';
$postData = file_get_contents("php://input");
if (!empty($postData)) {
    $request = json_decode($postData);
    $name = $request->name;
    $email = $request->email;
    $registerEmail = "SELECT * FROM users WHERE email = '$email'";
    $registerRes = mysqli_query($connect , $registerEmail);
    if(mysqli_fetch_assoc($registerRes)) {
        http_response_code(402);
        die(" ایمیل وجود  دارد.");
    }
    $pass = $request->password;
    $password = sha1($pass);
    $sql = "INSERT INTO users (name , email , password) VALUES ('$name' , '$email' , '$password')";
    if (mysqli_query($connect, $sql)) {
        $returnSql = "SELECT *FROM users WHERE email = '$email'";
        $res = mysqli_query($connect , $returnSql);
        $row = mysqli_fetch_assoc($res);
        echo json_encode(["success" => true, "message" => "کاربر اضافه شد" , "userList" => $row]);
        http_response_code(201);
    } else {
        http_response_code(402);
        die("error message code 402");
    }
}
