<?php

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<p>Invalid artist ID.</p>";
  exit();
}

$artistID = intval($_GET['id']);

// Get artist info
$artistQuery = mysqli_query($conn, "
  SELECT name, description FROM artist
  WHERE artistID = $artistID
  LIMIT 1
");

if (mysqli_num_rows($artistQuery) === 0) {
  echo "<p>Artist not found.</p>";
  exit();
}

$artist = mysqli_fetch_assoc($artistQuery);
?>

<div class="homepage">
  <section class="section">
    <h2><?php echo htmlspecialchars($artist['name']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($artist['description'])); ?></p>
  </section>

  <section class="section">
    <h3>Albums by <?php echo htmlspecialchars($artist['name']); ?></h3>
    <div class="grid">
      <?php
      $albumQuery = mysqli_query($conn, "
        SELECT albumID, title FROM album
        WHERE artistID = $artistID
      ");

      if (mysqli_num_rows($albumQuery) > 0) {
        while ($album = mysqli_fetch_assoc($albumQuery)) {
          echo '<a href="album.php?id=' . $album['albumID'] . '" class="card-link">';
          echo '<div class="card">';
          echo '<div class="card-img">💿</div>';
          echo '<p>' . htmlspecialchars($album['title']) . '</p>';
          echo '</div>';
          echo '</a>';
        }
      } else {
        echo "<p>No albums found for this artist.</p>";
      }
      ?>
    </div>
  </section>
</div>

</div> 
</div> 
</body>
</html>
