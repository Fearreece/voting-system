<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Registrar - Admin </title>
    <link rel="stylesheet" href="add_registrar.css">
</head>
<body>
    <div class="container">
        <h1 class="heading">Add Registrar</h1>
        <form id="add-registrar-form" action="./actions/addregistrar.php" method="POST">
            <div class="form-group">
                <label for="registrar-name">Registrar Name:</label>
                <input type="text" id="registrar-name" name="registrar-name" required>
            </div>
            <div class="form-group">
                <label for="registrar-email">Registrar Email:</label>
                <input type="email" id="registrar-email" name="registrar-email" required>
            </div>
            <div class="form-group">
                <label for="registrar-username">Registrar Username:</label>
                <input type="text" id="registrar-username" name="registrar-username" required>
            </div>
            <div class="form-group">
                <label for="registrar-password">Registrar Password:</label>
                <input type="password" id="registrar-password" name="registrar-password" required>
            </div>
            <div class="button-container">
                <button type="submit" class="submit-btn">Add Registrar</button>
                <a href="dashboard.php" class="dashboard-btn">Dashboard</a>
            </div>
        </form>
    </div>
</body>
</html>