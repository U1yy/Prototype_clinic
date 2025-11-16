<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Login</title>
    <link rel="stylesheet" href="login_style.css">
    <link rel="stylesheet" href="header_footer.css">
</head>
<body>
    <?php
    include("connection.php");
    session_start();

    // Login handling
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $error = 'Please enter username and password.';
        } else {
            $stmt = $conn->prepare('SELECT password, role FROM users WHERE username = ?');
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($hashed_password, $role);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    // Successful login
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    // Redirect to dashboard (adjust destination as needed per role)
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $error = 'Invalid username or password.';
                }
            } else {
                $error = 'Invalid username or password.';
            }

            $stmt->close();
        }
    }

    include("header.php");
    ?>
    <div>
    <div class="main-container">
        <div class="login-section">
            <h1>LOGIN</h1>
                <br>
            <p class="login-subtext">Login to your account</p>
              <br>
            <?php if (!empty($error)) {
                // simple client alert for now
                echo "<script>window.onload = function(){ alert('" . addslashes($error) . "'); }</script>";
            } ?>

            <form action="login.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="type......">
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="type......">
                
                <button type="submit" class="login-button">Login</button>
            </form>
        </div>

        <div class="branding-section">
            <img src="Asset/Img/Stetoscope.jpg" alt="Barangay Logo" class="branding-logo-placeholder">
        </div>
    </div>
</body>
</html>