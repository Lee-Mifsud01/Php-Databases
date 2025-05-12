<?php
session_start();
if (!isset($_SESSION['userID'])) {
  header("Location: login.php");
  exit();
}

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';
?>

<div class="indexpage">
  <section class="section">
    <h2>Recently Added Tracks</h2>
    <div class="list">
      <?php
      $query = mysqli_query($conn, "
        SELECT t.title AS track_title,
               t.trackID,
               a.albumID,
               a.title AS album_title,
               ar.artistID,
               ar.name AS artist_name
        FROM track t
        JOIN album a ON t.albumID = a.albumID
        JOIN artist ar ON a.artistID = ar.artistID
        ORDER BY t.trackID DESC
        LIMIT 20
      ");

      if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
          echo '<div class="list-item">';
          echo '<strong>' . htmlspecialchars($row['track_title']) . '</strong>';
          echo ' from <a href="album.php?id=' . $row['albumID'] . '">' . htmlspecialchars($row['album_title']) . '</a>';
          echo ' by <a href="artist.php?id=' . $row['artistID'] . '">' . htmlspecialchars($row['artist_name']) . '</a>';
          echo '</div>';
        }
      } else {
        echo "<p>No tracks available.</p>";
      }
      ?>
    </div>
  </section>
</div>

</div> 
</div> 
</body>
</html>
