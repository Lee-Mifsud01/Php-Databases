<?php

session_start();

// TEMP: manually simulate login
if (!isset($_SESSION['userID'])) {
  $_SESSION['userID'] = 2; // use a real userID from your database
}
include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

$userID = intval($_SESSION['userid']);
?>

<div class="homepage">
  <section class="section">
    <h2>My Playlists</h2>
    <div class="grid">
      <?php
      $query = "
        SELECT playlistID, name 
        FROM playlist 
        WHERE userID = $userID
        ORDER BY name ASC
      ";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) > 0) {
        while ($playlist = mysqli_fetch_assoc($result)) {
          echo '<a href="playlist.php?id=' . $playlist['playlistID'] . '" class="card-link">';
          echo '  <div class="card">';
          echo '    <div class="card-img">🎵</div>';
          echo '    <p>' . htmlspecialchars($playlist['name']) . '</p>';
          echo '  </div>';
          echo '</a>';
        }
      } else {
        echo '<p>You haven’t created any playlists yet.</p>';
      }
      ?>
    </div>
  </section>
</div>

</div> <!-- end .main-content -->
</div> <!-- end .wrapper -->
</body>
</html>
