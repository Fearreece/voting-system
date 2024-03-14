<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if post title is set and not empty
    if (isset($_POST["post-title"]) && !empty($_POST["post-title"])) {
        // Validate and sanitize the input
        $post_title = htmlspecialchars($_POST["post-title"]);
        
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

        // Prepare SQL statement to insert post into the database
        $sql = "INSERT INTO post (post_name) VALUES ('$post_title')";

        if ($conn->query($sql) === TRUE) {
            // Post added successfully, redirect to viewpost.php
            header("Location: ../viewpost.php");
            exit;
        } else {
            // Error adding post
            echo "<script>alert('Error adding post: " . $conn->error . "');</script>";
        }

        // Close database connection
        $conn->close();
    } else {
        // Post title is empty
        echo "<script>alert('Post title is required!');</script>";
    }
}
?>
