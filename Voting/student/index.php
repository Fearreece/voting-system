<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "voting system"; // Change this to your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get matric number and password from the form
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    // Prepare SQL statement to fetch student details
    $sql = "SELECT * FROM voters WHERE matric_no = ? AND voter_pass = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $matric, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any row is returned
    if ($result->num_rows > 0) {
        // Student found, redirect to dashboard
        // Set session variables or perform other actions as needed
        $_SESSION['matric'] = $matric; // Example session variable

        // Redirect to dashboard
        header("Location: dashboard.php"); // Change this to the appropriate URL
        exit();
    } else {
        // Student not found, display error message
        echo "<script>alert('Invalid matric number or password');</script>";
    }

    // Close prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-voting portal - Student Login</title>

    <!-- Bootstrap css link-->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="maindiv">
    <h1 class='heading'>Online Voting Portal</h1>
    <div class="formdiv">
        <h2>Student Login</h2>
        <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="matric-no">
                <label><b>Matric-no:</b> </label>
                <input type="text" name="matric" placeholder="Enter your Matric Number" required="required">
            </div>
            <div class="password">
                <label><b>Password:</b> </label>
                <input type="password" name="password" placeholder="Enter your password" required="required">
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
    </div>

    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Get matric number and password from the form
            var matric = document.getElementsByName("matric")[0].value;
            var password = document.getElementsByName("password")[0].value;

            // Perform validation
            if (matric.trim() === "" || password.trim() === "") {
                alert("Please enter both matric number and password.");
                return;
            }

            // If validation passes, submit the form
            this.submit();
        });
    </script>
</body>
</html>
