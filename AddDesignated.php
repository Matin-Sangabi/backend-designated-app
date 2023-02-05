<?php
require './connection.php';
require './header.php';
$url = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$array = explode("/", $url);
$end = end($array);
$POSTId = (int)$end;
$postData = file_get_contents("php://input");
if (!empty($postData)) {
    if ($POSTId > 0) {
        $request = json_decode($postData);
        $id  = $request->id;
        $des = $request->designated;
        $designated = serialize($des);
        $UpdateSql = "UPDATE designated SET designated = '$designated' WHERE id = '$POSTId'";
        if (mysqli_query($connect, $UpdateSql)) {
            $selectSql = "SELECT * FROM designated WHERE id = '$POSTId'";
            $res = mysqli_query($connect, $selectSql);
            $row = mysqli_fetch_assoc($res);
            if (mysqli_num_rows($res) > 0) {
                $response = unserialize($row['designated']);
                $viewjson['id'] = $row['id'];
                $viewjson['designated'] = $response;
                $array_json = $viewjson;
                echo json_encode($array_json);
                return;
            }
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
            $selectSql = "SELECT * FROM designated";
            $res = mysqli_query($connect, $selectSql);
            while ($row = mysqli_fetch_assoc($res)) {
                $response = unserialize($row['designated']);
                $viewjson['id'] = $row['id'];
                $viewjson['designated'] = $response;
                $array_json[] = $viewjson;
            }
            echo json_encode($array_json);
            return;
        } else {
            $json = [];
            echo json_encode($json);
            return;
        }
    }
}
