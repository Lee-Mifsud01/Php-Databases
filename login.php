<?php
// login.php

// 1) Autoload Composer packages (Dotenv + Google Client)
require_once __DIR__ . '/vendor/autoload.php';

// 2) Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 3) Configure Google Client
$googleClient = new Google\Client();
$googleClient->setClientId(   getenv('GOOGLE_CLIENT_ID')    );
$googleClient->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
$googleClient->setRedirectUri('http://localhost:8888/php-databases/google-callback.php');
$googleClient->addScope('email');
$googleClient->addScope('profile');

// 4) Generate the OAuth URL
$googleLoginUrl = $googleClient->createAuthUrl();
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
    
    <!-- Your existing username/password form -->
    <form action="includes/login-inc.php" method="POST">
      <input type="text" name="username" placeholder="Email or username" style="width: 275px;" required>
      <input type="password" name="password" placeholder="Password" style="width: 275px;" required>
      <button type="submit" name="submit">Log in</button>
    </form>

    <div style="text-align:center; margin:1rem 0;">— OR —</div>

    <!-- New “Sign in with Google” button -->
    <div class="google-login-wrapper" style="text-align:center;">
      <a href="<?= htmlspecialchars($googleLoginUrl) ?>" class="google-btn">
        <img 
          src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" 
          alt="Sign in with Google" 
          style="max-width:240px; width:100%; cursor:pointer;"
        >
      </a>
    </div>

    <div class="login-actions">
      <a href="#">Forgot your password?</a>
      <a href="register.php" class="create-account-btn">Create an Account</a>

      <?php 
        // Display any login errors passed via the query string
        if (isset($_GET["error"])) {
          if ($_GET["error"] === "emptyinput") {
            echo "<p class='error'>Please fill in all fields.</p>";
          } elseif ($_GET["error"] === "incorrectlogin") {
            echo "<p class='error'>Login credentials were incorrect. Please try again.</p>";
          }
        }
      ?>
    </div>
  </div>
</body>
</html>
