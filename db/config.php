<?php
$host = "switchyard.proxy.rlwy.net";
$port = 11071;
$user = "root";
$pass = "ArbOFnCtxHMGgjPjumlwxoPJplCazMJg";
$db   = "railway";

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>