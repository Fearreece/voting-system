<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Candidate - Admin Dashboard</title>
    <link rel="stylesheet" href="addcandidate.css">
</head>
<body>
    <div class="container">
        <h1 class="heading">Add Candidate</h1>
        <form id="add-candidate-form" action="./actions/addcandidate.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="candidate-name">Candidate Name:</label>
                <input type="text" id="candidate-name" name="candidate-name" required>
            </div>
            <div class="form-group">
                <label for="candidate-post">Candidate Post:</label>
                <input type="text" id="candidate-post" name="candidate-post" required>
            </div>
            <div class="form-group">
                <label for="candidate-picture">Candidate Picture (JPEG format):</label>
                <input type="file" id="candidate-picture" name="candidate-picture" accept="image/jpeg" required>
            </div>
            <div class="form-group">
                <button type="submit" class="submit-btn">Add Candidate</button>
            </div>
        </form>
        <div class="navigate-dashboard">
            <a href="dashboard.php" class="dashboard-btn">Dashboard</a>
        </div>
    </div>
</body>
</html>
