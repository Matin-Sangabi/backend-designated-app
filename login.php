<?php
require "./connection.php";
require "./header.php";
$postData = file_get_contents("php://input");
if (!empty($postData)) {
    $request = json_decode($postData);
    $email = $request->email;
    $password = $request->password;
    $sql = "SELECT *FROM users WHERE email = '$email'";

    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        if (sha1($password) == $row['password']) {
            echo json_encode(["success" => true, "userList" => $row]);
        } else {
            http_response_code(402);
            die("ایمیل یا رمز عبور اشتباه است");
        }
    } else {
        http_response_code(402);
        die("ایمیل یا رمز عبور اشتباه است");
    }
}
