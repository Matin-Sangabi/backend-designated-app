<?php
require './connection.php';
require './header.php';
$url = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$query = $_SERVER['QUERY_STRING'];
$queryId = explode("=", $query);
$uid = end($queryId);
$array = explode("/", $url);
$end = end($array);
$id = (int)$end;
if ($id > 0) {
    $selectSql = "SELECT * FROM designated WHERE id = '$id'";
    $row = mysqli_query($connect, $selectSql);
    $res = mysqli_fetch_assoc($row);
    $des  = unserialize($res['designated']);
    $salesInvoicesId = $des->salesInvoices;
    $sales = findObjectById($salesInvoicesId, $uid);
    if ($sales == false) {
        $salesInvoicesId = [];
    } else {
        $salesInvoicesId = $sales;
    }
    $des->salesInvoices = $salesInvoicesId;
    $viewJson['id'] = (string)$id;
    $viewJson['designated'] = $des;
    $designatedApi = $viewJson;
    $designated = serialize($des);
    $sql = "UPDATE designated SET designated = '$designated' WHERE id = '$id'";
    if (mysqli_query($connect, $sql)) {
        echo json_encode($designatedApi);
        http_response_code(201);
        return;
    } else {
        echo json_encode(["success" => false, "message"  => "error message"]);
        http_response_code(402);
        return;
    }
}

function findObjectById($salesInvoicesId, $id)
{
    $name = [];
    foreach ($salesInvoicesId as $element) {
        if ($id !== $element->id) {
            $name[] =  $element;
        }
    }
    return $name;
}
