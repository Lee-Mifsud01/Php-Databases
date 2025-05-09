<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['userID'])) {
  header("Location: login.php");
  exit();
}

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

// Get current logged-in user ID
$userID = intval($_SESSION['userID']);

// Fetch user details
$userQuery = mysqli_query($conn, "
  SELECT username, email, pressingID, countryID
  FROM user
  WHERE userID = $userID
  LIMIT 1
");

if (!$userQuery || mysqli_num_rows($userQuery) === 0) {
  echo "<p>User not found.</p>";
  exit();
}

$user = mysqli_fetch_assoc($userQuery);
?>

<div class="homepage">
  <section class="section">
    <h2>Welcome, <?= htmlspecialchars($user['username']) ?></h2>

    <div class="list">
      <div class="list-item"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></div>
      <div class="list-item"><strong>Badges:</strong> <?= htmlspecialchars($user['pressingID']) ?></div>
      <div class="list-item"><strong>Country:</strong> <?= htmlspecialchars($user['countryID']) ?></div>
    </div>

    <div class="login-actions" style="margin-top: 20px;">
      <a href="profile.php" class="button">View Profile</a>
      <a href="settings.php" class="button">Edit Settings</a>
      <a href="includes/logout-inc.php" class="button">Log Out</a>
    </div>
  </section>
</div>

</body>
</html>
