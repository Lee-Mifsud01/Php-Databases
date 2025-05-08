<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="topbar">
  <div class="topbar-left">
  <button class="circle-btn">⏮</button> <!-- Previous -->
<button class="circle-btn">⏯</button> <!-- Play/Pause -->
<button class="circle-btn">⏭</button> <!-- Next -->

  </div>

  <div class="track-display">
    <div class="track-thumbnail"></div>
    <div>
      <strong>Track</strong><br>
      <small>Details</small>
    </div>
  </div>

  <div class="topbar-right">
    <input type="range" min="0" max="100" value="70" />

    <div class="profile-dropdown">
      <button class="circle-btn"></button>
      <?php if (isset($_SESSION["username"])): ?>
        <div class="dropdown-menu">
          <a href="account.php">Account</a>
          <a href="profile.php">Profile</a>
          <a href="subscriptions.php">Subscription</a>
          <a href="settings.php">Settings</a>
          <a href="includes/logout-inc.php">Log Out</a>
        </div>
      <?php else: ?>
        <div class="dropdown-menu">
          <a href="login.php">Login</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
