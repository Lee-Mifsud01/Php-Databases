<?php
session_start();
//  Redirect if user is not logged in
if (empty($_SESSION['userID'])) {
  header('Location: login.php');
  exit();
}

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

// Get search term from query string (if present)
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';
?>

<div class="indexpage">
  <section class="section">
    <h2>Search results for "<?= htmlspecialchars($searchTerm) ?>"</h2>

    <!--  SEARCH TRACKS -->
    <?php if ($searchTerm): ?>

      <h3>Tracks</h3>
      <div class="list track-list">
        <?php
        $trackResult = mysqli_query($conn, "
          SELECT t.title AS track_title, a.title AS album_title
          FROM track t
          JOIN album a ON t.albumID = a.albumID
          WHERE t.title LIKE '%" . mysqli_real_escape_string($conn, $searchTerm) . "%'
        ");

        // If results found, display each track
        if (mysqli_num_rows($trackResult) > 0) {
          while ($row = mysqli_fetch_assoc($trackResult)) {
            echo '<div class="track-btn">';
            echo '  <div class="track-info">';
            echo '    <strong>' . htmlspecialchars($row['track_title']) . '</strong>';
            echo '    <span>from <em>' . htmlspecialchars($row['album_title']) . '</em></span>';
            echo '  </div>';
            echo '  <div class="track-actions">';
            echo '    <img src="images/like-icon.png" alt="Like" class="icon">';
            echo '    <img src="images/queue-icon.png" alt="Queue" class="icon">';
            echo '  </div>';
            echo '</div>';

          }
        } else {
          echo '<p>No tracks found.</p>';
        }
        ?>
      </div>

      <!-- SEARCH ALBUMS-->
      <h3>Albums</h3>
      <div class="grid">
        <?php
        $albumResult = mysqli_query($conn, "
          SELECT DISTINCT a.albumID, a.title
          FROM album a
          LEFT JOIN track t ON a.albumID = t.albumID
          WHERE a.title LIKE '%" . mysqli_real_escape_string($conn, $searchTerm) . "%'
          OR t.title LIKE '%" . mysqli_real_escape_string($conn, $searchTerm) . "%'
        ");
      

        if (mysqli_num_rows($albumResult) > 0) {
          while ($album = mysqli_fetch_assoc($albumResult)) {
            echo '<a href="album.php?id=' . $album['albumID'] . '" class="card-link">';
            echo '<div class="card">';
            echo '<div class="card-img"></div>';
            echo '<p>' . htmlspecialchars($album['title']) . '</p>';
            echo '</div></a>';
          }
        } else {
          echo '<p>No albums found.</p>';
        }
        ?>
      </div>

    <?php else: ?>
      <!-- If no search term provided -->
      <p>Please enter a search term.</p>
    <?php endif; ?>
  </section>
</div>

</div> 
</div> 
</body>
</html>
