<?php

$db = new PDO(DSN, DB_USER, DB_PASS);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weblog";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}