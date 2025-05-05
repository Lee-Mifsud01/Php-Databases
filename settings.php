<?php
include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';
?>

<div class="main-content">
  <h1>Settings</h1>

  <section class="settings-section">
    <h2>Account</h2>
    <a href="profile.php" class="settings-link">Edit Login</a>
  </section>

  <section class="settings-section">
    <h2>Language</h2>
    <label for="language-select">Choose Language</label>
    <select id="language-select" class="language-dropdown">
      <option selected>English (United Kingdom)</option>
      <option>English (United States)</option>
      <option>French</option>
      <option>Spanish</option>
      <option>German</option>
    </select>
  </section>
</div>
