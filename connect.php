<?php
/*$ser = "localhost";
$user = "root";
$pass = "root";
$db = "Oingo";

$con = mysqli_connect($ser, $user, $pass, $db) or die("connection failed");*/
//echo "connection success";



$user = 'root';
$password = 'root';
$db = 'Oingo';
$host = 'localhost';
$port = 8889;

$con = mysqli_init();
$success = mysqli_real_connect(
   $con,
   $host,
   $user,
   $password,
   $db,
   $port
);
?>