<?php
require './connection.php';
require './header.php';
$url = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$array = explode("/", $url);
$end = end($array);
$POSTId = (int)$end;
echo $POSTId;
$postData = file_get_contents("php://input");
if (!empty($postData)) {
    if ($POSTId > 0) {
        $request = json_decode($postData);
        $id  = $request->id;
        $des = $request->designated;
        $designated = serialize($des);
        $UpdateSql = "UPDATE designated SET designated = '$designated' WHERE id = '$POSTId'";
        if (mysqli_query($connect, $UpdateSql)) {
            echo json_encode(["success" => true, "message" => "فاکتور فروش اضافه شد"]);
            http_response_code(201);
        } else {
            http_response_code(401);
            die("ناموفق");
        }
    } else {
        $request = json_decode($postData);
        $id  = $request->id;
        $des = $request->designated;
        $designated = serialize($des);
        $sql = "INSERT INTO designated( id ,designated) VALUES ('$id' , '$designated')";
        if (mysqli_query($connect, $sql)) {
            echo json_encode(["success" => true, "message" => "فاکتور فروش اضافه شد"]);
            http_response_code(201);
        } else {
            http_response_code(401);
            die("ناموفق");
        }
    }
}
