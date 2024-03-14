<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voting system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the reg_id is set in the POST request
if (isset($_POST['reg_id'])) {
    // Sanitize the registrar ID to prevent SQL injection
    $reg_id = $conn->real_escape_string($_POST['reg_id']);
    
    // SQL to delete a registrar
    $sql = "DELETE FROM registrar WHERE id = $reg_id";

    if ($conn->query($sql) === TRUE) {
        // Registrar deleted successfully
        echo "<script>alert('Registrar deleted successfully'); window.location.href = '../view_registrar.php';</script>";
    } else {
        echo "Error deleting registrar: " . $conn->error;
    }
} else {
    echo "Registrar ID not provided";
}

// Close the database connection
$conn->close();
?>
