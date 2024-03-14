<?php
session_start();

// Assuming you have a database connection established
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

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the post ID from the request
    $postId = $_POST["id"];

    // Delete the post from the database
    $sql = "DELETE FROM post WHERE post_id = $postId";
    if ($conn->query($sql) === TRUE) {
        // Post deleted successfully
        mysqli_close($conn);
        header("Location: ../viewpost.php"); // Redirect to viewpost.php
        exit();
    } else {
        // Error deleting post
        http_response_code(500); // Internal server error
    }
}

// Close the database connection
mysqli_close($conn);
?>
