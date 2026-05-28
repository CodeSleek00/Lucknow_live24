<?php

$host = "localhost";
$user = "u298112699_lucknow_live24";
$pass = "Asifali24";
$db   = "u298112699_lucknow_live24";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    die("Database Connection Failed");
}

?>