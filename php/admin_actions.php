<?php
session_start();
require '../db/config.php';

if (!isset($_SESSION['username']) || $_SESSION['category'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'add') {
        $username = $_POST['username'];
        $password = $_POST['password']; // plain text (as you want)
        $category = $_POST['category'];

        $stmt = $conn->prepare(
            "INSERT INTO users (username, password, category) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $username, $password, $category);
        $stmt->execute();
    }

    if ($_POST['action'] === 'edit') {
        $username = $_POST['username'];
        $category = $_POST['category'];

        $stmt = $conn->prepare(
            "UPDATE users SET category=? WHERE username=?"
        );
        $stmt->bind_param("ss", $category, $username);
        $stmt->execute();
    }

    if ($_POST['action'] === 'delete') {
        $username = $_POST['username'];

        if ($username !== $_SESSION['username']) {
            $stmt = $conn->prepare(
                "DELETE FROM users WHERE username=?"
            );
            $stmt->bind_param("s", $username);
            $stmt->execute();
        }
    }
}

header("Location: admin_dashboard.php");
exit();