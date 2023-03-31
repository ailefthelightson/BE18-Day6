<?php

$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "crud_with_login";

$connect = new mysqli($localhost, $username,$password,$dbname);

if($connect->connect_error){
    die("connection failed: " . $connect->connect_error);
} else{
   echo "connected just fine";
}
