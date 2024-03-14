<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrars - Dashboard</title>
    <link rel="stylesheet" href="register_voters.css">
</head>
<body>
    <div class="container">
        <h1 class="heading">Register Voter</h1>
        <form id="register-voter-form" action="./actions/register.php" method="POST">
            <div class="form-group">
                <label for="voter-name">Voter Name:</label>
                <input type="text" id="voter-name" name="voter-name" required>
            </div>
            <div class="form-group">
                <label for="matric-number">Matriculation Number:</label>
                <input type="text" id="matric-number" name="matric-number" required>
            </div>
            <div class="form-group">
                <label for="student-password">Student Password:</label>
                <input type="password" id="student-password" name="student-password" required>
            </div>
            <div class="form-group">
                <button type="submit" id="register-btn" class="submit-btn">Register Voter</button>
            </div>
            <!-- Button for navigating to admin dashboard -->
            <div class="form-group">
                <button onclick="location.href='./registrar/registrar_dash.php'" class="dash-btn">Dashboard</button>
            </div>
        </form>
    </div>
</body>
</html>

