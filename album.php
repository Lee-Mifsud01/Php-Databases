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

// Get album info + artist
$albumQuery = mysqli_query($conn, "
  SELECT a.title AS album_title, a.releaseDate, ar.artistID, ar.name AS artist_name
  FROM album a
  JOIN artist ar ON a.artistID = ar.artistID
  WHERE a.albumID = $albumID
  LIMIT 1
");

if (mysqli_num_rows($albumQuery) === 0) {
  echo "<p>Album not found.</p>";
  exit();
}

$album = mysqli_fetch_assoc($albumQuery);
?>

<div class="homepage">
  <section class="section">
    <h2><?php echo htmlspecialchars($album['album_title']); ?></h2>
    <p>By <a href="artist.php?id=<?php echo $album['artistID']; ?>" class="card-title-link">
      <?php echo htmlspecialchars($album['artist_name']); ?>
    </a></p>
    <p><strong>Released:</strong> <?php echo htmlspecialchars($album['releaseDate']); ?></p>
  </section>

  <section class="section">
    <h3>Tracklist</h3>
    <div class="list">
      <?php
      $trackQuery = mysqli_query($conn, "
        SELECT title FROM track
        WHERE albumID = $albumID
        ORDER BY trackID ASC
      ");

      if (mysqli_num_rows($trackQuery) > 0) {
        $i = 1;
        while ($track = mysqli_fetch_assoc($trackQuery)) {
          echo '<div class="list-item">';
          echo $i++ . '. ' . htmlspecialchars($track['title']);
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
