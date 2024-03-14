<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post - Admin Dashboard</title>
    <link rel="stylesheet" href="addpost.css">
</head>
<body>
    <div class="container">
        <h1 class="heading">Add Post</h1>
        <form id="add-post-form" method="POST" action="./actions/addpost.php">
            <div class="form-group">
                <label for="post-title">Post Title:</label>
                <input type="text" id="post-title" name="post-title" required>
            </div>
            <!-- <div class="form-group">
                <label for="post-description">Post Description:</label>
                <textarea id="post-description" name="post-description" rows="4" required></textarea>
            </div> -->
            <div class="form-group">
                <button type="submit" class="submit-btn">Add Post</button>
            </div>
        </form>
        <a href="dashboard.php" class="dashboard-link"><button class="dashboard-btn">Dashboard</button></a>
    </div>
</body>
</html>
