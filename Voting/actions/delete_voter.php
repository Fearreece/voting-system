<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voting system";

// Create a new PDO instance
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Check if voter ID is provided
if(isset($_POST['voter_id'])) {
    $voter_id = $_POST['voter_id'];
    
    // Delete the voter from the database
    $sql = "DELETE FROM voters WHERE voter_id = :voter_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':voter_id', $voter_id);
    
    if($stmt->execute()) {
        // Voter deleted successfully
        echo "<script>alert('Voter deleted successfully.'); window.location.href = '../view_voter.php';</script>";
    } else {
        // Failed to delete voter
        echo "<script>alert('Failed to delete voter.'); window.location.href = '../view_voter.php';</script>";
    }
} else {
    // Redirect to view_voter.php if voter ID is not provided
    header("Location: view_voter.php");
    exit();
}
?>
