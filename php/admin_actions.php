<?php
session_start();
require '../db/config.php';

// Allow only admin
if (!isset($_SESSION['username']) || $_SESSION['category'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    /* ================= ADD USER ================= */
    if ($_POST['action'] === 'add') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $category = $_POST['category'];

        if ($username === '' || $password === '') {
            $_SESSION['error'] = "Username and password cannot be empty";
        } else {
            // Check duplicate username
            $check = $conn->prepare("SELECT id FROM users WHERE username=?");
            $check->bind_param("s", $username);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $_SESSION['error'] = "Username already exists!";
            } else {
                $stmt = $conn->prepare(
                    "INSERT INTO users (username, password, category) VALUES (?, ?, ?)"
                );
                $stmt->bind_param("sss", $username, $password, $category);
                $stmt->execute();

                $_SESSION['success'] = "User added successfully!";
            }
        }
    }

    /* ================= EDIT ROLE ================= */
    if ($_POST['action'] === 'edit') {
        $username = $_POST['username'];
        $category = $_POST['category'];

        $stmt = $conn->prepare(
            "UPDATE users SET category=? WHERE username=?"
        );
        $stmt->bind_param("ss", $category, $username);
        $stmt->execute();

        $_SESSION['success'] = "Role updated successfully!";
    }

    /* ================= DELETE USER ================= */
    if ($_POST['action'] === 'delete') {
        $username = $_POST['username'];

        if ($username === $_SESSION['username']) {
            $_SESSION['error'] = "You cannot delete your own account!";
        } else {
            $stmt = $conn->prepare(
                "DELETE FROM users WHERE username=?"
            );
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $_SESSION['success'] = "User deleted successfully!";
        }
    }
}

header("Location: admin_dashboard.php");
exit();