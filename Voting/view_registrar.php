<?php
session_start();

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

// Query the database for registrars
$sql = "SELECT id, reg_name, reg_username, reg_email FROM registrar";
$result = $conn->query($sql);

// Initialize an empty array to store the registrars
$registrars = [];

if ($result->num_rows > 0) {
    // Fetch registrars into the array
    while($row = $result->fetch_assoc()) {
        $registrars[] = $row;
    }
} else {
    $no_registrars_available = true;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registrars</title>
    <link rel="stylesheet" href="view_registrar.css">
    <style>
        .add-registrar-btn {
            background-color: #007bff; /* blue*/
            border: none;
            color: white;
            padding: 10px 10px;
            margin-top: 10px;
            margin-left: 40%;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-bottom: 10px;
            cursor: pointer;
            border-radius: 5px; /* Rounded edges */
        }

        .add-registrar-btn:hover {
            background-color: #03045E; /* Darker Green */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><b>Registrars</b></h1>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>username</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($registrars)): ?>
                    <?php foreach ($registrars as $registrar): ?>
                        <tr>
                            <td><?= htmlspecialchars($registrar['reg_name']) ?></td>
                            <td><?= htmlspecialchars($registrar['reg_email']) ?></td>
                            <td><?= htmlspecialchars($registrar['reg_username']) ?></td>
                            <td>
                                <form method="post" action="./actions/delete_registrar.php">
                                    <input type="hidden" name="reg_id" value="<?= $registrar['id'] ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No registrars available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if (!isset($no_registrars_available) || $no_registrars_available): ?>
            <button class="add-registrar-btn" onclick="location.href='add_registrar.php'">Add Registrar</button>
        <?php endif; ?>
    </div>
</body>
</html>
