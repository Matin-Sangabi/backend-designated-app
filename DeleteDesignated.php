<?php
require './connection.php';
require './header.php';
$url = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$array = explode("/", $url);
$end = end($array);
$id = (int)$end;
if ($id > 0) {
    $selectSql = "SELECT * FROM designated WHERE id = '$id'";
    $row = mysqli_query($connect, $selectSql);
    $res = mysqli_fetch_assoc($row);
    $des  = unserialize($res['designated']);
    $salesInvoicesId = $des->salesInvoices;
    $salesId = "c835e804-0aa3-cbc4-4569-d1c3e968998f";
    $sales = findObjectById($salesInvoicesId, $salesId);
    if ($sales == false) {
        $salesInvoicesId = [];
    } else {
        $salesInvoicesId = $sales;
    }
    $des->salesInvoices = $salesInvoicesId;
    var_dump($des);

    // $sql = "DELETE FROM designated WHERE id = '$id'";
    // if(mysqli_query($connect , $sql)) {
    //     echo json_encode(["success" => true , "message"  => "فاکتور پاک شد"]);
    //     http_response_code(201);
    //     return;
    // }else{
    //     echo json_encode(["success" => false , "message"  => "error message"]);
    //     http_response_code(402);
    //     return;
    // }
}

function findObjectById($salesInvoicesId, $id)
{
    foreach ($salesInvoicesId as $element) {
        if ($id !== $element->id) {
            return $element;
        }
    }
    return false;
}
