<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost"; // Change to your database servername
    $username = "root"; // Change to your database username
    $password = ""; // Change to your database password
    $dbname = "voting system"; // Change to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO candidates (cand_name, cand_pix, post_name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $picture, $postName);

    // Set parameters and execute
    $name = $_POST['candidate-name'];
    $picture = $_FILES['candidate-picture']['name'];
    $postName = $_POST['candidate-post']; // Add this line to retrieve the post name

    // Move uploaded file to desired location
    $target_dir = "uploads/"; // Change to your desired directory
    if (!is_dir($target_dir)) {
        mkdir($target_dir);
    }
    $target_file = $target_dir . basename($_FILES["candidate-picture"]["name"]);
    move_uploaded_file($_FILES["candidate-picture"]["tmp_name"], $target_file);

    if ($stmt->execute()) {
        echo '<script>
                    alert("New record created successfully");
                    window.location.href = "../view_candidate.php";
                </script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
