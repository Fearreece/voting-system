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

// Check if the cand_id is set in the POST request
if (isset($_POST['cand_id'])) {
    // Sanitize the candidate ID to prevent SQL injection
    $cand_id = $conn->real_escape_string($_POST['cand_id']);
    
    // SQL to delete a candidate
    $sql = "DELETE FROM candidates WHERE cand_id = $cand_id";

    if ($conn->query($sql) === TRUE) {
        // Candidate deleted successfully
        echo "<script>alert('Candidate deleted successfully'); window.location.href = '../view_candidate.php';</script>";
    } else {
        echo "Error deleting candidate: " . $conn->error;
    }
} else {
    echo "Candidate ID not provided";
}

// Close the database connection
$conn->close();
?>
