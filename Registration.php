<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>
                alert('Username already exists!');
                window.location.href='login.php';
              </script>";
        exit();
    }

    // Insert only existing columns
    $query = "INSERT INTO users (username, password, role)
              VALUES ('$username', '$hashed_password', '$role')";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Registration successful as $role!');
                window.location.href='login.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: Could not register user.');
                window.location.href='register.php';
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clinic Registration</title>
  <link rel="stylesheet" href="registration_style.css">
  <link rel="stylesheet" href="header_footer.css">
</head>
<body>
  <?php include("header.php"); ?>

  <div class="main-container">
    <div class="registration-section">
      <h1>REGISTER</h1>
      <p class="registration-subtext">Create an account to access the system</p>

      <form method="POST" action="Registration.php">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <label for="role">Register as</label>
        <select id="role" name="role" required>
          <option value="Patient">Patient</option>
          <option value="HealthWorker">Health Worker</option>
          <option value="Admin">Admin</option>
        </select>
        <button type="submit" class="registration-button">Create Account</button>
      </form>
      <p>Already have an account? <a class="back-button-login" href="login.php">Login here</a></p>
    </div>

    <div class="branding-section">
      <img src="Asset/Img/Logo.png" alt="Barangay Logo" class="branding-logo-placeholder"><br>
      <h2 class="website-name">WEBSITE NAME</h2><br>
      <p class="website-slogan">website slogan???</p>
    </div>
  </div>

</body>
</html>
</html>
