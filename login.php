<?php 

?>
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
    
    <form action="includes/login-inc.php" method="POST">
      <input type="text" name="username" placeholder="Email or username" style="width: 275px;" required>
      <input type="password" name="password" placeholder="Password" style="width: 275px;" required>
      <button type="submit" name="submit">Log in</button>
    </form>

    <div class="login-actions">
      <a href="#">Forgot your password?</a>
      <a href="register.php" class="create-account-btn">Create an Account</a>
      <?php 
        // If the code in login-inc.php redirected back to this page with error codes in the QueryString,
        // we can check the values of the QueryString to show errors to the user
        if (isset($_GET["error"])){
          if($_GET["error"] == "emptyinput"){
            echo "<p>Please fill in all fields.</p>";
          }
          if($_GET["error"] == "incorrectlogin"){
            echo "<p>Login Credentials were incorrect. Please try again.</p>";
          }
        }
      ?>
    </div>
  </div>
</body>
</html>
