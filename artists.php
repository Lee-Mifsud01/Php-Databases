<?php
include 'includes/dbh.php';
include 'includes/header.php';
include 'includes/topbar.php';
?>

<div class="homepage">
  <section class="section">
    <h2>All Artists</h2>
    <div class="grid">
      <?php
      $result = mysqli_query($conn, "SELECT artistID, name FROM artist ORDER BY name");
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<a href="artist.php?id=' . $row['artistID'] . '" class="card-link">';
            echo '<div class="card">';
            echo '<div class="card-img">🎤</div>';
            echo '<p>' . htmlspecialchars($row['name']) . '</p>';
            echo '</div>';
            echo '</a>';
        }
      } else {
        echo '<p>No artists found.</p>';
      }
      ?>
    </div>
  </section>
</div>

</body>
</html>
