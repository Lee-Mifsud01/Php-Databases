<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();


include 'includes/dbh.php';
include 'includes/header.php'; 
include 'includes/topbar.php';

$userID = $_SESSION['userID'] ?? null;
?>

<div class="indexpage">
  
  <!-- SECTION: Featured Artists -->
  <section class="section">
    <h2>Featured Artists</h2>
    <div class="grid">
      <?php
      $accessToken = "BQDiSVpFkDoXnO0QjMGwqiLvrXVvHO9VOyRkjkd4h8kJuD9Q4oNC8OhqruVam6lKYDgblEO9YPwArFMXxzRs50LSyIkFZfPy66UO0msY1CdlrHmr_aKxCn3ARWgG5x_jXEzU2U6wew527wxhmrOylVHdiq5j75lcnFaKpyL7jA2y5cXv9vjg4SZ2OdWWPSMMB8M5YFajd8qC1niuOSYtvnOcFsLVx2aPL9XHR1Le91JumtRHWCHK3j4u-G4";

      $result = mysqli_query($conn, "SELECT artistID, name FROM artist LIMIT 6");
      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $artistID = $row['artistID'];
          $artistName = $row['name'];
          $imageUrl = null;

          // Query Spotify API
          $query = urlencode($artistName);
          $url = "https://api.spotify.com/v1/search?q={$query}&type=artist&limit=1";

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken"
          ]);
          $response = curl_exec($ch);
          curl_close($ch);

          $spotifyData = json_decode($response, true);
          if (!empty($spotifyData['artists']['items'][0]['images'][0]['url'])) {
            $imageUrl = $spotifyData['artists']['items'][0]['images'][0]['url'];
          }

          echo '<a href="artist.php?id=' . $artistID . '" class="card-link">';
          echo '<div class="card">';
          if ($imageUrl) {
            echo '<img src="' . htmlspecialchars($imageUrl) . '" alt="Artist image" class="card-img circle">';
          } else {
            echo '<div class="card-img placeholder-shimmer circle"></div>';
          }
          echo '<p class="card-title-link">' . htmlspecialchars($artistName) . '</p>';
          echo '</div>';
          echo '</a>';

        }
      } else {
        echo '<p>No artists found.</p>';
      }
      ?>
    </div>
  </section>


 <!-- SECTION: Trending Albums -->
  <section class="section">
    <h2>Trending Albums</h2>
    <div class="grid">
      <?php
      $query = "
        SELECT a.albumID, a.title, i.url
        FROM album a
        LEFT JOIN entityimages ei ON ei.albumID = a.albumID
        LEFT JOIN image i ON ei.imageID = i.imageID
        LIMIT 6
      ";

      $result = mysqli_query($conn, $query);

      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<a href="album.php?id=' . $row['albumID'] . '" class="card-link">';
          echo '<div class="card">';
          
          if (!empty($row['url'])) {
            echo '<img src="' . htmlspecialchars($row['url']) . '" alt="Album cover" class="card-img">';
          } else {
            echo '<div class="card-img placeholder-shimmer"></div>';

          }

          echo '<p class="card-title-link">' . htmlspecialchars($row['title']) . '</p>';
          echo '</div>';
          echo '</a>';
        }
      } else {
        echo '<p>No albums found.</p>';
      }
      ?>
    </div>
  </section>




  <!-- SECTION: Recently Added Tracks -->
  <section class="section">
    <h2>Recently Added Tracks</h2>
    <div class="list track-list">
      <?php
      $result = mysqli_query($conn, "
        SELECT t.title AS track_title, a.title AS album_title
        FROM track t
        JOIN album a ON t.albumID = a.albumID
        ORDER BY t.trackID DESC LIMIT 5
      ");
      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
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
  </section>


</div>

</div> 
</div> 


</body>
</html>
