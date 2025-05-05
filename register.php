<?php include 'includes/dbh.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | MyTunes</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
  <div class="login-container">
    <h2>Create Your MyTunes Account</h2>
    
    <form action="/auth/register.inc.php" method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      <button type="submit" name="register">Register</button>
    </form>

    <div class="login-actions">
      <a href="login.php">Already have an account? Log in</a>
    </div>
  </div>
</body>
</html>
