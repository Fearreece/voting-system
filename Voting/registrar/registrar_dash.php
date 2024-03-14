<?php
session_start();

// Check if logout button is clicked
if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Dashboard</title>
    <link rel="stylesheet" href="registrar_dash.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Dashboard</h1>
        <div class="options">
            <button onclick="location.href='../register_voter.php'">Add Voter</button>
            <button onclick="location.href='../view_voter.php'">View Registered Voters</button>
            <button class="logout-button" onclick="location.href='../index.php'">logout</button>
        </div>
        
    </div>
</body>
</html>
