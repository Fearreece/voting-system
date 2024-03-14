<!-- <?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "voting system";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the post table
$sql = "SELECT post_id, post_name FROM post";
$result = $conn->query($sql);

$posts = [];

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();

// Return the posts data as a JSON object
echo json_encode($posts);
?> -->

<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "voting system";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
