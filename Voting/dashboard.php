<?php
session_start();

// Check if the user is logged in as admin
if(!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // User is not logged in as admin, display alert and then redirect to admin login page
    echo "<script>alert('You are not authorized to access this page. Please log in as an admin.'); window.location.href = 'admin.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dash_board.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h1 class="heading">Admin Dashboard</h1>
            <div class="button-container">
                <a href="addpost.php" class="dashboard-link"><button class="dashboard-btn">Add Post</button></a>
                <a href="viewpost.php" class="dashboard-link"><button class="dashboard-btn">View Post</button></a>
                <a href="addcandidate.php" class="dashboard-link"><button class="dashboard-btn">Add Candidate</button></a>
                <a href="view_candidate.php" class="dashboard-link"><button class="dashboard-btn">View Candidate</button></a>
                <a href="add_registrar.php" class="dashboard-link"><button class="dashboard-btn">Add Registrar</button></a>
                <a href="view_registrar.php" class="dashboard-link"><button class="dashboard-btn">View Registrars</button></a>
                <form action="./actions/logout.php" method="post">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
        <div class="logo-container">
            <img src="logo.png" alt="Logo" class="logo">
        </div>
    </div>
</body>
</html>

