<?php
require './connection.php';
require './header.php';
$url = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$array = explode("/", $url);
$end = end($array);
$id = (int)$end;

if ($id > 0) {
    $sql = "SELECT * FROM designated WHERE id = '$id' ";
    $res = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($res);
    if (mysqli_num_rows($res) > 0) {
        $response = unserialize($row['designated']);
        $viewjson['id'] = $row['id'];
        $viewjson['designated'] = $response;
        $array_json[] = $viewjson;
        echo json_encode($array_json);
        return;
    } else {
        echo json_encode("کاربری با این مشخصات وجود ندارد");
    }
} else {
    $sql = "SELECT * FROM designated";
    $res = mysqli_query($connect, $sql);
    if (mysqli_num_rows($res) > 0) {
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
    }
}
