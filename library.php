<?php
session_start();
if (!isset($_SESSION['userid'])) {
  header("Location: login.php");
  exit();
}

include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';

$userID = $_SESSION['userid'];
?>

<div class="homepage">
  <section class="section">
    <h2>My Playlists</h2>
    <div class="grid">
      <?php
      $result = mysqli_query($conn, "SELECT playlistID, name FROM playlist WHERE userID = $userID");

      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<a href="playlist.php?id=' . $row['playlistID'] . '" class="card-link">';
          echo '<div class="card">';
          echo '<div class="card-img">📂</div>';
          echo '<p>' . htmlspecialchars($row['name']) . '</p>';
          echo '</div>';
          echo '</a>';
        }
      } else {
        echo "<p>You haven't created any playlists yet.</p>";
      }
      ?>
    </div>
  </section>
</div>

</div> 
</div> 
</body>
</html>
