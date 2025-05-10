<?php
// includes/topbar.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/dbh.php';

$userID    = $_SESSION['userID'] ?? null;
$avatarUrl = 'images/avatar-placeholder.jpg';  // default

if ($userID) {
  // 1) Fetch the user’s imageID → url
  $stmt = $conn->prepare("
    SELECT i.url
      FROM `user` AS u
      LEFT JOIN `image` AS i
        ON u.imageID = i.imageID
     WHERE u.userID = ?
       AND i.url IS NOT NULL
     LIMIT 1
  ");
  $stmt->bind_param('i', $userID);
  $stmt->execute();
  $stmt->bind_result($dbUrl);
  if ($stmt->fetch()) {
    $avatarUrl = $dbUrl;
  }
  $stmt->close();
}
?>
<div class="topbar">
  <div class="topbar-left">
    <button class="circle-btn" aria-label="Previous track">⏮</button>
    <button class="circle-btn" aria-label="Play/Pause">⏯</button>
    <button class="circle-btn" aria-label="Next track">⏭</button>
  </div>

  <div class="track-display">
    <div class="track-thumbnail" aria-hidden="true"></div>
    <div>
      <strong>Track</strong><br>
      <small>Details</small>
    </div>
  </div>

  <div class="topbar-right">
    <input type="range" min="0" max="100" value="70" aria-label="Volume">

    <div class="profile-dropdown" tabindex="0" aria-haspopup="true">
      <!-- 2) Show the avatar image here -->
      <button class="circle-btn avatar-btn" aria-label="User menu">
        <img
          src="<?= htmlspecialchars($avatarUrl) ?>"
          alt="Avatar"
          class="avatar-img"
        >
      </button>

      <div class="dropdown-menu" role="menu">
        <?php if ($userID): ?>
          <a href="account.php"       role="menuitem">Account</a>
          <a href="profile.php"       role="menuitem">Profile</a>
          <a href="subscriptions.php" role="menuitem">Subscription</a>
          <a href="settings.php"      role="menuitem">Settings</a>
          <a href="includes/logout-inc.php" role="menuitem">Log Out</a>
        <?php else: ?>
          <a href="login.php"         role="menuitem">Login</a>
          <a href="register.php"      role="menuitem">Register</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
