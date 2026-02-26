<?php
$conn = new mysqli(
    getenv("DB_HOST"),
    getenv("DB_USER"),
    getenv("DB_PASSWORD"),
    getenv("DB_NAME"),
    getenv("DB_PORT")
);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>