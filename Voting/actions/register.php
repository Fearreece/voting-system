<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "voting system";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sample data
$voter_name = $_POST['voter-name'];
$matric_no = $_POST['matric-number'];
$voter_pass = $_POST['student-password'];

// SQL query to insert data into the table
$sql = "INSERT INTO voters (voter_name, matric_no, voter_pass) VALUES ('$voter_name', '$matric_no', '$voter_pass')";

if ($conn->query($sql) === TRUE) {
    // Success message
    echo "<script>alert('New record created successfully');</script>";
    // Redirect to view voters page
    header("Location: ../view_voter.php");
    exit; // Ensure script execution stops after redirection
} else {
    // Error message
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
