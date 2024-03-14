<?php
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

// Fetch voters from the database
$sql = "SELECT * FROM voters";
$result = $conn->query($sql);

// Initialize an empty array to store voters
$voters = [];

if ($result->num_rows > 0) {
    // Fetch data and store it in the voters array
    while($row = $result->fetch_assoc()) {
        $voters[] = $row;
    }
} else {
    echo "No voters found";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registered Voters - Dashboard</title>
    <link rel="stylesheet" href="view_voter.css">
</head>
<body>
    <div class="container">
        <h1 class="heading">Registered Voters</h1>
        <div class="voter-list">
            <table>
                <thead>
                    <tr>
                        <th>Voter ID</th>
                        <th>Name</th>
                        <th>Matric No</th>
                        <th>Action</th> <!-- New column for delete button -->
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($voters as $voter): ?>
                    <tr>
                        <td><?= $voter['voter_id']; ?></td>
                        <td><?= $voter['voter_name']; ?></td>
                        <td><?= $voter['matric_no']; ?></td>
                        <td>
                            <form action="./actions/delete_voter.php" method="POST">
                                <input type="hidden" name="voter_id" value="<?= $voter['voter_id']; ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="sidebar">
        <button onclick="location.href='register_voter.php'" class="sidebar-btn">Add Voter</button>
        <button onclick="location.href='./index.php'" class="sidebar-btn">Logout</button>
        <button onclick="location.href='./registrar/registrar_dash.php'" class="dash-btn">Dashboard</button>
    </div>
</body>
</html>
