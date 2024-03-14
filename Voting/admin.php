<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronic voting system</title>

    <!-- Bootstrap css link-->
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div id="maindiv">
    <h1 class='heading'>Online Voting Portal</h1>
    <div class="formdiv">
        <h2>Administrator Login</h2>
        <form action="actions/admin.php" method="POST">
            <div class="matric-no">
                <label><b>Username:</b> </label>
                <input type="text" name="username" placeholder="Enter your username" required="required">
            </div>
            <div class="password">
                <label><b>Password:</b> </label>
                <input type="password" name="password" placeholder="Enter your password" required="required">
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
    </div>
</body>
</html>