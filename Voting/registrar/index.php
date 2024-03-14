<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voting system";

// Initialize loginSuccess variable
$loginSuccess = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get username and password from the form
    $username = $_POST['matric']; // Changed from 'matric' to 'username' for consistency
    $password = $_POST['password'];

    // Query the database to check if the provided username exists
    $sql = "SELECT * FROM registrar WHERE reg_username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Username exists, check password
        $row = $result->fetch_assoc();
        if ($row['reg_password'] === $password) {
            // Password is correct, set login success flag
            $_SESSION['reg_username'] = $row['reg_username']; // Store username in session for future use
            $loginSuccess = true;
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar - Login</title>
    <!-- Bootstrap css link-->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="maindiv">
        <h1 class='heading'>Voting Portal</h1>
        <div class="formdiv">
            <h2>Registrar Login</h2>
            <form id="loginForm" action="" method="POST">
                <div class="matric-no">
                    <label><b>Username</b> </label>
                    <input type="text" name="matric" placeholder="Enter Username" required="required">
                </div>
                <div class="password">
                    <label><b>Password:</b> </label>
                    <input type="password" name="password" placeholder="Enter your password" required="required">
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </div>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <script>
        // Check if login was successful and display alert accordingly
        var loginSuccess = <?php echo json_encode($loginSuccess); ?>;
        if (typeof loginSuccess !== 'undefined') {
            if (loginSuccess) {
                alert('Login successful. Redirecting to dashboard.');
                window.location.href = 'registrar_dash.php'; // Redirect to dashboard
            } else {
                alert('Invalid username or password.'); // Display alert for failed login
            }
        }
    </script>
    <?php endif; ?>
</body>
</html>
