<?php
session_start();
require '../db/config.php';

// Only allow admin
if (!isset($_SESSION['username']) || $_SESSION['category'] !== 'admin') {
    header("Location: ../php/admin_login.php");
    exit();
}

// Fetch all users for management
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- ---------- Header ---------- -->
<header class="top-header">
    <h1>Admin Dashboard</h1>
    <div>
        <a href="../home.html" class="nav-btn">Back Home</a>
        <a href="role_requests.php" class="nav-btn">Role Requests</a>
    </div>
</header>

<h2 style="text-align:center; margin-top:20px;">Manage Users</h2>

<!-- Add User Form -->
<div class="reg">
    <form method="post" action="admin_actions.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" id="admin_password" name="password" placeholder="Password" required>

<label style="font-size:14px;">
    <input type="checkbox"
           onclick="document.getElementById('admin_password').type = this.checked ? 'text' : 'password'">
    Show Password
</label>
        <select name="category">
            <option value="Student">Student</option>
            <option value="Teacher">Teacher</option>
            <option value="Teacher_Admin">Teacher_Admin</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" name="action" value="add" class="add">Add User</button>
    </form>
</div>

<!-- Users Table -->
<table>
    <tr>
        <th>Username</th>
        <th>Category</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['username']); ?></td>
        <td><?php echo htmlspecialchars($row['category']); ?></td>
        <td>
            <form method="post" action="admin_actions.php" style="display:inline;">
                <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                <select name="category">
                    <option value="Student">Student</option>
                    <option value="Teacher">Teacher</option>
                    <option value="Teacher_Admin">Teacher_Admin</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" name="action" value="edit" class="edit">Edit Role</button>
            </form>
            <form method="post" action="admin_actions.php" style="display:inline;">
                <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                <button type="submit" name="action" value="delete" class="delete">Delete</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>