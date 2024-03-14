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

// Query the database for candidates with their associated post names
$sql = "SELECT c.cand_id, c.cand_name, c.cand_pix, c.post_name
        FROM candidates c";
$result = $conn->query($sql);

// Check for errors
if (!$result) {
    die("Error: " . $conn->error);
}

// Initialize an empty array to store the candidates grouped by post names
$candidates_grouped = [];

if ($result->num_rows > 0) {
    // Fetch candidates into the array and group them by post names
    while($row = $result->fetch_assoc()) {
        $post_name = $row["post_name"];
        $candidates_grouped[$post_name][] = $row;
    }
} else {
    $no_candidates_available = true;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Candidates - Admin Dashboard</title>
    <link rel="stylesheet" href="view_candidates.css">
</head>
<body>
    <div class="container">
        <h1 class="heading">View Candidates</h1>
        <?php if (isset($no_candidates_available) && $no_candidates_available): ?>
            <p>No candidates available</p>
        <?php else: ?>
            <!-- Loop through each post and display candidates under their respective headings -->
            <?php foreach ($candidates_grouped as $post_name => $post_candidates): ?>
                <div class="post-section">
                    <h2 class="post-heading"><?= htmlspecialchars($post_name) ?></h2>
                    <table class="candidate-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($post_candidates as $candidate): ?>
                                <tr class="candidate-row">
                                    <td><img src="actions/uploads/<?= isset($candidate['cand_pix']) ? htmlspecialchars($candidate["cand_pix"]) : '' ?>" alt="Candidate" class="candidate-image"></td>
                                    <td><?= htmlspecialchars($candidate["cand_name"]) ?></td>
                                    <td>
                                        <form method="post" action="./actions/delete_candidate.php">
                                            <input type="hidden" name="cand_id" value="<?= isset($candidate['cand_id']) ? htmlspecialchars($candidate["cand_id"]) : '' ?>">
                                            <button type="submit" class="delete-button">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <!-- Dashboard button -->
        <button onclick="location.href='dashboard.php'" class="dashboard-button">Dashboard</button>
    </div>
</body>
</html>
