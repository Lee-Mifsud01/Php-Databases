<?php
session_start();
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<p>Invalid album ID.</p>";
  exit();
}

$albumID = intval($_GET['id']);

// Get album info + artist + cover image
$albumQuery = mysqli_query($conn, "
  SELECT a.title AS album_title, a.releaseDate, ar.artistID, ar.name AS artist_name, i.url AS image_url
  FROM album a
  JOIN artist ar ON a.artistID = ar.artistID
  LEFT JOIN entityimages ei ON ei.albumID = a.albumID
  LEFT JOIN image i ON ei.imageID = i.imageID
  WHERE a.albumID = $albumID
  LIMIT 1
");

if (mysqli_num_rows($albumQuery) === 0) {
  echo "<p>Album not found.</p>";
  exit();
}

$album = mysqli_fetch_assoc($albumQuery);
?>

<div class="indexpage">
  <section class="section">
    <div style="display: flex; gap: 2rem; align-items: center;">
      <?php if (!empty($album['image_url'])): ?>
        <img src="<?php echo htmlspecialchars($album['image_url']); ?>" alt="Album Cover" class="card-img" style="width: 170px; height: 170px; border-radius: 12px; box-shadow: 0 6px 12px rgba(0,0,0,0.4), 0 2px 4px rgba(0,0,0,0.25);">
      <?php else: ?>
        <div class="card-img placeholder-shimmer" style="width: 170px; height: 170px; border-radius: 12px;"></div>
      <?php endif; ?>

      <div>
        <h2><?php echo htmlspecialchars($album['album_title']); ?></h2>
        <p>By <a href="artist.php?id=<?php echo $album['artistID']; ?>" class="card-title-link">
          <?php echo htmlspecialchars($album['artist_name']); ?>
        </a></p>
        <p><?php echo htmlspecialchars($album['releaseDate']); ?></p>
      </div>
    </div>
  </section>

  <section class="section">
    <h3>Tracklist</h3>
    <div class="list track-list">
      <?php
      $trackQuery = mysqli_query($conn, "
        SELECT title FROM track
        WHERE albumID = $albumID
        ORDER BY trackID ASC
      ");

      if (mysqli_num_rows($trackQuery) > 0) {
        $i = 1;
        while ($track = mysqli_fetch_assoc($trackQuery)) {
          echo '<div class="track-btn">';
          echo '<div class="track-info">';
          echo '<strong>' . $i++ . '. ' . htmlspecialchars($track['title']) . '</strong>';
          echo '</div>';
          echo '<div class="track-actions">';
          echo '<img src="images/like-icon.png" alt="like" class="icon">';
          echo '<img src="images/queue-icon.png" alt="queue" class="icon">';
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo "<p>No tracks in this album yet.</p>";
      }
      ?>
    </div>
  </section>
</div>

</div> 
</div> 
</body>
</html>
