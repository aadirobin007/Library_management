<?php
session_start();
include('../db/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1️⃣ Get form values
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 2️⃣ Check credentials
    $sql = "SELECT * FROM users 
            WHERE username='$username' 
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    // 3️⃣ If user exists
    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);
        $category = $row['category'];

        // 4️⃣ Store session
        $_SESSION['username'] = $row['username'];
        $_SESSION['category'] = $category;

        // 5️⃣ Redirect based on role
        if ($category === "Teacher" || $category === "Teacher_Admin") {
            header("Location: tdashboard.php");
            exit();
        } elseif ($category === "Student") {
            header("Location: sdashboard.php");
            exit();
        } else {
            echo "Invalid User Category";
        }

    } else {
        echo "Invalid Login";
    }
}
?>
