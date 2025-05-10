<?php

include 'includes/dbh.php';
$userID = $_SESSION['userID'] ?? null;
$isAdmin = false;

if ($userID) {
  $stmt = $conn->prepare("SELECT admin FROM user WHERE userID = ?");
  $stmt->bind_param("i", $userID);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    $isAdmin = $row['admin'] == 1;
  }
  $stmt->close();
}
?>

<aside class="sidebar">
  <div class="sidebar-top">
    <a href="home.php" class="circle-btn" title="Home"></a>
    <form class="search-bar" method="GET" action="/php-databases/search.php">
      <input type="text" name="q" placeholder="Search albums or tracks..." required />
      <button type="submit">🔍</button>
    </form>

    <?php if ($isAdmin): ?>
      <a href="admin.php" class="admin-button">Admin Panel</a>
    <?php endif; ?>
  </div>
  <div class="sidebar-section">
    <h3>My Library</h3>
    <ul class="sidebar-list">
      <?php if (!empty($_SESSION['userid'])): ?>
        <?php
        $ps = $conn->prepare("
          SELECT playlistID, name
            FROM playlist
           WHERE userID = ?
           ORDER BY name
        ");
        $ps->bind_param('i', $_SESSION['userid']);
        $ps->execute();
        $res = $ps->get_result();
        while ($row = $res->fetch_assoc()):
        ?>
          <li>
            <a href="library.php?playlistID=<?= $row['playlistID'] ?>">
              <?= htmlspecialchars($row['name']) ?>
            </a>
          </li>
        <?php endwhile; $ps->close(); ?>
      <?php else: ?>
        <li><em>Log in to see your playlists</em></li>
      <?php endif; ?>
    </ul>
  </div>
</aside>
