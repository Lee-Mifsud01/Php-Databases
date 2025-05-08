<?php
include 'includes/dbh.php';
$userID = $_SESSION['userid'] ?? null;
?>

<aside class="sidebar">
  <div class="sidebar-top">
  <a href="home.php" class="circle-btn" title="Home"></a>
  <form class="search-bar" method="GET" action="/php-databases/search.php">
  <input type="text" name="q" placeholder="Search albums or tracks..." required />
  <button type="submit">🔍</button>
</form>

    <a href="/admin/index.php" class="admin-button">Admin Panel</a>
  </div>

  <div class="sidebar-section">
    <h3>My Library</h3>
    <ul class="sidebar-list">
      <?php
      if ($userID) {
        $result = mysqli_query($conn, "SELECT playlistID, name FROM playlist WHERE userID = $userID");
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<li><a href="/playlist.php?id=' . $row['playlistID'] . '">' . htmlspecialchars($row['name']) . '</a></li>';
        }
      }
      ?>
    </ul>
  </div>
</aside>
