<?php
include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';
?>

<div class="homepage">
  <!-- SECTION: Featured Artists -->
  <section class="section">
    <h2>Featured Artists</h2>
    <div class="grid">
      <?php
      $result = mysqli_query($conn, "SELECT artistID, name FROM artist LIMIT 6");
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="card">';
          echo '<div class="card-img">🎤</div>';
          echo '<p>' . htmlspecialchars($row['name']) . '</p>';
          echo '</div>';
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
      $result = mysqli_query($conn, "SELECT albumID, title FROM album LIMIT 6");
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="card">';
          echo '<div class="card-img">💿</div>';
          echo '<p>' . htmlspecialchars($row['title']) . '</p>';
          echo '</div>';
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
    <div class="list">
      <?php
      $result = mysqli_query($conn, "
        SELECT t.title AS track_title, a.title AS album_title
        FROM track t
        JOIN album a ON t.albumID = a.albumID
        ORDER BY t.trackID DESC LIMIT 5
      ");
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="list-item">';
          echo '<strong>' . htmlspecialchars($row['track_title']) . '</strong>';
          echo ' from <em>' . htmlspecialchars($row['album_title']) . '</em>';
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