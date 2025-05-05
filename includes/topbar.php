<!-- includes/topbar.php -->
<div class="topbar">
  <div class="topbar-left">
    <button class="circle-btn"></button>
    <button>&#x1F500;</button> <!-- Shuffle -->
    <button>&#x23EE;</button> <!-- Previous -->
    <button>&#x25B6;</button> <!-- Play -->
    <button>&#x23ED;</button> <!-- Next -->
    <div class="track-display">
      <div class="track-thumbnail"></div>
      <span>Track Details</span>
    </div>
  </div>

  <div class="topbar-right">
    <div class="volume-slider">
      <input type="range" min="0" max="100">
    </div>
    <div class="profile-dropdown">
      <button class="circle-btn"></button>
      <div class="dropdown-menu">
        <a href="/pages/account.php">Account</a>
        <a href="/pages/settings.php">Settings</a>
        <a href="/pages/subscriptions.php">Subscription</a>
        <a href="/logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>
