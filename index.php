<?php
// MyTunes Homepage
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();


include 'includes/dbh.php';
include 'includes/header.php'; 
include 'includes/topbar.php';
//  Store logged-in user's ID
$userID = $_SESSION['userID'] ?? null;
?>

<div class="indexpage">
  
  <!-- Featured Artists -->
  <section class="section">
    <h2>Featured Artists</h2>
    <div class="grid">
      <?php
      // Spotify Access Token (replace regularly)
      $accessToken = "BQDoLpF49OjQ4I80i1tlOuvlDetNcRgYijlsUoPhDZRzuHdlNMjVS9Mnyr7nxZJ20zmAdVD2eZ-1RmkCD0rk8fKT4HxabtLheTkKH3OMYqTTTPsv5KaRLHN9iGhuJlEmLeW8wOUmBtvGIO2EB80HZAdFmjNw5OgcQCTbCvSROJBsbhRTIT4MV21eKQgKAsKg7ZiL-0pCVBEbIQ0IWyZpARkGW8Erz-uqrbwU9wuLcg3ElosWsh-UX6-Wd2I";
      //  Pull top 6 artists from local DB
      $result = mysqli_query($conn, "SELECT artistID, name FROM artist LIMIT 6");
      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $artistID = $row['artistID'];
          $artistName = $row['name'];
          $imageUrl = null;

          /// Search artist on Spotify to get image
          $query = urlencode($artistName);
          $url = "https://api.spotify.com/v1/search?q={$query}&type=artist&limit=1";

          // Make cURL request
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken"
          ]);
          $response = curl_exec($ch);
          curl_close($ch);

          $spotifyData = json_decode($response, true);
          //  Get first image URL (if available)
          if (!empty($spotifyData['artists']['items'][0]['images'][0]['url'])) {
            $imageUrl = $spotifyData['artists']['items'][0]['images'][0]['url'];
          }

          //  Display artist card
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


 <!-- Trending Albums -->
  <section class="section">
    <h2>Trending Albums</h2>
    <div class="grid">
      <?php
      // Pull album data and cover image from entityimages
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
      //  Query most recent 5 tracks
      $result = mysqli_query($conn, "
      SELECT t.trackID, t.title AS track_title, a.title AS album_title
      FROM track t
      JOIN album a ON t.albumID = a.albumID
      ORDER BY t.trackID DESC LIMIT 5
    ");
    
    if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<a href="tracks.php?id=' . $row['trackID'] . '" class="track-link">';
        echo '  <div class="track-btn">';
        echo '    <div class="track-info">';
        echo '      <strong>' . htmlspecialchars($row['track_title']) . '</strong>';
        echo '      <span>from <em>' . htmlspecialchars($row['album_title']) . '</em></span>';
        echo '    </div>';
        echo '    <div class="track-actions">';
        echo '      <img src="images/like-icon.png" alt="Like" class="icon">';
        echo '      <img src="images/queue-icon.png" alt="Queue" class="icon">';
        echo '    </div>';
        echo '  </div>';
        echo '</a>';
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
