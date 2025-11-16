<?php include("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password Request</title>
  <link rel="stylesheet" href="forget_pass_style.css">
</head>
<body>

<div class="slip-box">
  <h2>Forgot Password</h2>
  <form method="POST">
    <input type="text" name="username" placeholder="Enter your username" required>
    <button type="submit" name="request_reset">Submit Request</button>
  </form>

  <?php
  if (isset($_POST['request_reset'])) {
      $username = trim($_POST['username']);

      // Check if username exists
      $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
      $check->bind_param("s", $username);
      $check->execute();
      $result = $check->get_result();

      if ($result->num_rows > 0) {
          // Success alert + redirect to login
          echo "<script>
              alert('✅ Password reset request sent! Please wait for admin to process it.');
              window.location.href = 'login.php';
          </script>";
      } else {
          // Failed alert (no account found)
          echo "<script>
              alert('⚠️ No account found with that username.');
              window.location.href = 'forgot_password.php';
          </script>";
      }
  }
  ?>
</div>

</body>
</html>
