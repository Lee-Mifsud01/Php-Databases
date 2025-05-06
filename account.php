<?php
session_start();

if (!isset($_SESSION['userid'])) {
  header("Location: login.php");
  exit();
}

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

$userID = intval($_SESSION['userid']); 

$userQuery = mysqli_query($conn, "
  SELECT username, email, pressingID, countryID
  FROM user
  WHERE userID = $userID
  LIMIT 1
");

if (!$userQuery || mysqli_num_rows($userQuery) === 0) {
  die("User not found.");
}

$user = mysqli_fetch_assoc($userQuery);
?>

<div class="homepage">
  <section class="section">
    <h2>My Profile</h2>
    <div class="list">
      <div class="list-item"><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></div>
      <div class="list-item"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></div>
      <div class="list-item"><strong>Pressing ID:</strong> <?= htmlspecialchars($user['pressingID']) ?></div>
      <div class="list-item"><strong>Country ID:</strong> <?= htmlspecialchars($user['countryID']) ?></div>
    </div>
  </section>
</div>

</body>
</html>
