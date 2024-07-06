<?php
$server_name = "localhost";
$username = "root";
$password = "";
$dbname = "registration";

$conn = new mysqli($server_name, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection Failed: ". $conn->connect_error);
}
?>