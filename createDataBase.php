<?php
function createTable($name) {
    require "./connection.php";
    $sal = "CREATE TABLE $name (
        id TEXT , 
        designated TEXT
    )";
   return mysqli_query($connect , $sal);
}
