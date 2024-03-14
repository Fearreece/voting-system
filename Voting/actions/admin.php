<?php
session_start();

// Database credentials
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root";
$password = "";
$database = "voting system";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input
function sanitize_input($data) {
    global $conn; // Use the global $conn variable
    $data = trim($data);
    $data = mysqli_real_escape_string($conn, $data); // Use mysqli_real_escape_string to prevent SQL injection
    return $data;
}

// Retrieve user input (assuming it's coming from a form)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);

    // Query to check if user exists and credentials match
    $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // User exists and credentials are correct, perform login actions
        $_SESSION["admin"] = true; // Set admin session variable
        header("Location: ../dashboard.php"); // Redirect to the admin dashboard
        exit();
    } else {
        // Invalid username or password
        echo "<script>alert('Invalid username or password.'); window.location.href = '../admin.php';</script>";
        exit();
    }
}

// Close connection
$conn->close();
?>
