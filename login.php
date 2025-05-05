<?php include 'includes/dbh.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | MyTunes</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
  <div class="login-container">
    <h2>Login to MyTunes</h2>
    
    <form action="login.inc.php" method="post">
      <input type="text" name="username_email" placeholder="Email or username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Log in</button>
    </form>

    <div class="login-actions">
      <a href="#">Forgot your password?</a>
      <a href="register.php" class="create-account-btn">Create an Account</a>
    </div>
  </div>
</body>
</html>
