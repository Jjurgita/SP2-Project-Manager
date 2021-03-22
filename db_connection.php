<?php

$servername = "127.0.0.1"; // localhost
$username = "root"; // default 
$password = "mysqlroot";
$dbname = "sprint2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Chech if successfully connected
if (!$conn) {
    die("Connection failed:" . mysqli_connect_error());
}
