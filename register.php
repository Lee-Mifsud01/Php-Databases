<?php 
include 'includes/dbh.php'; ?>
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
    
     <!--  Registration Form -->
    <form action="includes/register-inc.php" method="post">
      <input type="text" name="username" placeholder="Username" style="width: 275px;" required>
      <input type="email" name="email" placeholder="Email" style="width: 275px;" required>
      <input type="password" name="password" placeholder="Password" style="width: 275px;" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" style="width: 275px;" required>
      <button type="submit" name="register">Register</button>
    </form>

    <!-- Error Handling
         Displays messages based on GET parameters sent back from register-inc.php -->
    <?php
      if (isset($_GET["error"])){
        if($_GET["error"] == "passwordmismatch"){
          echo "<p>Passwords do not match.</p>";
        }
        if($_GET["error"] == "invalidemail"){
          echo "<p>Email is not valid</p>";
        }
        if($_GET["error"] == "emptyfields"){
          echo "<p>Please fill in all the empty fields</p>";
        } 
        if($_GET["error"] == "usertaken"){
          echo "<p>Username is taken</p>";
        }
      }
    ?>
  <!--  Redirect to Login -->
    <div class="login-actions">
      <a href="login.php">Already have an account? Log in</a>
    </div>
  </div>
</body>
</html>
