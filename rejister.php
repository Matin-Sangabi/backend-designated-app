<?php
require './connection.php';
require './header.php';
require './createDataBase.php';
$postData = file_get_contents("php://input");
if (!empty($postData)) {
    $request = json_decode($postData);
    $name = $request->name;
    $userName = $request->userName;
    $email = $request->email;
    
    $registerEmail = "SELECT * FROM users WHERE email = '$email'";
    $registerRes = mysqli_query($connect, $registerEmail);
    if (mysqli_fetch_assoc($registerRes)) {
        http_response_code(402);
        die(" این کاربر با این مشصخات قبلا ثبت نام کرده است.");
    }
    $pass = $request->password;
    $password = sha1($pass);
    $sql = "INSERT INTO users (name , email , userName,  password) VALUES ('$name' , '$email' , '$userName' , '$password')";
    $tableName = "designated_".$userName;
    createTable($tableName);
    if (mysqli_query($connect, $sql)) {
        $returnSql = "SELECT *FROM users WHERE email = '$email'";
        $res = mysqli_query($connect, $returnSql);
        $row = mysqli_fetch_assoc($res);
        echo json_encode(["success" => true, "message" => "کاربر اضافه شد", "userList" => $row]);
        http_response_code(201);
    } else {
        http_response_code(402);
        die("error message code 402");
    }
}
