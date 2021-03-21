<?php

$servername = "127.0.0.1"; // change to your own server name, for example "localhost"
$username = "root"; // default user 
$password = "mysqlroot"; // add your own server password
$dbname = "sprint2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Chech if successfully connected
if (!$conn) {
    die("Connection failed:" . mysqli_connect_error());
}
