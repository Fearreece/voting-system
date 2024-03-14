<?php
require_once __DIR__ . '/actions/viewpost.php';

$query = "select * from post";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Posts - Admin Dashboard</title>
    <link rel="stylesheet" href="viewpost.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="heading">View Posts</h1>
        <div class="post-list">
            <table id="postTable">
                <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>Post Title</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="postList">
                    <!-- Posts will be dynamically added here -->
                    <?php
                        if ($result && mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['post_id']; ?></td>
                        <td><?php echo $row['post_name']; ?></td>
                        <td>
                            <div class="delete-button">
                                <form action="./actions/deletepost.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $row['post_id']; ?>">
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    <?php
                            }
                        } else {
                    ?>
                    <tr>
                        <td colspan="3">No posts available</td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="navigate-dashboard">
            <a href="dashboard.php" class="dashboard-btn">Dashboard</a>
        </div>
    </div>
</body>
</html>
