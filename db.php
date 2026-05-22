<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$dbname = "arrow_ticket";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}
$conn->set_charset("utf8");
?>