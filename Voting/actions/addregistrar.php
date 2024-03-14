<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if registrar name, email, and password are set and not empty
    if (isset($_POST["registrar-name"]) && !empty($_POST["registrar-name"])
        && isset($_POST["registrar-email"]) && !empty($_POST["registrar-email"])
        && isset($_POST["registrar-password"]) && !empty($_POST["registrar-password"])) {
        
        // Validate and sanitize the inputs
        $registrarName = htmlspecialchars($_POST["registrar-name"]);
        $registrarEmail = htmlspecialchars($_POST["registrar-email"]);
        $registrarUsername = htmlspecialchars($_POST["registrar-username"]);
        $registrarPassword = htmlspecialchars($_POST["registrar-password"]);
        
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

        try {
            // Prepare SQL statement using prepared statement
            $sql = "INSERT INTO registrar (reg_name, reg_email, reg_username, reg_password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $registrarName, $registrarEmail, $registrarUsername, $registrarPassword);
            $stmt->execute();

            // Registrar added successfully, redirect to view registrar page
            header("Location: ../view_registrar.php");
            exit;
        } catch (mysqli_sql_exception $e) {
            // Email already exists
            echo "<script>alert('This email is already registered. Please use a different email.'); window.location.href = '../add_registrar.php';</script>";
        }

        // Close statement
        $stmt->close();

        // Close database connection
        $conn->close();
    } else {
        // Registrar name, email, or password is empty
        echo "<script>alert('Registrar name, email, and password are required!');</script>";
    }
}
?>
