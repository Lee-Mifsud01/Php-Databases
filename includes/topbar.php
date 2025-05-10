<?php
// includes/topbar.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/spotify.php';
include_once __DIR__ . '/dbh.php';

// 1) “Currently Playing” from Spotify (or null)
$current = getCurrentlyPlaying();

// 2) Avatar lookup — default then override if user has one
$userID    = $_SESSION['userID'] ?? null;
$avatarUrl = 'images/avatar-placeholder.jpg';

if ($userID) {
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
  <!-- Left controls -->
  <div class="topbar-left">
    <button class="circle-btn" aria-label="Previous track">⏮</button>
    <button class="circle-btn" aria-label="Play/Pause">⏯</button>
    <button class="circle-btn" aria-label="Next track">⏭</button>
  </div>

  <!-- Center: currently playing -->
  <div class="track-display">
    <?php if ($current): ?>
      <img 
        src="<?= htmlspecialchars($current['album_image']) ?>" 
        alt="Album art" 
        class="track-thumbnail-image"
      >
      <div>
        <strong><?= htmlspecialchars($current['track_name']) ?></strong><br>
        <small><?= htmlspecialchars($current['artists']) ?></small>
      </div>
    <?php else: ?>
      <div class="track-placeholder">
        <em>Nothing playing</em>
      </div>
    <?php endif; ?>
  </div>

  <!-- Right: volume + profile -->
  <div class="topbar-right">
    <input type="range" min="0" max="100" value="70" aria-label="Volume">

    <div class="profile-dropdown" tabindex="0" aria-haspopup="true">
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


