<?php
require './connection.php';
require './header.php';
$url = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$query = $_SERVER['QUERY_STRING'];
$queryUser = explode("=", $query);
$userName = end($queryUser);
$dbUserName = "designated_" . $userName;
$array = explode("/", $url);
$end = end($array);
$id = (int)$end;

if ($id > 0) {
    $sql = "SELECT * FROM $dbUserName WHERE id = '$id' ";
    $res = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($res);
    if (mysqli_num_rows($res) > 0) {
        $response = unserialize($row['designated']);
        $viewjson['id'] = $row['id'];
        $viewjson['designated'] = $response;
        $array_json = $viewjson;
        echo json_encode($array_json);
        return;
    } else {
        echo json_encode([]);
        return;
    }
} else {
    $sql = "SELECT * FROM $dbUserName";
    $res = mysqli_query($connect, $sql);
    if($res) {
        if(mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $response = unserialize($row['designated']);
                $viewjson['id'] = $row['id'];
                $viewjson['designated'] = $response;
                $array_json[] = $viewjson;
            }
            echo json_encode($array_json);
            return;
        }else{
            $json = [];
            echo json_encode($json);
            return;
        }
            
    }
}
