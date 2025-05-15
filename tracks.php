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
        SELECT t.trackID, t.title AS track_title,
               a.albumID, a.title AS album_title,
               ar.artistID, ar.name AS artist_name
        FROM track t
        JOIN album a ON t.albumID = a.albumID
        JOIN artist ar ON a.artistID = ar.artistID
        ORDER BY t.trackID DESC
        LIMIT 20
      ");

      if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
          $trackID = $row['trackID'];

          // Fetch featured artists for this track
          $featureSQL = "
            SELECT artist.name 
            FROM feature
            JOIN artist ON feature.artistID = artist.artistID
            WHERE feature.trackID = ?
          ";
          $stmt = $conn->prepare($featureSQL);
          $stmt->bind_param("i", $trackID);
          $stmt->execute();
          $featureResult = $stmt->get_result();

          $featuredArtists = [];
          while ($f = $featureResult->fetch_assoc()) {
            $featuredArtists[] = htmlspecialchars($f['name']);
          }

          $featText = '';
          if (!empty($featuredArtists)) {
            $featText = ' <em>(feat. ' . implode(', ', $featuredArtists) . ')</em>';
          }

          // Output
          echo '<div class="list-item">';
          echo '<strong>' . htmlspecialchars($row['track_title']) . '</strong>' . $featText;
          echo ' from <a href="album.php?id=' . $row['albumID'] . '">' . htmlspecialchars($row['album_title']) . '</a>';
          echo ' by <a href="artist.php?id=' . $row['artistID'] . '">' . htmlspecialchars($row['artist_name']) . '</a>';
          echo '</div>';

          $stmt->close();
        }
      } else {
        echo "<p>No tracks available.</p>";
      }
      ?>
    </div>
  </section>
</div>

</body>
</html>
